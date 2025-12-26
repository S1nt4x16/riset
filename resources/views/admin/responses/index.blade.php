@extends('layouts.admin')

@section('title', 'Daftar Respon')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Respon Masuk</h1>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50">
                    <th class="p-4 border-b font-semibold text-gray-700">Waktu</th>
                    <th class="p-4 border-b font-semibold text-gray-700">Kode Responden</th>
                    <th class="p-4 border-b font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $responses = \App\Models\Response::latest()->get(); @endphp
                @forelse($responses as $response)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b text-sm text-gray-500">{{ $response->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-4 border-b font-mono text-sm">{{ $response->respondent_code }}</td>
                        <td class="p-4 border-b">
                            <a href="{{ route('admin.answers.index', $response) }}" class="bg-blue-50 text-blue-600 px-3 py-1 rounded-md text-sm hover:bg-blue-100 transition">
                                Detail Jawaban
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada respon masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
