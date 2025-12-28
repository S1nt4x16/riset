@extends('layouts.admin')

@section('title', 'Daftar Pertanyaan')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pertanyaan</h1>
        <a href="{{ route('admin.questions.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">
            + Tambah Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50">
                    <th class="p-4 border-b font-semibold text-gray-700">No</th>
                    <th class="p-4 border-b font-semibold text-gray-700">Tipe</th>
                    <th class="p-4 border-b font-semibold text-gray-700">Teks Pertanyaan</th>
                    <th class="p-4 border-b font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $index => $question)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b">{{ $index + 1 }}</td>
                        <td class="p-4 border-b">
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-teal-100 text-teal-800 uppercase">
                                {{ $question->type ?? 'radio' }}
                            </span>
                        </td>
                        <td class="p-4 border-b">{{ $question->text }}</td>
                        <td class="p-4 border-b flex gap-2">
                            <a href="{{ route('admin.questions.edit', $question) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500 italic">Belum ada pertanyaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
