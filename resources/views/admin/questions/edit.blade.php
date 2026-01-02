@extends('layouts.admin')

@section('title', 'Edit Pertanyaan')

@section('content')

<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto" x-data="editQuestionForm()">
    <div class="mb-6">
        <a href="{{ route('admin.questions.index') }}" class="text-sm text-teal-600 hover:underline">&larr; Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Pertanyaan</h1>
    </div>

    <form action="{{ route('admin.questions.update', $question) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Section Input with Toggle --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Section</label>
                
                <div x-show="!isNewSection">
                    <div class="flex gap-2">
                        <select name="section" x-model="section" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white">
                            <option value="">-- Pilih Section --</option>
                            @foreach($sections as $sec)
                                <option value="{{ $sec }}">{{ $sec }}</option>
                            @endforeach
                        </select>
                        <button type="button" @click="isNewSection = true" class="bg-teal-50 text-teal-700 px-3 rounded-lg border border-teal-200 hover:bg-teal-100 text-sm font-medium whitespace-nowrap" title="Buat Section Baru">
                            + Baru
                        </button>
                    </div>
                </div>

                <div x-show="isNewSection" class="hidden" :class="{ 'hidden': !isNewSection }">
                    <div class="flex gap-2">
                        <input type="text" name="section" x-model="customSection" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Nama Section Baru...">
                        <button type="button" @click="isNewSection = false" class="bg-gray-100 text-gray-600 px-3 rounded-lg border border-gray-300 hover:bg-gray-200 text-sm font-medium whitespace-nowrap">
                            Batal
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Ketik nama section baru (Misal: "E. Penutup")</p>
                </div>
            </div>

            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Tipe Input</label>
                <select name="type" id="type" x-model="type" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="radio">Radio (Satu Pilihan)</option>
                    <option value="checkbox">Checkbox (Banyak Pilihan)</option>
                    <option value="text">Text (Tulisan)</option>
                    <option value="number">Number (Angka/IPK)</option>
                    <option value="select">Select (Dropdown)</option>
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

        {{-- Internal Key Logic --}}
        <div>
            <div class="flex items-center gap-2 mb-2">
                <label class="block text-sm font-semibold text-gray-700">Internal Key (Opsional)</label>
                <a href="{{ route('admin.questions.help') }}" target="_blank" class="text-teal-600 hover:text-teal-800 transition-colors" title="Penjelasan Internal Key">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                      <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-1">
                    <select x-model="keyMode" class="w-full border border-gray-300 rounded-lg p-3 text-sm">
                        <option value="none">Tidak Pakai</option>
                        <option value="faculty">Faculty</option>
                        <option value="prodi_degree">Prodi & Degree</option>
                        <option value="custom">Custom (Lainnya)</option>
                    </select>
                </div>
                <!-- Hidden Input for Form Submission -->
                <input type="hidden" name="key" :value="finalKey">

                <div class="col-span-2">
                     <input type="text" x-model="customKey" x-show="keyMode === 'custom'" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Ketik key manual e.g. 'hobi_user'">
                     <div x-show="keyMode !== 'custom'" class="w-full border border-gray-100 bg-gray-50 rounded-lg p-3 text-gray-500 italic text-sm">
                         <span x-text="keyMode === 'none' ? 'Key akan dikosongkan (null)' : 'Menggunakan key: ' + keyMode"></span>
                     </div>
                </div>
            </div>
        </div>

        <div x-show="['radio', 'checkbox', 'select'].includes(type)" class="hidden" :class="{ 'hidden': !['radio', 'checkbox', 'select'].includes(type) }">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilihan Jawaban (Options)</label>
            <div class="space-y-2 mb-3">
                <template x-for="(opt, index) in options" :key="index">
                    <div class="flex items-center gap-2">
                        <input type="text" name="options[]" x-model="options[index]" class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-teal-500" placeholder="Pilihan...">
                        <button type="button" class="text-red-500 hover:text-red-700 font-bold px-2" @click="removeOption(index)">×</button>
                    </div>
                </template>
            </div>
            <button type="button" @click="addOption()" class="text-sm bg-gray-100 text-teal-700 px-3 py-1 rounded hover:bg-gray-200 font-medium">
                + Tambah Pilihan
            </button>
            <button type="button" @click="addOption('Lainnya')" class="text-sm bg-orange-50 text-orange-700 px-3 py-1 rounded hover:bg-orange-100 font-medium ml-2">
                + Tambah "Lainnya"
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

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function editQuestionForm() {
            // Initial Data
            const initialKey = @json($question->key);
            const initialSection = @json($question->section);
            const initialOptions = @json($question->options ?? []);
            
            // Determine Key Mode
            let initKeyMode = 'none';
            let initCustomKey = '';
            
            if (initialKey) {
                if (['faculty', 'prodi_degree'].includes(initialKey)) {
                    initKeyMode = initialKey;
                } else {
                    initKeyMode = 'custom';
                    initCustomKey = initialKey;
                }
            }

            return {
                isNewSection: false,
                section: initialSection,
                customSection: '',
                type: '{{ old('type', $question->type) }}',
                
                keyMode: initKeyMode,
                customKey: initCustomKey,
                
                options: initialOptions.length > 0 ? initialOptions : [''],

                get finalKey() {
                    if (this.keyMode === 'none') return '';
                    if (this.keyMode === 'custom') return this.customKey;
                    return this.keyMode;
                },

                addOption(val = '') {
                    this.options.push(val);
                },
                removeOption(index) {
                    this.options.splice(index, 1);
                }
            }
        }
    </script>
</div>
@endsection

