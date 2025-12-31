<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(Response $response)
    {
        return view('admin.answers.index', compact('response'));
    }

    public function create(Response $response)
    {
        $questions = Question::all();
        return view('answers.create', compact('questions', 'response'));
    }

    public function store(Request $request, Response $response)
    {
        foreach ($request->answers as $questionId => $answerText) {
            Answer::updateOrCreate(
                ['response_id' => $response->id, 'question_id' => $questionId],
                ['answer' => $answerText]
            );
        }

        return redirect()->route('responses.show', $response)->with('success', 'Jawaban berhasil disimpan.');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();
        return back()->with('success', 'Jawaban dihapus.');
    }
}
