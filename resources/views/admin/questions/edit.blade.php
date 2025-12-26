@extends('layouts.admin')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.questions.index') }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Pertanyaan</h1>
    </div>

    <form action="{{ route('admin.questions.update', $question) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="text" class="block text-sm font-semibold text-gray-700 mb-2">Teks Pertanyaan</label>
            <textarea name="text" id="text" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>{{ old('text', $question->text) }}</textarea>
            @error('text')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="key" class="block text-sm font-semibold text-gray-700 mb-2">Key (Opsional)</label>
            <input type="text" name="key" id="key" value="{{ old('key', $question->key) }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div class="pt-4 flex gap-4">
            <button type="submit" class="flex-1 bg-teal-600 text-white font-bold py-3 rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-100">
                Update Pertanyaan
            </button>
            <a href="{{ route('admin.questions.index') }}" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition text-center">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
