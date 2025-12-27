<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'type' => 'required|string|in:text,number,radio,checkbox,select',
            'section' => 'nullable|string|max:10',
            'key' => 'nullable|string|unique:questions,key',
            'description' => 'nullable|string',
            'options' => 'nullable|array',
        ]);

        Question::create($request->all());

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string',
            'type' => 'required|string|in:text,number,radio,checkbox,select',
            'section' => 'nullable|string|max:10',
            'key' => 'nullable|string|unique:questions,key,' . $question->id,
            'description' => 'nullable|string',
            'options' => 'nullable|array',
        ]);

        $question->update($request->all());

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan dihapus.');
    }
}
