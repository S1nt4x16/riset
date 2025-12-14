@extends('layouts.app')

@section('title', 'Pertanyaan ' . $number)

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10">
    <p class="text-sm text-gray-500 mb-4">Pertanyaan {{ $number }} dari {{ $total }}</p>

    <h2 class="text-xl font-semibold mb-6">{{ $question->text }}</h2>

    {{-- form tunggal, tapi action dinamis --}}
    <form 
        action="{{ route('survey.temp.store', $number) }}" 
        method="POST"
    >
        @csrf

        <div class="space-y-3">
            @foreach($options as $option)
                <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input 
                        type="radio" 
                        name="answer" 
                        value="{{ $option }}"
                        @if(session('answers.' . $question->id) == $option) checked @endif
                        required
                    >
                    <span>{{ $option }}</span>
                </label>
            @endforeach
        </div>

        <div class="flex justify-between mt-8">
            @if ($number > 1)
                <a href="{{ route('survey.question', $number - 1) }}" 
                   class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                    Sebelumnya
                </a>
            @else
                <span></span> 
            @endif

            <button type="submit" 
                class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">
                {{ $number == $total ? 'Kirim Semua Jawaban' : 'Selanjutnya' }}
            </button>
        </div>
    </form>
</div>
@endsection
