<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f9f9f8] text-gray-900 min-h-screen flex flex-col">

    {{-- Topbar dihapus sesuai permintaan agar sesi admin tidak terlihat --}}

    {{-- Konten utama --}}
    <main class="flex-1 flex justify-center items-center py-10 px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center text-gray-500 text-sm py-4 border-t">
