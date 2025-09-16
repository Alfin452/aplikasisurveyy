@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        <!-- Judul -->
        <h1 class="text-3xl font-bold text-gray-800">Daftar Unit Kerja</h1>

        <!-- Aksi Kanan -->
        <div class="flex items-center gap-4">
            <!-- Filter Dropdown -->
            <div
                x-data="{ open: false, selected: '{{ request('type') ?? 'Semua Unit' }}' }"
                class="relative inline-block text-left">
                <button
                    @click="open = !open"
                    class="inline-flex items-center px-5 py-2 bg-white border border-blue-300 text-blue-600 rounded-full shadow-md hover:shadow-lg transition duration-300 ease-in-out focus:outline-none">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <!-- Label -->
                    <span x-text="selected" class="font-semibold tracking-wide"></span>

                    <!-- Dropdown Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        :class="{ 'rotate-180': open }"
                        class="h-4 w-4 ml-2 text-blue-500 transform transition-transform duration-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    x-show="open"
                    x-cloak
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                    <form action="{{ route('unit-kerja.index') }}" method="GET">
                        <ul class="py-2">
                            <li>
                                <button type="submit" name="type" value=""
                                    @click="selected='Semua Unit'; open=false"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 transition">
                                    Semua Unit
                                </button>
                            </li>
                            @foreach ($types as $type)
                            <li>
                                <button type="submit" name="type" value="{{ $type }}"
                                    @click="selected='{{ $type }}'; open=false"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 transition">
                                    {{ $type }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>

            <!-- Tombol Tambah -->
            <a href="{{ route('unit-kerja.create') }}"
                class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-md">
                + Tambah Unit
            </a>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Mobile Card View --}}
    <div class="md:hidden space-y-4">
        @foreach ($unitKerja as $unit)
        <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-200">
            <div class="font-bold text-lg text-indigo-600 mb-2">{{ $unit->unit_kerja_name }}</div>
            <div class="text-sm text-gray-700 space-y-1">
                <p><span class="font-semibold text-gray-500">ID:</span> {{ $unit->id }}</p>
                <p><span class="font-semibold text-gray-500">Nama Singkat:</span> {{ $unit->uk_short_name }}</p>
                <p><span class="font-semibold text-gray-500">Tipe:</span> {{ $unit->type }}</p>
                <p><span class="font-semibold text-gray-500">Kontak:</span> {{ $unit->contact }}</p>
                <p><span class="font-semibold text-gray-500">Lokasi:</span> {{ $unit->address }}</p>
                <p><span class="font-semibold text-gray-500">Jam Layanan:</span> {{ $unit->start_time }} - {{ $unit->end_time }}</p>
            </div>
            <div class="flex space-x-2 mt-4">
                <a href="{{ route('unit-kerja.edit', $unit->id) }}"
                    class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                    ✏️ Edit
                </a>
                <form action="{{ route('unit-kerja.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 transition duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-sm uppercase font-semibold">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Nama Unit Kerja</th>
                    <th class="py-3 px-4 text-left">Nama Singkat</th>
                    <th class="py-3 px-4 text-left">Tipe</th>

                    <th class="py-3 px-4 text-left">Kontak</th>
                    <th class="py-3 px-4 text-left">Lokasi</th>
                    <th class="py-3 px-4 text-left">Jam Mulai</th>
                    <th class="py-3 px-4 text-left">Jam Selesai</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unitKerja as $unit)
                <tr class="hover:bg-gray-50 transition duration-200 border-b text-sm text-gray-700">
                    <td class="py-3 px-4">{{ $unit->id }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800 break-words max-w-xs">{{ $unit->unit_kerja_name }}</td>
                    <td class="py-3 px-4">{{ $unit->uk_short_name }}</td>
                    <td class="py-3 px-4">{{ $unit->type }}</td>

                    <td class="py-3 px-4">{{ $unit->contact }}</td>
                    <td class="py-3 px-4 break-words max-w-xs">{{ $unit->address }}</td>
                    <td class="py-3 px-4">{{ $unit->start_time }}</td>
                    <td class="py-3 px-4">{{ $unit->end_time }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex flex-col space-y-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('unit-kerja.edit', $unit->id) }}"
                                class="inline-flex items-center gap-2 bg-blue-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-blue-600 transition duration-300 shadow-md transform hover:scale-105">
                                <!-- Icon Edit -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5h2m4 0h2a2 2 0 012 2v2m0 4v2a2 2 0 01-2 2h-2m-4 0h-2m-4 0H7a2 2 0 01-2-2v-2m0-4V7a2 2 0 012-2h2" />
                                </svg>
                                Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('unit-kerja.destroy', $unit->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-red-600 transition duration-300 shadow-md transform hover:scale-105 w-full">
                                    <!-- Icon Trash -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection