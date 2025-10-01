@extends('layouts.unit_kerja_admin')

@section('content')
{{-- Judul Halaman --}}
<h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ $user->username }}!</h1>

{{-- Informasi Unit Kerja --}}
<p class="text-lg text-gray-600">
    Anda login sebagai Admin untuk unit kerja:
    <span class="font-semibold text-teal-600">{{ $unitKerja->unit_kerja_name ?? 'Tidak terhubung ke unit kerja' }}</span>.
</p>

{{-- Kartu Informasi --}}
<div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Panel Admin Unit Kerja</h2>
    <p class="text-gray-700">
        Dari panel ini, Anda dapat mengelola semua survei yang ditujukan khusus untuk unit kerja Anda.
    </p>
    <p class="text-gray-700 mt-2">
        Silakan gunakan menu di sebelah kiri untuk menavigasi.
    </p>
</div>
@endsection