<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        $sections = Question::select('section')->distinct()->whereNotNull('section')->pluck('section');
        return view('admin.questions.index', compact('questions', 'sections'));
    }

    public function create()
    {
        $sections = Question::select('section')->distinct()->whereNotNull('section')->pluck('section');
        return view('admin.questions.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'type' => 'required|string|in:text,number,radio,checkbox,select',
            'section' => 'nullable|string|max:255',
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
        $sections = Question::select('section')->distinct()->whereNotNull('section')->pluck('section');
        return view('admin.questions.edit', compact('question', 'sections'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string',
            'type' => 'required|string|in:text,number,radio,checkbox,select',
            'section' => 'nullable|string|max:255',
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
