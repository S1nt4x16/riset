@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, Admin!</h1>
    <p class="text-gray-600 mb-8">Kelola survei dan pantau hasil respons respondent di bawah ini.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card Pertanyaan --}}
        <div class="bg-teal-50 p-6 rounded-xl border border-teal-100">
            <h3 class="font-semibold text-teal-800 mb-2">Total Pertanyaan</h3>
            <p class="text-3xl font-bold text-teal-600 mb-4">{{ \App\Models\Question::count() }}</p>
            <a href="{{ route('admin.questions.index') }}" class="text-sm text-teal-700 font-medium hover:underline">
                Kelola Pertanyaan &rarr;
            </a>
        </div>

        {{-- Card Respon --}}
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
            <h3 class="font-semibold text-blue-800 mb-2">Total Respon</h3>
            <p class="text-3xl font-bold text-blue-600 mb-4">{{ \App\Models\Response::count() }}</p>
            <a href="{{ route('admin.responses.index') }}" class="text-sm text-blue-700 font-medium hover:underline">
                Lihat Respon &rarr;
            </a>
        </div>

        {{-- Log Out Card --}}
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <h3 class="font-semibold text-gray-800 mb-2">Sesi</h3>
            <p class="text-sm text-gray-500 mb-4">Anda sedang login sebagai {{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 font-medium hover:underline">
                    Keluar dari Admin &rarr;
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
