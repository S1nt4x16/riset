@extends('layouts.admin')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.questions.index') }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Pertanyaan</h1>
    </div>

    <form action="{{ route('admin.questions.update', $question) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="section" class="block text-sm font-semibold text-gray-700 mb-2">Section</label>
                <input type="text" name="section" id="section" value="{{ old('section', $question->section) }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="e.g. A, B, atau C">
            </div>
            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Tipe Input</label>
                <select name="type" id="type" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="radio" {{ old('type', $question->type) == 'radio' ? 'selected' : '' }}>Radio (Satu Pilihan)</option>
                    <option value="checkbox" {{ old('type', $question->type) == 'checkbox' ? 'selected' : '' }}>Checkbox (Banyak Pilihan)</option>
                    <option value="text" {{ old('type', $question->type) == 'text' ? 'selected' : '' }}>Text (Tulisan)</option>
                    <option value="number" {{ old('type', $question->type) == 'number' ? 'selected' : '' }}>Number (Angka/IPK)</option>
                    <option value="select" {{ old('type', $question->type) == 'select' ? 'selected' : '' }}>Select (Dropdown)</option>
                </select>
            </div>
        </div>

        <div>
            <label for="text" class="block text-sm font-semibold text-gray-700 mb-2">Teks Pertanyaan</label>
            <textarea name="text" id="text" rows="2" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>{{ old('text', $question->text) }}</textarea>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="2" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('description', $question->description) }}</textarea>
        </div>

        <div>
            <label for="key" class="block text-sm font-semibold text-gray-700 mb-2">Internal Key (Opsional)</label>
            <input type="text" name="key" id="key" value="{{ old('key', $question->key) }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <div id="options-container" class="hidden">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilihan Jawaban (Options)</label>
            <div id="options-list" class="space-y-2 mb-3">
                @if($question->options)
                    @foreach($question->options as $opt)
                        <div class="flex items-center gap-2">
                            <input type="text" name="options[]" value="{{ $opt }}" class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-teal-500">
                            <button type="button" class="text-red-500 hover:text-red-700 font-bold px-2" onclick="this.parentElement.remove()">×</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" id="add-option" class="text-sm bg-gray-100 text-teal-700 px-3 py-1 rounded hover:bg-gray-200 font-medium">
                + Tambah Pilihan
            </button>
        </div>

        <div class="pt-4 flex gap-4">
            <button type="submit" class="flex-1 bg-teal-600 text-white font-bold py-3 rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-100">
                Update Pertanyaan
            </button>
            <a href="{{ route('admin.questions.index') }}" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition text-center">
                Batal
            </a>
        </div>
    </form>

    <script>
        const typeSelect = document.getElementById('type');
        const optionsContainer = document.getElementById('options-container');
        const optionsList = document.getElementById('options-list');
        const addOptionBtn = document.getElementById('add-option');

        function toggleOptions() {
            const needsOptions = ['radio', 'checkbox', 'select'].includes(typeSelect.value);
            optionsContainer.classList.toggle('hidden', !needsOptions);
        }

        function createOptionInput(value = '') {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';
            div.innerHTML = `
                <input type="text" name="options[]" value="${value}" class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-teal-500" placeholder="Pilihan...">
                <button type="button" class="text-red-500 hover:text-red-700 font-bold px-2" onclick="this.parentElement.remove()">×</button>
            `;
            optionsList.appendChild(div);
        }

        typeSelect.addEventListener('change', toggleOptions);
        addOptionBtn.addEventListener('click', () => createOptionInput());

        // Inisialisasi
        toggleOptions();
    </script>
</div>
@endsection
