@extends('layouts.admin')

@section('title', 'Daftar Respon')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Respon Masuk</h1>

    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse bg-white">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-5 font-semibold text-gray-600 text-sm uppercase tracking-wider">Waktu Masuk</th>
                    <th class="p-5 font-semibold text-gray-600 text-sm uppercase tracking-wider">Kode Responden</th>
                    <th class="p-5 font-semibold text-gray-600 text-sm uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php $responses = \App\Models\Response::latest()->get(); @endphp
                @forelse($responses as $response)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-5 text-sm text-gray-600">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-900">{{ $response->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400">{{ $response->created_at->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 font-mono border border-gray-200">
                                {{ $response->respondent_code }}
                            </span>
                        </td>
                        <td class="p-5 text-center">
                            <div class="flex items-center justify-center gap-3">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('admin.answers.index', $response) }}" 
                                   class="text-teal-600 hover:text-teal-800 bg-teal-50 hover:bg-teal-100 p-2 rounded-lg transition-colors group-hover:shadow-sm"
                                   title="Lihat Detail Jawaban">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.responses.destroy', $response) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data responden ini? Data jawaban juga akan terhapus permanen.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors group-hover:shadow-sm"
                                            title="Hapus Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center bg-gray-50 flex flex-col items-center justify-center text-gray-500">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-3 text-gray-300">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                             </svg>
                            <span class="text-sm font-medium">Belum ada respon responden yang masuk.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
