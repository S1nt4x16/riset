<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use App\Models\Faculty;
use App\Models\Prodi;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;

class SurveyController extends Controller
{
    // Halaman awal survei
    public function welcome()
    {
        $questions = Question::orderBy('id')->get();
        $total = $questions->count();

        if ($total === 0) {
            return view('survey.welcome', [
                'question' => (object)['text' => 'Belum ada pertanyaan tersedia.'],
                'number' => 1,
                'total' => 1,
            ]);
        }

        $question = $questions[0];
        $number = 1;


        // Kosongkan session jawaban setiap kali mulai survei baru
        session()->forget('survey_answers');
        session()->forget('answers'); // Make sure we clear both keys if any

        $startHash = Hashids::encode(1);

        return view('survey.welcome', compact('question', 'number', 'total', 'startHash'));
    }

    // Petunjuk survei
    public function instructions()
    {
        $startHash = Hashids::encode(1);
        return view('survey.instructions', compact('startHash'));
    }

    // Tampilkan pertanyaan per step
    public function showQuestion($step_hash)
    {
        try {
            $decoded = Hashids::decode($step_hash);
            if (empty($decoded)) {
                return redirect()->route('survey.welcome');
            }
            $step = $decoded[0];
        } catch (\Exception $e) {
            return redirect()->route('survey.welcome');
        }

        $questions = Question::orderBy('id')->get();
        $total = $questions->count();

        if ($total === 0) {
            return redirect()->route('survey.welcome')->with('error', 'Belum ada pertanyaan.');
        }

        if ($step < 1 || $step > $total) {
            return redirect()->route('survey.thanks');
        }

        // --- Prevent Skipping Question Logic ---
        $savedAnswers = session('answers', []);
        $maxAllowedStep = 1;

        foreach ($questions as $index => $q) {
            if (isset($savedAnswers[$q->id])) {
                $maxAllowedStep = $index + 2;
            } else {
                break;
            }
        }

        if ($step > $maxAllowedStep) {
            $targetStep = min($maxAllowedStep, $total);
            $targetHash = Hashids::encode($targetStep);

            return redirect()->route('survey.question', ['step' => $targetHash])
                             ->with('error', 'Anda tidak dapat melewati pertanyaan. Harap isi secara berurutan.');
        }
        // ---------------------------------------

        $question = $questions[$step - 1];
        $options = $question->options ?? []; // Ambil dari database, default array kosong

        // Dynamic Options Loading
        if ($question->key === 'faculty') {
            $options = Faculty::pluck('name')->toArray();
        } 
        elseif ($question->key === 'prodi_degree') { // Combined Key
            // Find the faculty question answer from session
            $facultyQuestion = Question::where('key', 'faculty')->first();
            if ($facultyQuestion) {
                 $selectedFacultyName = session("answers.{$facultyQuestion->id}");
                 if ($selectedFacultyName) {
                     $faculty = Faculty::where('name', $selectedFacultyName)->first();
                     if ($faculty) {
                         // Build "ProdiName (DegreeName)" list
                         $options = [];
                         $prodis = $faculty->prodis()->with('degrees')->get();
                         foreach ($prodis as $prodi) {
                             foreach ($prodi->degrees as $degree) {
                                 $options[] = "{$prodi->name} ({$degree->name})";
                             }
                         }
                     }
                 }
            }
        }

        // Ambil jawaban sementara dari session
        $savedAnswers = session('answers', []);
        $currentAnswer = $savedAnswers[$question->id] ?? null;

        // Prepare previous step encrypted if needed
        $prevStepHash = ($step > 1) ? Hashids::encode($step - 1) : null;

        return view('survey.question', [
            'question' => $question,
            'number'   => $step,
            'total'    => $total,
            'options'  => $options,
            'currentAnswer' => $currentAnswer,
            'currentStepHash' => $step_hash,
            'prevStepHash' => $prevStepHash,
        ]);
    }

    // Simpan jawaban sementara (belum ke DB)
    public function saveTempAnswer(Request $request, $step_hash)
    {
        try {
            $decoded = Hashids::decode($step_hash);
            if (empty($decoded)) {
                return redirect()->route('survey.welcome');
            }
            $step = $decoded[0];
        } catch (\Exception $e) {
            return redirect()->route('survey.welcome');
        }

        $request->validate([
            'answer' => 'required', // Bisa string atau array (checkbox)
            'other_answer' => 'nullable|string|max:255',
        ]);

        $questions = Question::orderBy('id')->get();
        $total = $questions->count();

        $question = $questions[$step - 1];
        
        $answerValue = $request->answer;
        
        // Handle "Lainnya" text input
        $otherAnswerInput = $request->other_answer;
        
        if (is_array($answerValue)) {
            // Checkbox logic
            // Check if "Lainnya" is selected
            if (in_array('Lainnya', $answerValue)) {
                 // Remove "Lainnya" from array
                 $answerValue = array_diff($answerValue, ['Lainnya']);
                 // Add the custom text if provided
                 if (!empty($otherAnswerInput)) {
                     $answerValue[] = $otherAnswerInput;
                 } else {
                     // If they checked "Lainnya" but didn't type anything, maybe keep "Lainnya" or fail?
                     // Let's keep "Lainnya" if empty to be safe, or just ignore.
                     // Based on validation plan, we enforce text in frontend.
                     // Here we'll append "Lainnya: [Text]" or just [Text].
                     // User prompt implies standard "Lainnya" behavior. 
                     // Let's just store the text directly as an option.
                 }
            }
            $answerValue = implode(', ', $answerValue);
        } else {
            // Radio logic
            if ($answerValue === 'Lainnya' && !empty($otherAnswerInput)) {
                $answerValue = $otherAnswerInput;
            }
        }

        // Simpan ke session (format: question_id => answer)
        session()->put("answers.{$question->id}", $answerValue);

        // Kalau pertanyaan terakhir, langsung simpan semua
        if ($step == $total) {
            return app()->call([$this, 'storeAll'], ['request' => $request]);
        }

        // Kalau belum terakhir, lanjut ke pertanyaan berikutnya
        $nextStepHash = Hashids::encode($step + 1);
        return redirect()->route('survey.question', ['step' => $nextStepHash]);
    }

    public function storeAll(Request $request)
    {
        $answers = session('answers', []);

        if (empty($answers)) {
            return redirect()->route('survey.welcome')->with('error', 'Tidak ada jawaban untuk disimpan.');
        }

        // Buat response baru
        $response = Response::create([
            'respondent_code' => uniqid('resp_'),
        ]);

        // Simpan semua jawaban ke DB
        foreach ($answers as $question_id => $answer) {
            Answer::create([
                'response_id' => $response->id,
                'question_id' => $question_id,
                'answer' => (string) $answer,
            ]);
        }

        // Hapus session setelah selesai
        session()->forget('answers');
        return redirect()->route('survey.thanks');
    }

    public function thanks()
    {
        return view('survey.thanks');
    }
}