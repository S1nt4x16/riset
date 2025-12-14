@extends('layouts.app')

@section('title', 'Daftar Respon')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-8 max-w-5xl w-full mx-auto mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-teal-700">Daftar Respon Survei</h1>
    </div>

    <table class="w-full border-collapse">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Response Code</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($responses as $index => $res)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3 font-mono text-sm text-gray-700">{{ $res->respondent_code }}</td>
                    <td class="p-3">{{ $res->nama ?? 'Anonim' }}</td>
                    <td class="p-3">{{ $res->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-3 text-right">
                        <button 
                            class="bg-teal-600 text-white px-3 py-1 rounded-lg hover:bg-teal-700 text-sm transition"
                            data-modal="{{ 'modal-' . $res->respondent_code }}">
                            Detail
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">Belum ada respon yang masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODALS --}}
@foreach($responses as $res)
    @php $modalId = 'modal-' . $res->respondent_code; @endphp

    <div id="{{ $modalId }}" 
         class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50"
         role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title"
         onclick="modalOverlayClick(event, '{{ $modalId }}')">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-3xl p-6 relative animate-fadeIn"
             onclick="event.stopPropagation();">
            <h2 id="{{ $modalId }}-title" class="text-lg font-bold text-teal-700 mb-4">
                Detail Jawaban — {{ $res->nama ?? 'Anonim' }}
            </h2>

            <div class="overflow-y-auto max-h-[60vh] rounded-lg border border-gray-200">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-3 w-12 text-center">No</th>
                            <th class="p-3 w-1/2">Pertanyaan</th>
                            <th class="p-3 w-1/2">Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($res->answers as $i => $ans)
                            <tr class="border-t">
                                <td class="p-3 text-center text-gray-600">{{ $i + 1 }}</td>
                                <td class="p-3 text-gray-700 align-top">{{ $ans->question->text ?? '-' }}</td>
                                <td class="p-3 text-gray-900 font-medium align-top whitespace-pre-wrap">{{ $ans->answer ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-center mt-6">
                <small class="text-gray-500">Kode: <span class="font-mono">{{ $res->respondent_code }}</span></small>

                <div class="space-x-2">
                    <form action="{{ route('admin.responses.destroy', $res->id) }}" method="POST" class="inline"
                          onsubmit="return confirm('Yakin ingin menghapus seluruh respon ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700">
                            Hapus Respon
                        </button>
                    </form>

                    <button 
                        onclick="closeModal('{{ $modalId }}')" 
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- SCRIPT MODAL --}}
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('button[data-modal]');
        if (!btn) return;
        const modalId = btn.getAttribute('data-modal');
        openModal(modalId);
    });

    function openModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function modalOverlayClick(event, id) {
        const el = document.getElementById(id);
        if (event.target === el) closeModal(id);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"].flex').forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.style.overflow = '';
        }
    });
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>
@endsection
