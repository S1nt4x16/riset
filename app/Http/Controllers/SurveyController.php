<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;

class SurveyController extends Controller
{
    // Halaman awal survei
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

        return view('survey.welcome', compact('question', 'number', 'total'));
    }

    // Petunjuk survei
    public function instructions()
    {
        return view('survey.instructions');
    }

    // Tampilkan pertanyaan per step
    public function showQuestion($step_encrypted)
    {
        try {
            $step = Crypt::decryptString(hex2bin($step_encrypted));
            $step = (int) $step;
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

        $question = $questions[$step - 1];
        $options = $question->options ?? []; // Ambil dari database, default array kosong

        // Ambil jawaban sementara dari session
        $savedAnswers = session('answers', []);
        $currentAnswer = $savedAnswers[$question->id] ?? null;

        // Prepare previous step encrypted if needed
        $prevStepEncrypted = ($step > 1) ? bin2hex(Crypt::encryptString($step - 1)) : null;

        return view('survey.question', [
            'question' => $question,
            'number'   => $step,
            'total'    => $total,
            'options'  => $options,
            'currentAnswer' => $currentAnswer,
            'currentStepEncrypted' => $step_encrypted,
            'prevStepEncrypted' => $prevStepEncrypted,
        ]);
    }

    // Simpan jawaban sementara (belum ke DB)
    public function saveTempAnswer(Request $request, $step_encrypted)
    {
        try {
            $step = Crypt::decryptString(hex2bin($step_encrypted));
            $step = (int) $step;
        } catch (\Exception $e) {
            return redirect()->route('survey.welcome');
        }

        $request->validate([
            'answer' => 'required', // Bisa string atau array (checkbox)
        ]);

        $questions = \App\Models\Question::orderBy('id')->get();
        $total = $questions->count();

        $question = $questions[$step - 1];
        
        $answerValue = $request->answer;
        
        // Jika array (checkbox), gabungkan jadi string koma
        if (is_array($answerValue)) {
            $answerValue = implode(', ', $answerValue);
        }

        // Simpan ke session (format: question_id => answer)
        session()->put("answers.{$question->id}", $answerValue);

        // Kalau pertanyaan terakhir, langsung simpan semua
        if ($step == $total) {
            return app()->call([$this, 'storeAll'], ['request' => $request]);
        }

        // Kalau belum terakhir, lanjut ke pertanyaan berikutnya
        $nextStepEncrypted = bin2hex(Crypt::encryptString($step + 1));
        return redirect()->route('survey.question', ['step' => $nextStepEncrypted]);
    }

    public function storeAll(Request $request)
    {
        $answers = session('answers', []);

        if (empty($answers)) {
            return redirect()->route('survey.welcome')->with('error', 'Tidak ada jawaban untuk disimpan.');
        }

        // Buat response baru
        $response = \App\Models\Response::create([
            'respondent_code' => uniqid('resp_'),
        ]);

        // Simpan semua jawaban ke DB
        foreach ($answers as $question_id => $answer) {
            \App\Models\Answer::create([
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