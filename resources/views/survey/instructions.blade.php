@extends('layouts.app')

@section('title', 'Instructions')

@section('content')
<div class="bg-white rounded-2xl shadow-md max-w-md w-full p-8 text-center mx-auto mt-16">
    <h1 class="text-2xl font-bold mb-3">Instructions</h1>
    <p class="text-gray-600 mb-8 leading-relaxed">
        Please answer the following questions based on your own experiences.<br>
        There are no right or wrong answers — just be honest with how you feel.
    </p>

    <a href="{{ route('survey.question', ['step' => $startHash]) }}"
       class="block w-full bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition mb-3">
        Start Survey
    </a>

    <a href="{{ route('survey.welcome') }}"
       class="block w-full border border-teal-600 text-teal-600 py-2 rounded-lg hover:bg-teal-50 transition">
        Back
    </a>
</div>
@endsection
