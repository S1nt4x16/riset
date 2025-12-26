@extends('layouts.admin')

@section('title', 'Tambah Pertanyaan Baru')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.questions.index') }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Pertanyaan Baru</h1>
    </div>

    <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label for="text" class="block text-sm font-semibold text-gray-700 mb-2">Teks Pertanyaan</label>
            <textarea name="text" id="text" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Contoh: Apakah Anda merasa cemas hari ini?" required>{{ old('text') }}</textarea>
            @error('text')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="key" class="block text-sm font-semibold text-gray-700 mb-2">Key (Opsional - untuk logika sistem)</label>
            <input type="text" name="key" id="key" value="{{ old('key') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="e.g. anxiety_level">
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-teal-600 text-white font-bold py-3 rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-100">
                Simpan Pertanyaan
            </button>
        </div>
    </form>
</div>
@endsection
