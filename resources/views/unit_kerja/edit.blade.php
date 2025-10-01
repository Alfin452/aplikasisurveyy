@extends('layouts.admin')

@section('content')
<div class="p-8 bg-white rounded-xl shadow-lg">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('unit-kerja.index') }}" class="text-gray-400 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Edit Unit Kerja</h1>
    </div>

    <form action="{{ route('unit-kerja.update', $unitKerja->id) }}" method="POST">
        @method('PUT')
        @include('unit_kerja._form', ['unitKerja' => $unitKerja])
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi TomSelect untuk membuat dropdown berfungsi
        new TomSelect('#tipe_unit_select', {
            placeholder: 'Pilih tipe unit...'
        });
        new TomSelect('#parent_select', {
            placeholder: 'Cari induk unit kerja...'
        });

        // Inisialisasi Flatpickr untuk input waktu
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    });
</script>
@endpush