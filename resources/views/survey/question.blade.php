@extends('layouts.app')

@section('title', 'Pertanyaan ' . $number)

@section('content')
<div class="max-w-4xl w-full mx-auto bg-white shadow-xl rounded-[20px] p-8 md:p-12 border border-gray-100" style="border-radius: 20px;">
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm font-semibold tracking-wide text-teal-600 uppercase">Pertanyaan {{ $number }} dari {{ $total }}</p>
        <div class="text-xs font-bold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ round(($number / $total) * 100) }}% Selesai</div>
    </div>

    {{-- Progress Bar --}}
    <div class="w-full bg-gray-100 rounded-full h-2 mb-10 overflow-hidden">
        <div class="bg-teal-500 h-2 rounded-full transition-all duration-500 ease-out" style="width: {{ ($number / $total) * 100 }}%"></div>
    </div>

    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 leading-snug">{{ $question->text }}</h2>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($question->description)
        <p class="text-gray-500 mb-8">{{ $question->description }}</p>
    @else
        <div class="mb-8"></div>
    @endif
    
    {{-- Custom Validation Alert --}}
    <div id="validation-alert" class="hidden mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm transition-all duration-300 transform origin-top">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-700" id="validation-message">Harap isi pertanyaan ini sebelum melanjutkan.</p>
            </div>
        </div>
    </div>

    <form id="survey-form" action="{{ route('survey.temp.store', $currentStepHash) }}" method="POST" novalidate>
        @csrf
        <div class="space-y-5">
            {{-- RADIO BUTTON --}}
            @if($question->type === 'radio')
                @foreach($options as $option)
                    <label class="group flex items-center gap-6 p-5 border-2 rounded-2xl cursor-pointer transition-all duration-200 hover:border-teal-500 hover:bg-teal-50 {{ isset($currentAnswer) && $currentAnswer == $option ? 'border-teal-500 bg-teal-50 ring-1 ring-teal-500' : 'border-gray-200' }} mb-4">
                        <div class="relative flex items-center justify-center flex-shrink-0 w-6 h-6">
                            <input 
                                type="radio" 
                                name="answer" 
                                value="{{ $option }}"
                                {{ isset($currentAnswer) && $currentAnswer == $option ? 'checked' : '' }}
                                class="peer appearance-none w-6 h-6 border-2 border-gray-300 rounded-full checked:border-teal-600 checked:bg-teal-600 focus:ring-offset-2 focus:ring-teal-500 transition-colors"
                            >
                            <div class="absolute w-2.5 h-2.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-lg text-gray-700 font-medium group-hover:text-teal-800">{{ $option }}</span>
                    </label>
                @endforeach

            {{-- CHECKBOX --}}
            @elseif($question->type === 'checkbox')
                @php 
                    $selectedAnswers = isset($currentAnswer) ? explode(', ', $currentAnswer) : [];
                @endphp
                @foreach($options as $option)
                    <div class="mb-4">
                        <label class="group flex items-center gap-6 p-5 border-2 rounded-2xl cursor-pointer transition-all duration-200 hover:border-teal-500 hover:bg-teal-50 {{ in_array($option, $selectedAnswers) ? 'border-teal-500 bg-teal-50 ring-1 ring-teal-500' : 'border-gray-200' }}">
                             <div class="relative flex items-center justify-center flex-shrink-0 w-6 h-6">
                                <input 
                                    type="checkbox" 
                                    name="answer[]" 
                                    value="{{ $option }}"
                                    {{ in_array($option, $selectedAnswers) ? 'checked' : '' }}
                                    class="peer appearance-none w-6 h-6 border-2 border-gray-300 rounded-md checked:border-teal-600 checked:bg-teal-600 focus:ring-offset-2 focus:ring-teal-500 transition-colors checkbox-option"
                                    data-is-other="{{ $option === 'Lainnya' ? 'true' : 'false' }}"
                                >
                                <svg class="absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-lg text-gray-700 font-medium group-hover:text-teal-800">{{ $option }}</span>
                        </label>
                        
                        @if($option === 'Lainnya')
                            <div id="other-input-container" class="hidden ml-12 mt-2">
                                <input 
                                    type="text" 
                                    name="other_answer" 
                                    id="other-answer-input"
                                    placeholder="Silakan tulis di sini..."
                                    class="w-full text-lg border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-teal-500 focus:ring-teal-500 transition-colors"
                                >
                            </div>
                        @endif
                    </div>
                @endforeach

            {{-- TEXT INPUT --}}
            @elseif($question->type === 'text')
                <div class="relative">
                    <input 
                        type="text" 
                        name="answer" 
                        class="w-full mb-4 text-lg border-2 border-gray-300 rounded-2xl shadow-sm focus:border-teal-500 focus:ring-teal-500 px-5 py-4 transition-colors placeholder-gray-400"
                        value="{{ $currentAnswer ?? '' }}"
                        placeholder="Ketik jawaban Anda di sini..."
                    >
                </div>

            {{-- NUMBER INPUT --}}
            @elseif($question->type === 'number')
                @php
                    $isIpk = Illuminate\Support\Str::contains(strtolower($question->text), ['ipk', 'indeks prestasi']);
                @endphp
                <div class="relative">
                    <input 
                        type="number" 
                        name="answer" 
                        class="w-full mb-4 text-lg border-2 border-gray-300 rounded-2xl shadow-sm focus:border-teal-500 focus:ring-teal-500 px-5 py-4 transition-colors placeholder-gray-400"
                        value="{{ $currentAnswer ?? '' }}"
                        placeholder="{{ $isIpk ? 'Contoh: 3.50' : 'Contoh: 20' }}"
                        @if($isIpk) max="4" min="0" step="0.01" @endif
                        id="input-number"
                    >
                    @if($isIpk)
                        <p class="mt-2 text-sm text-gray-500">Maksimal IPK adalah 4.00</p>
                    @endif
                </div>

            {{-- SELECT DROPDOWN --}}
            @elseif($question->type === 'select')
                <div class="relative">
                    <select 
                        name="answer" 
                        class="w-full text-lg appearance-none bg-white border-2 border-gray-300 rounded-2xl shadow-sm focus:border-teal-500 focus:ring-teal-500 px-5 py-4 pr-10 transition-colors cursor-pointer"
                    >
                        <option value="" disabled selected>Pilih salah satu...</option>
                        @foreach($options as $option)
                            <option value="{{ $option }}" {{ isset($currentAnswer) && $currentAnswer == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center mt-20 pt-10 border-t border-gray-100 mt-4 pt-4">
            @if ($prevStepHash)
                <a href="{{ route('survey.question', $prevStepHash) }}" 
                   class="flex items-center text-gray-500 hover:text-teal-600 font-medium px-4 py-3 rounded-xl hover:bg-teal-50 transition-colors group">
                    Sebelumnya
                </a>
            @else
                <span></span> 
            @endif

            <button type="submit" 
                class="bg-teal-600 text-white text-lg font-semibold px-4 py-3 rounded-xl hover:bg-teal-700 active:bg-teal-800 shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center">
                <span>{{ $number == $total ? 'Selesai' : 'Selanjutnya' }}</span>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('survey-form');
        const alertBox = document.getElementById('validation-alert');
        const alertMessage = document.getElementById('validation-message');
        
        // Handle "Lainnya" toggle
        const checkboxes = document.querySelectorAll('.checkbox-option');
        const otherInputContainer = document.getElementById('other-input-container');
        const otherInput = document.getElementById('other-answer-input');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (this.dataset.isOther === 'true') {
                    if (this.checked) {
                        otherInputContainer.classList.remove('hidden');
                        otherInput.focus();
                    } else {
                        otherInputContainer.classList.add('hidden');
                        otherInput.value = ''; // Clear value when unchecked
                    }
                }
            });
        });

        // Initial check for 'Lainnya' on load (if validation failed and returned)
        const otherCheckbox = Array.from(checkboxes).find(cb => cb.dataset.isOther === 'true');
        if (otherCheckbox && otherCheckbox.checked) {
            otherInputContainer.classList.remove('hidden');
        }

        form.addEventListener('submit', function(e) {
            let isValid = false;
            let errorMessage = "Harap isi pertanyaan ini sebelum melanjutkan.";
            let isSpecificError = false;
            
            // Get all inputs
            const radios = form.querySelectorAll('input[type="radio"]');
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            const textInputs = form.querySelectorAll('input[type="text"]:not(#other-answer-input), input[type="number"]');
            const selects = form.querySelectorAll('select');

            // Check Radio
            if (radios.length > 0) {
                for (const r of radios) {
                    if (r.checked) {
                        isValid = true;
                        break;
                    }
                }
            }
            // Check Checkbox
            else if (checkboxes.length > 0) {
                let isOtherChecked = false;
                for (const c of checkboxes) {
                    if (c.checked) {
                        isValid = true;
                        if (c.dataset.isOther === 'true') {
                            isOtherChecked = true;
                        }
                    }
                }
                
                // If options selected but includes 'Other', enforce text input
                if (isValid && isOtherChecked) {
                    if (!otherInput.value.trim()) {
                        isValid = false;
                        errorMessage = "Harap isi bagian 'Lainnya' dengan keterangan.";
                        isSpecificError = true;
                    }
                }
            }
            // Check Text/Number
            else if (textInputs.length > 0) {
                for (const i of textInputs) {
                    if (i.value.trim() !== '') {
                         // Specific IPK validation
                         if (i.type === 'number' && i.hasAttribute('max')) {
                            const val = parseFloat(i.value);
                            const max = parseFloat(i.getAttribute('max'));
                            
                            if (val > max) {
                                isValid = false;
                                errorMessage = "Validasi Gagal: Nilai IPK tidak boleh lebih dari " + max;
                                isSpecificError = true;
                                break; 
                            } else if (val < 0) {
                                isValid = false;
                                errorMessage = "Validasi Gagal: Nilai tidak boleh negatif";
                                isSpecificError = true;
                                break;
                            } else {
                                isValid = true;
                            }
                         } else {
                             isValid = true;
                         }
                    }
                }
            }
            // Check Select
            else if (selects.length > 0) {
                for (const s of selects) {
                    if (s.value && s.value !== "") {
                        isValid = true;
                        break;
                    }
                }
            }

            if (!isValid) {
                e.preventDefault();
                
                if (isSpecificError) {
                    alert(errorMessage);
                } else {
                    alertMessage.textContent = errorMessage;
                    alertBox.classList.remove('hidden');
                    alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                alertBox.classList.add('hidden');
            }
        });
    });
</script>
@endsection
