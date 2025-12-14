@extends('layouts.app')

@section('title', 'Daftar Pertanyaan')

@section('content')
<div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-teal-700">Daftar Pertanyaan</h1>
        <a href="{{ route('admin.questions.create') }}"
           class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-xl transition-all shadow-sm">
           + Tambah Pertanyaan
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead class="bg-teal-50 text-teal-800">
            <tr>
                <th class="p-3 font-semibold text-sm">#</th>
                <th class="p-3 font-semibold text-sm">Pertanyaan</th>
                <th class="p-3 text-right font-semibold text-sm">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($questions as $q)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $q->text }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('admin.questions.edit', $q->id) }}"
                           class="text-teal-600 hover:text-teal-800 font-medium">Edit</a>

                        <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($questions->isEmpty())
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada pertanyaan.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
