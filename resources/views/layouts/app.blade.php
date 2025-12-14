<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f9f9f8] text-gray-900 min-h-screen flex flex-col">

    {{-- Navbar (aktif kalau user login / admin area) --}}
    @auth
        <nav class="bg-white border-b shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3">
                <h1 class="font-bold text-lg text-teal-700">Admin Dashboard</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Dashboard</a>
                    <a href="{{ route('admin.questions.index') }}" class="hover:text-teal-600">Pertanyaan</a>
                    <a href="{{ route('admin.responses.index') }}" class="hover:text-teal-600">Respon</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    @endauth

    {{-- Konten utama --}}
    <main class="flex-1 flex justify-center items-center py-10 px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center text-gray-500 text-sm py-4 border-t">
