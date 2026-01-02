@extends('layouts.admin')

@section('title', 'Detail Pertanyaan')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('admin.questions.index') }}" class="group flex items-center text-xs font-semibold text-gray-400 hover:text-teal-600 transition-colors mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 mr-1 group-hover:-translate-x-0.5 transition-transform">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pertanyaan</h1>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.questions.edit', $question) }}" class="flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2.5 rounded-xl hover:bg-blue-100 transition-colors font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pertanyaaan ini? Langkah ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Content --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Main Info --}}
        <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Teks Pertanyaan</span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800 uppercase border border-teal-200">
                    {{ $question->type }}
                </span>
            </div>
            <div class="p-8">
                <p class="text-xl font-medium text-gray-800 leading-relaxed mb-6">"{{ $question->text }}"</p>
                
                @if($question->description)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                         <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700 font-medium">Deskripsi:</p>
                                <p class="text-sm text-yellow-700 mt-1">{{ $question->description }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Options --}}
            <div class="p-6 border-t border-gray-100">
                 <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Pilihan Jawaban</span>
                 @if($question->options)
                     <div class="space-y-3">
                         @foreach($question->options as $opt)
                             <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-gray-50">
                                 <div class="w-2 h-2 rounded-full bg-teal-400"></div>
                                 <span class="text-gray-700 font-medium">{{ $opt }}</span>
                             </div>
                         @endforeach
                     </div>
                 @else
                     <div class="flex items-center justify-center p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300 text-gray-500">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 opacity-50">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                         </svg>
                         Input Bebas (Tidak ada pilihan)
                     </div>
                 @endif
            </div>
        </div>

        {{-- Meta Info --}}
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Meta Data</h3>
                
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Section</span>
                        <div class="flex items-center gap-2">
                             <span class="bg-gray-100 text-gray-600 font-bold px-3 py-1.5 rounded-lg text-sm border border-gray-200">
                                {{ $question->section ?? '-' }}
                             </span>
                        </div>
                        @if(!$question->section)
                            <p class="text-xs text-orange-500 mt-1.5 leading-tight">
                                Belum ada section. Edit untuk menambahkan pengelompokan (Misal: "A").
                            </p>
                        @endif
                    </div>

                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Internal Key</span>
                        @if($question->key)
                            <code class="text-xs bg-gray-800 text-green-400 px-2 py-1.5 rounded block w-full text-center font-mono">
                                {{ $question->key }}
                            </code>
                            <p class="text-[10px] text-gray-400 mt-1">Digunakan untuk referensi di database/kodingan.</p>
                        @else
                            <div class="bg-gray-50 border border-gray-200 text-gray-500 px-3 py-2 rounded-lg text-xs italic text-center">
                                Tidak menggunakan internal key
                            </div>
                        @endif
                    </div>

                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Terakhir Diupdate</span>
                        <p class="text-sm font-medium text-gray-700">
                            {{ $question->updated_at->diffForHumans() }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $question->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
