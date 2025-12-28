@extends('layouts.admin')
@section('title', 'Tambah Respons')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Respons Manual</h1>

<form method="POST" action="{{ route('admin.responses.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block font-semibold">Nama</label>
        <input type="text" name="nama" class="w-full border rounded p-2" required>
    </div>

    <div>
        <label class="block font-semibold">Rating</label>
        <select name="rating" class="w-full border rounded p-2" required>
            <option value="1">Kurang</option>
            <option value="2">Cukup</option>
            <option value="3">Baik</option>
            <option value="4">Sangat Baik</option>
        </select>
    </div>

    <div>
        <label class="block font-semibold">Saran</label>
        <textarea name="saran" rows="3" class="w-full border rounded p-2"></textarea>
    </div>

    <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
</form>
@endsection
