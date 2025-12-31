@extends('layouts.admin')

@section('title', 'Detail Pertanyaan')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.questions.index') }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali ke Daftar Pertanyaan</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Pertanyaan</h1>
    </div>

    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 space-y-4">
        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Section</span>
            <p class="font-medium text-gray-800">{{ $question->section ?? '-' }}</p>
        </div>

        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Teks Pertanyaan</span>
            <p class="text-lg font-bold text-teal-800">{{ $question->text }}</p>
        </div>

        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tipe Input</span>
            <span class="px-2 py-1 text-xs font-semibold rounded bg-teal-100 text-teal-800 uppercase inline-block">
                {{ $question->type }}
            </span>
        </div>

        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Deskripsi</span>
            <p class="text-gray-700 italic">{{ $question->description ?? 'Tidak ada deskripsi.' }}</p>
        </div>

        <div>
             <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilihan Jawaban (Options)</span>
             @if($question->options)
                 <ul class="list-disc list-inside space-y-1 bg-white p-4 rounded-lg border border-gray-200">
                     @foreach($question->options as $opt)
                         <li class="text-gray-700">{{ $opt }}</li>
                     @endforeach
                 </ul>
             @else
                 <p class="text-gray-500 text-sm">Tidak ada pilihan jawaban (Input bebas).</p>
             @endif
        </div>

        <div>
            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Internal Key</span>
            <code class="text-sm bg-gray-200 px-2 py-1 rounded">{{ $question->key ?? '-' }}</code>
        </div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.questions.edit', $question) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Edit Pertanyaan
        </a>
        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pertanyaaan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection
