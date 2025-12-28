<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - ' . config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f9f9f8] text-gray-900 min-h-screen flex flex-col">

    {{-- Admin Navbar --}}
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

    {{-- Konten utama --}}
    <main class="flex-1 flex justify-center py-10 px-4">
        <div class="max-w-7xl w-full">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="text-center text-gray-500 text-sm py-4 border-t">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </footer>

</body>
</html>
