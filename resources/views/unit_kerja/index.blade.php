{{-- resources/views/unit_kerja/index.blade.php --}}
@extends('layouts.admin')

@section('content')

<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Unit Kerja</h1>
        <a href="{{ route('unit-kerja.create') }}"
            class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-md">
            + Tambah Unit
        </a>
    </div>

    {{-- Panel Filter yang selalu terlihat --}}
    <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
        <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L10 14.414V17a1 1 0 01-1 1H7a1 1 0 01-1-1v-2.586L.293 6.707A1 1 0 010 6V3z" clip-rule="evenodd" />
            </svg>
            Filter & Urutkan
        </h3>
        <form action="{{ route('unit-kerja.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <input type="text" name="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Cari nama..." value="{{ request('search') }}">
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Tipe</option>
                    @foreach ($tipeUnits as $tipe)
                    <option value="{{ $tipe->id }}" {{ request('type') == $tipe->id ? 'selected' : '' }}>{{ $tipe->nama_tipe_unit }}</option>
                    @endforeach
                </select>
                <select name="parent" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Induk Unit</option>
                    @foreach ($parentUnits as $parent)
                    <option value="{{ $parent->id }}" {{ request('parent') == $parent->id ? 'selected' : '' }}>{{ $parent->unit_kerja_name }}</option>
                    @endforeach
                </select>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Urutkan Default</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Terapkan</button>
                <a href="{{ route('unit-kerja.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">Reset</a>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Mobile Card View (dengan semua detail) --}}
    <div class="md:hidden space-y-4">
        @forelse ($unitKerja as $unit)
        <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-200">
            <div class="font-bold text-lg text-indigo-600 mb-2">{{ $unit->unit_kerja_name }}</div>
            <div class="text-sm text-gray-700 space-y-1">
                {{-- DIUBAH: Menggunakan nomor urut, bukan ID --}}
                <p><span class="font-semibold text-gray-500">No:</span> {{ $unitKerja->firstItem() + $loop->index }}</p>
                <p><span class="font-semibold text-gray-500">Nama Singkat:</span> {{ $unit->uk_short_name }}</p>
                <p><span class="font-semibold text-gray-500">Tipe:</span> {{ $unit->tipeUnit->nama_tipe_unit }}</p>
                <p><span class="font-semibold text-gray-500">Induk Unit:</span> {{ $unit->parent->unit_kerja_name ?? '—' }}</p>
                <p><span class="font-semibold text-gray-500">Kontak:</span> {{ $unit->contact }}</p>
                <p><span class="font-semibold text-gray-500">Lokasi:</span> {{ $unit->address }}</p>
                <p><span class="font-semibold text-gray-500">Jam Layanan:</span> {{ $unit->start_time }} - {{ $unit->end_time }}</p>
            </div>
            <div class="flex flex-wrap gap-2 mt-4">
                @if($unit->children_count > 0)
                <a href="{{ route('unit-kerja.index', ['parent' => $unit->id]) }}" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Sub-Unit ({{ $unit->children_count }})
                </a>
                @endif
                <a href="{{ route('unit-kerja.edit', $unit->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">✏️ Edit</a>
                <button type="button"
                    @click="openDeleteModal = true; deleteUrl = '{{ route('unit-kerja.destroy', $unit->id) }}'; deleteItemName = '{{ addslashes($unit->unit_kerja_name) }}'"
                    class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 transition duration-300 shadow-md transform hover:scale-105 flex items-center gap-2">
                    🗑️ Hapus
                </button>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500 py-4">Data tidak ditemukan.</p>
        @endforelse
    </div>

    {{-- Desktop Table View (dengan semua kolom) --}}
    <div class="hidden md:block rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-sm uppercase font-semibold">
                <tr>
                    {{-- DIUBAH: Header kolom menjadi "No." --}}
                    <th class="py-3 px-4 text-left">No.</th>
                    <th class="py-3 px-4 text-left">Nama Unit Kerja</th>
                    <th class="py-3 px-4 text-left">Nama Singkat</th>
                    <th class="py-3 px-4 text-left">Tipe</th>
                    <th class="py-3 px-4 text-left">Induk Unit</th>
                    <th class="py-3 px-4 text-left">Kontak</th>
                    <th class="py-3 px-4 text-left">Lokasi</th>
                    <th class="py-3 px-4 text-left">Jam Mulai</th>
                    <th class="py-3 px-4 text-left">Jam Selesai</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($unitKerja as $unit)
                <tr class="hover:bg-gray-50 transition duration-200 border-b text-sm text-gray-700">
                    {{-- DIUBAH: Menampilkan nomor urut dinamis --}}
                    <td class="py-3 px-4">{{ $unitKerja->firstItem() + $loop->index }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800 break-words max-w-xs">{{ $unit->unit_kerja_name }}</td>
                    <td class="py-3 px-4">{{ $unit->uk_short_name }}</td>
                    <td class="py-3 px-4">{{ $unit->tipeUnit->nama_tipe_unit }}</td>
                    <td class="py-3 px-4">{{ $unit->parent->unit_kerja_name ?? '—' }}</td>
                    <td class="py-3 px-4">{{ $unit->contact }}</td>
                    <td class="py-3 px-4 break-words max-w-xs">{{ $unit->address }}</td>
                    <td class="py-3 px-4">{{ $unit->start_time }}</td>
                    <td class="py-3 px-4">{{ $unit->end_time }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center items-center space-x-3">
                            @if($unit->children_count > 0)
                            <a href="{{ route('unit-kerja.index', ['parent' => $unit->id]) }}" class="text-green-600 hover:text-green-800" title="Lihat Sub-Unit ({{ $unit->children_count }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif
                            <a href="{{ route('unit-kerja.edit', $unit->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button"
                                @click="openDeleteModal = true; deleteUrl = '{{ route('unit-kerja.destroy', $unit->id) }}'; deleteItemName = '{{ addslashes($unit->unit_kerja_name) }}'"
                                class="text-red-600 hover:text-red-800" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-gray-500 py-4">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $unitKerja->links() }}
    </div>

</div>
@endsection