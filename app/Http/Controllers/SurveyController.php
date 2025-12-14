<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
                'options' => ['-']
            ]);
        }

        $question = $questions[0];
        $number = 1;
        $options = ['Tidak Pernah', 'Jarang', 'Sering', 'Selalu'];

        // Kosongkan session jawaban setiap kali mulai survei baru
        session()->forget('survey_answers');

        return view('survey.welcome', compact('question', 'number', 'total', 'options'));
    }

    // Petunjuk survei
    public function instructions()
    {
        return view('survey.instructions');
    }

    // Tampilkan pertanyaan per step
    public function showQuestion($step)
    {
        $questions = Question::orderBy('id')->get();
        $total = $questions->count();

        if ($total === 0) {
            return redirect()->route('survey.welcome')->with('error', 'Belum ada pertanyaan.');
        }

        $step = (int) $step;
        if ($step < 1 || $step > $total) {
            return redirect()->route('survey.thanks');
        }

        $question = $questions[$step - 1];
        $options = ['Tidak Pernah', 'Jarang', 'Sering', 'Selalu'];

        // Ambil jawaban sementara dari session (jika user balik ke pertanyaan sebelumnya)
        $savedAnswers = session('survey_answers', []);
        $currentAnswer = $savedAnswers[$question->id] ?? null;

        return view('survey.question', [
            'question' => $question,
            'number'   => $step,
            'total'    => $total,
            'options'  => $options,
            'currentAnswer' => $currentAnswer,
        ]);
    }

    // Simpan jawaban sementara (belum ke DB)
    public function saveTempAnswer(Request $request, $step)
{
    $request->validate([
        'answer' => 'required|string',
    ]);

    $questions = \App\Models\Question::orderBy('id')->get();
    $total = $questions->count();

    $question = $questions[$step - 1];
    session()->put("answers.{$question->id}", $request->answer);

    // Kalau pertanyaan terakhir, langsung simpan semua
    if ($step == $total) {
    // panggil langsung storeAll() tanpa lewat route GET
    return app()->call([$this, 'storeAll'], ['request' => $request]);
}

    // Kalau belum terakhir, lanjut ke pertanyaan berikutnya
    return redirect()->route('survey.question', ['step' => $step + 1]);
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
            'answer' => $answer,
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