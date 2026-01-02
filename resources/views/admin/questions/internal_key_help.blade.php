@extends('layouts.admin')

@section('title', 'Penjelasan Internal Key')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Apa itu Internal Key?</h1>
    </div>

    <div class="prose text-gray-600 space-y-4">
        <p>
            <strong>Internal Key</strong> adalah identitas unik (kode) yang digunakan oleh sistem/kodingan untuk mengenali pertanyaan tertentu secara spesifik.
            Ini berbeda dengan "Teks Pertanyaan" yang dibaca oleh manusia.
        </p>

        <h3 class="text-lg font-bold text-gray-800">Kapan harus menggunakannya?</h3>
        <ul class="list-disc list-inside bg-gray-50 p-4 rounded-lg">
            <li>Saat pertanyaan membutuhkan <strong>data otomatis dari database</strong> (contoh: Pilihan Fakultas).</li>
            <li>Saat pertanyaan menjadi <strong>pemicu filter</strong> untuk pertanyaan lain (contoh: Memilih Fakultas "A" akan memfilter Prodi hanya untuk "A").</li>
            <li>Saat jawaban pertanyaan ini akan digunakan untuk <strong>logika percabangan</strong> yang kompleks di kodingan.</li>
        </ul>

        <h3 class="text-lg font-bold text-gray-800">Daftar Key yang Tersedia:</h3>
        <div class="grid gap-4">
            <div class="border p-4 rounded-lg">
                <code class="bg-gray-200 px-2 py-1 rounded text-teal-700 font-bold">faculty</code>
                <p class="text-sm mt-1">Mengambil daftar Fakultas dari database secara otomatis.</p>
            </div>
            <div class="border p-4 rounded-lg">
                <code class="bg-gray-200 px-2 py-1 rounded text-teal-700 font-bold">prodi_degree</code>
                <p class="text-sm mt-1">Mengambil daftar Prodi & Jenjang yang terfilter otomatis berdasarkan Fakultas yang dipilih sebelumnya.</p>
            </div>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
            <p class="text-sm text-yellow-800">
                <strong>Catatan:</strong> Untuk pertanyaan survei biasa (seperti Nama, Usia, Hobi, Pendapat), biarkan Internal Key <strong>KOSONG</strong> (Tidak menggunakan key).
            </p>
        </div>
    </div>
</div>
@endsection
