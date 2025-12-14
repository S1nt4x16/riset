<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::with(['answers.question'])->latest()->get();
        return view('admin.responses.index', compact('responses'));
    }

    public function create()
    {
        // generate kode unik
        $code = Str::uuid();
        return view('admin.responses.create', compact('code'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'respondent_code' => 'required|string|unique:responses,respondent_code',
        ]);

        Response::create($request->only('respondent_code'));
        return redirect()->route('responses.index')->with('success', 'Responden berhasil ditambahkan.');
    }

    public function show(Response $response)
    {
        $response->load('answers.question');
        return view('admin.responses.show', compact('response'));
    }

    public function destroy(Response $response)
    {
        $response->delete();
        return redirect()->route('admin.responses.index')->with('success', 'Data responden dihapus.');
    }
}
