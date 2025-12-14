@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="w-full max-w-6xl bg-white rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold text-teal-700 mb-4">Dashboard</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <a href="{{ route('admin.questions.index') }}" class="p-6 rounded-lg border hover:bg-gray-50">
            <h2 class="text-xl font-semibold mb-2">Pertanyaan</h2>
            <p class="text-gray-600">Kelola semua pertanyaan survei.</p>
        </a>

        <a href="{{ route('admin.responses.index') }}" class="p-6 rounded-lg border hover:bg-gray-50">
            <h2 class="text-xl font-semibold mb-2">Respon</h2>
            <p class="text-gray-600">Lihat semua jawaban yang masuk.</p>
        </a>
    </div>
</div>
@endsection
