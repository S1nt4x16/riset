@extends('layouts.app')
@section('title', 'Tambah Pertanyaan')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10">
    <h1 class="text-2xl font-bold text-teal-700 mb-6">Tambah Pertanyaan Baru</h1>

    <form method="POST" 
          action="{{ route('admin.questions.store') }}" 
          class="space-y-6"
          onsubmit="this.querySelector('button[type=submit]').disabled = true;
                    this.querySelector('button[type=submit]').classList.add('opacity-70', 'cursor-not-allowed');
                    this.querySelector('button[type=submit]').innerHTML = 'Menyimpan...';">
        @csrf

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Teks Pertanyaan</label>
            <textarea name="text" 
                      rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 resize-none focus:ring-2 focus:ring-teal-500 outline-none transition" 
                      placeholder="Masukkan teks pertanyaan..."
                      required></textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('admin.questions.index') }}" 
               class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 transition">
                Batal
            </a>

            <button type="submit" 
                    class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-700 transition font-medium">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
