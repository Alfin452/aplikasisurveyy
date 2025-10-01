@extends('layouts.unit_kerja_admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Survei Baru</h1>

    <form action="{{ route('unitkerja.admin.surveys.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            {{-- Judul Survei --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Survei</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200" required>
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Periode Survei --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200" required>
                    @error('start_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Berakhir</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200" required>
                    @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-offset-0 focus:ring-teal-200" checked>
                    <span class="ml-2 text-sm text-gray-700">Aktifkan survei ini</span>
                </label>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-4 mt-8 border-t pt-6">
            <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-teal-600 transition duration-300 shadow-lg">
                Simpan Survei
            </button>
            <a href="{{ route('unitkerja.admin.surveys.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 transition duration-300">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection