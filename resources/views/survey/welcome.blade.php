@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="bg-white rounded-2xl shadow-md max-w-md w-full p-8 text-center">
    <h1 class="text-2xl font-bold mb-3">Mental Health Survey</h1>
    <p class="text-gray-600 mb-8">
        A survey to understand the mental health of students.
    </p>

    {{-- Tombol langsung ke pertanyaan pertama --}}
    <a href="{{ route('survey.question', ['step' => 1]) }}"
       class="block w-full bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition mb-3">
        Start Survey
    </a>

    {{-- Tombol ke halaman petunjuk --}}
    <a href="{{ route('survey.instructions') }}"
       class="block w-full border border-teal-600 text-teal-600 py-2 rounded-lg hover:bg-teal-50 transition">
        Instructions
    </a>
</div>
@endsection
