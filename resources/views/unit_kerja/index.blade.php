{{-- resources/views/unit_kerja/index.blade.php --}}
@extends('layouts.admin')

@section('content')

<div class="p-6 bg-white rounded-xl shadow-md" x-data="{ openDeleteModal: false, deleteUrl: '', deleteItemName: '' }">

    {{-- DIUBAH: Header Halaman Premium dengan Breadcrumbs --}}
    <div class="mb-6 bg-white rounded-xl p-4 md:p-6 border-l-4 border-blue-500 shadow">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <!-- Breadcrumbs -->
                <nav class="text-sm mb-2 font-medium text-gray-500" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('superadmin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-700">Manajemen Unit Kerja</span>
                        </li>
                    </ol>
                </nav>

                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-blue-500 text-white p-3 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Unit Kerja</h1>
                        <p class="text-sm text-gray-500 mt-1">Kelola semua unit kerja yang terdaftar dalam sistem.</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('unit-kerja.create') }}"
                class="mt-4 md:mt-0 bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-300 shadow-md flex items-center space-x-2 self-start md:self-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Tambah Unit</span>
            </a>
        </div>
    </div>

    {{-- Panel Filter dengan Desain Baru --}}
    <div class="bg-white rounded-lg p-4 mb-6 border border-gray-200 shadow-sm">
        <form action="{{ route('unit-kerja.index') }}" method="GET">
            <div class="flex flex-wrap items-center gap-4">
                {{-- Pencarian Nama --}}
                <div class="flex-grow relative min-w-[250px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Cari nama unit kerja..." value="{{ request('search') }}">
                </div>

                {{-- Dropdown Filter dengan Animasi Bouncy menggunakan Alpine.js --}}
                <div x-data="{ open: false }" class="relative">
                    <select name="type" @focus="open = true" @blur="open = false" class="w-full sm:w-auto pl-4 pr-10 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none">
                        <option value="">Semua Tipe</option>
                        @foreach ($tipeUnits as $tipe)
                        <option value="{{ $tipe->id }}" {{ request('type') == $tipe->id ? 'selected' : '' }}>{{ $tipe->nama_tipe_unit }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4 transform transition-transform duration-300 ease-[cubic-bezier(0.68,-0.55,0.27,1.55)]" :class="{ 'rotate-180 text-indigo-600': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <select name="parent" @focus="open = true" @blur="open = false" class="w-full sm:w-auto pl-4 pr-10 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none">
                        <option value="">Semua Induk</option>
                        @foreach ($parentUnits as $parent)
                        <option value="{{ $parent->id }}" {{ request('parent') == $parent->id ? 'selected' : '' }}>{{ $parent->unit_kerja_name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4 transform transition-transform duration-300 ease-[cubic-bezier(0.68,-0.55,0.27,1.55)]" :class="{ 'rotate-180 text-indigo-600': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <select name="sort" @focus="open = true" @blur="open = false" class="w-full sm:w-auto pl-4 pr-10 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none">
                        <option value="">Urutkan</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4 transform transition-transform duration-300 ease-[cubic-bezier(0.68,-0.55,0.27,1.55)]" :class="{ 'rotate-180 text-indigo-600': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('unit-kerja.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800">Reset</a>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-sm flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filter</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Mobile Card View --}}
    <div class="md:hidden space-y-4">
        @forelse ($unitKerja as $unit)
        <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <div class="font-bold text-lg text-indigo-600">{{ $unit->unit_kerja_name }}</div>
                    <div class="text-sm text-gray-500">{{ $unit->uk_short_name }}</div>
                </div>
                @php
                $color = 'bg-gray-100 text-gray-800'; // Default
                if ($unit->tipeUnit->nama_tipe_unit == 'Fakultas') $color = 'bg-blue-100 text-blue-800';
                if ($unit->tipeUnit->nama_tipe_unit == 'Lembaga') $color = 'bg-green-100 text-green-800';
                if ($unit->tipeUnit->nama_tipe_unit == 'UPT') $color = 'bg-yellow-100 text-yellow-800';
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $color }} flex-shrink-0">
                    {{ $unit->tipeUnit->nama_tipe_unit }}
                </span>
            </div>
            <div class="text-gray-700 space-y-2 mt-3 border-t pt-3">
                <p><span class="font-semibold text-gray-500 w-24 inline-block">Induk Unit:</span> {{ $unit->parent->unit_kerja_name ?? '—' }}</p>
                <p><span class="font-semibold text-gray-500 w-24 inline-block">Kontak:</span> {{ $unit->contact }}</p>
                <p><span class="font-semibold text-gray-500 w-24 inline-block">Jam Layanan:</span> {{ $unit->start_time }} - {{ $unit->end_time }}</p>
            </div>
            <div class="flex items-center gap-4 mt-4 border-t pt-4">
                @if($unit->children_count > 0)
                <a href="{{ route('unit-kerja.index', ['parent' => $unit->id]) }}" class="text-green-600 hover:text-green-800 flex items-center gap-1 text-sm" title="Lihat Sub-Unit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    <span>({{ $unit->children_count }})</span>
                </a>
                @endif
                <a href="{{ route('unit-kerja.edit', $unit->id) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-1 text-sm ml-auto" title="Edit">
                    {{-- DIUBAH: Mengganti emoji dengan ikon SVG --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit</span>
                </a>
                <button type="button" @click="openDeleteModal = true; deleteUrl = '{{ route('unit-kerja.destroy', $unit->id) }}'; deleteItemName = '{{ addslashes($unit->unit_kerja_name) }}'" class="text-red-600 hover:text-red-800 flex items-center gap-1 text-sm" title="Hapus">
                    {{-- DIUBAH: Mengganti emoji dengan ikon SVG --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                    </svg>
                    <span>Hapus</span>
                </button>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500 py-4">Data tidak ditemukan.</p>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block overflow-x-auto rounded-lg shadow-xl border border-gray-200">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 w-1/12 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="px-4 py-3 w-3/12 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Nama Unit Kerja</th>
                    <th class="px-4 py-3 w-2/12 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-4 py-3 w-3/12 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Induk & Kontak</th>
                    <th class="px-4 py-3 w-2/12 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Jam Layanan</th>
                    <th class="px-4 py-3 w-2/12 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-4 py-3 w-1/12 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($unitKerja as $unit)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 align-top text-gray-700">{{ $unitKerja->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-4 align-top whitespace-normal break-words">
                        <div class="font-medium text-gray-900">{{ $unit->unit_kerja_name }}</div>
                        <div class="text-gray-500">{{ $unit->uk_short_name }}</div>
                    </td>
                    <td class="px-4 py-4 align-top">
                        @php
                        $color = 'bg-gray-100 text-gray-800'; // Default
                        if ($unit->tipeUnit->nama_tipe_unit == 'Fakultas') $color = 'bg-blue-100 text-blue-800';
                        if ($unit->tipeUnit->nama_tipe_unit == 'Lembaga') $color = 'bg-green-100 text-green-800';
                        if ($unit->tipeUnit->nama_tipe_unit == 'UPT') $color = 'bg-yellow-100 text-yellow-800';
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                            {{ $unit->tipeUnit->nama_tipe_unit }}
                        </span>
                    </td>
                    <td class="px-4 py-4 align-top whitespace-normal break-words">
                        <div class="text-gray-900">{{ $unit->parent->unit_kerja_name ?? '—' }}</div>
                        <div class="text-gray-500">{{ $unit->contact }}</div>
                    </td>
                    <td class="px-4 py-4 align-top text-gray-500">{{ $unit->start_time }} - {{ $unit->end_time }}</td>
                    <td class="px-4 py-4 align-top whitespace-normal break-words text-gray-500">{{ $unit->address }}</td>
                    <td class="px-4 py-4 align-top text-center">
                        <div class="flex justify-center space-x-3">
                            @if($unit->children_count > 0)
                            <a href="{{ route('unit-kerja.index', ['parent' => $unit->id]) }}" class="text-green-600 hover:text-green-800" title="Lihat {{ $unit->children_count }} Sub-Unit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif
                            <a href="{{ route('unit-kerja.edit', $unit->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button" @click="openDeleteModal = true; deleteUrl = '{{ route('unit-kerja.destroy', $unit->id) }}'; deleteItemName = '{{ addslashes($unit->unit_kerja_name) }}'" class="text-red-600 hover:text-red-800" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-6">Data tidak ditemukan.</td>
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