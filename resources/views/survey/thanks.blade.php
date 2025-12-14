@extends('layouts.app')

@section('title', 'Thank You')

@section('content')
<div class="bg-white rounded-2xl shadow-md max-w-md w-full p-8 text-center">
    <h1 class="text-2xl font-bold mb-4 text-teal-700">Thank You!</h1>
    <p class="text-gray-600 mb-6">Your responses have been submitted successfully.</p>
    <a href="/" class="text-teal-600 font-semibold hover:underline">Return to Home</a>
</div>
@endsection
