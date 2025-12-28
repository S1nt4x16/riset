@extends('layouts.admin')

@section('title', 'Detail Jawaban')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <a href="{{ route('admin.responses.index') }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali ke Daftar Respon</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Jawaban - {{ $response->respondent_code }}</h1>
        <p class="text-sm text-gray-500">{{ $response->created_at->format('d F Y, H:i') }}</p>
    </div>

    <div class="space-y-6">
        @foreach($response->answers as $index => $answer)
            <div class="p-4 border-l-4 border-teal-500 bg-gray-50 rounded-r-lg">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Pertanyaan {{ $index + 1 }}</p>
                <h3 class="font-medium text-gray-900 mb-2">{{ $answer->question->text }}</h3>
                <div class="bg-white p-3 rounded border border-gray-200 text-teal-800 font-semibold">
                    {{ $answer->answer }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
