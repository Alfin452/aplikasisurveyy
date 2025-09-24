{{-- resources/views/unit_kerja/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Tambah Unit Kerja</h1>

    <form action="{{ route('unit-kerja.store') }}" method="POST">
        {{-- Form partial Anda tidak berubah --}}
        @include('unit_kerja._form')
    </form>
</div>
@endsection

{{-- DITAMBAHKAN: Bagian untuk "menyalakan" time picker --}}
@push('scripts')
<script>
    // Inisialisasi Flatpickr pada semua elemen dengan class 'timepicker'
    flatpickr(".timepicker", {
        enableTime: true, // Mengaktifkan pemilihan waktu
        noCalendar: true, // Menyembunyikan kalender (hanya waktu)
        dateFormat: "H:i", // Format waktu yang disimpan (misal: 14:30)
        time_24hr: true // Menggunakan format 24 jam
    });
</script>
@endpush