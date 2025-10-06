@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md" x-data="{ openDeleteModal: false, deleteUrl: '', deleteItemName: '' }">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Survei</h1>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="{{ route('templates.index') }}" class="bg-gray-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-gray-700 transition duration-300 shadow-md flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                </svg>
                <span>Template</span>
            </a>
            <a href="{{ route('surveys.create') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-md flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Tambah Survei</span>
            </a>
        </div>
    </div>

    {{-- Panel Filter --}}
    <div class="bg-white rounded-lg p-4 mb-6 border border-gray-200 shadow-sm">
        <form action="{{ route('surveys.index') }}" method="GET">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-grow relative min-w-[250px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Cari judul survei..." value="{{ request('search') }}">
                </div>
                <select name="status" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <select name="unit_kerja" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Unit</option>
                    @foreach ($unitKerjas as $unit)
                    <option value="{{ $unit->id }}" {{ request('unit_kerja') == $unit->id ? 'selected' : '' }}>{{ $unit->uk_short_name }}</option>
                    @endforeach
                </select>
                <select name="year" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Tahun</option>
                    @foreach ($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <select name="sort" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Urutkan</option>
                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                </select>
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('surveys.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800">Reset</a>
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

    <div class="overflow-x-auto rounded-lg shadow-xl border border-gray-200">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Judul Survei</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Periode & Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Target Unit Kerja</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($surveys as $survey)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 align-top">{{ $loop->iteration + ($surveys->currentPage() - 1) * $surveys->perPage() }}</td>
                    <td class="px-6 py-4 whitespace-normal break-words align-top">
                        <div class="text-sm font-semibold text-gray-900">{{ $survey->title }}</div>
                        <div class="text-xs text-gray-500 max-w-md">{{ Str::limit($survey->description, 100) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <div class="text-sm font-medium text-gray-900">{{ $survey->start_date->format('d M Y') }} - {{ $survey->end_date->format('d M Y') }}</div>
                        @if($survey->is_active)
                        <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @else
                        <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-normal align-top max-w-sm">
                        <div class="flex flex-wrap gap-1">
                            @foreach($survey->unitKerja->pluck('uk_short_name')->take(5) as $short_name)
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $short_name }}</span>
                            @endforeach
                            @if($survey->unitKerja->count() > 5)
                            <span class="text-gray-500 text-xs">+{{ $survey->unitKerja->count() - 5 }} lainnya</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium align-top">
                        <div class="flex items-center justify-center space-x-4">
                            {{-- DITAMBAHKAN: Tombol Lihat Hasil Survei --}}
                            <a href="{{ route('surveys.results', $survey->id) }}" class="text-green-600 hover:text-green-800" title="Lihat Hasil">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                </svg>
                            </a>
                            <a href="{{ route('surveys.show', $survey->id) }}" class="text-purple-600 hover:text-purple-800" title="Kelola Pertanyaan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                </svg>
                            </a>
                            <a href="{{ route('surveys.edit', $survey->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit Survei">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button"
                                @click="openDeleteModal = true; deleteUrl = '{{ route('surveys.destroy', $survey->id) }}'; deleteItemName = '{{ addslashes($survey->title) }}'"
                                class="text-red-600 hover:text-red-800" title="Hapus Survei">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-6">Belum ada survei yang dibuat atau hasil filter tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $surveys->links() }}
    </div>
</div>
@endsection