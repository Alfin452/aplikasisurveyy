@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Tambah Unit Kerja</h1>

    <form action="{{ route('unit-kerja.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <label for="unit_kerja_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Unit Kerja:</label>
                <input type="text" id="unit_kerja_name" name="unit_kerja_name" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
            </div>

            <div>
                <label for="uk_short_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Singkat:</label>
                <input type="text" id="uk_short_name" name="uk_short_name" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            </div>

            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Unit:</label>
                <select id="type" name="type" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
                    <option value="">Pilih Tipe</option>
                    <option value="Rektorat">Rektorat</option>
                    <option value="Universitas">Universitas</option>
                    <option value="Fakultas Ekonomi dan Bisnis Islam">Fakultas Ekonomi dan Bisnis Islam</option>
                    <option value="Fakultas Dakwah dan Ilmu Komunikasi">Fakultas Dakwah dan Ilmu Komunikasi</option>
                    <option value="Fakultas Syariah">Fakultas Syariah</option>
                    <option value="Fakultas Tarbiyah dan Keguruan">Fakultas Tarbiyah dan Keguruan</option>
                    <option value="Fakultas Ushuluddin dan Humaniora">Fakultas Ushuluddin dan Humaniora</option>
                    <option value="Pascasarjana">Pascasarjana</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>

            <div>
                <label for="contact" class="block text-sm font-semibold text-gray-700 mb-1">Kontak:</label>
                <input type="text" id="contact" name="contact" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            </div>

            <div>
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Lokasi:</label>
                <input type="text" id="address" name="address" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            </div>

            <div class="col-span-1 md:col-span-2 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                <div class="w-full md:w-1/2">
                    <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Mulai Layanan:</label>
                    <input type="time" id="start_time" name="start_time" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                <div class="w-full md:w-1/2">
                    <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1">Jam Selesai Layanan:</label>
                    <input type="time" id="end_time" name="end_time" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4 mt-8">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
                Simpan Data
            </button>
            <a href="{{ route('unit-kerja.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg text-lg font-medium hover:bg-gray-400 transition duration-300 shadow-lg transform hover:scale-105">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection