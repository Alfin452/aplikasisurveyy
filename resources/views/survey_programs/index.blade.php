@extends('layouts.admin')

@section('content')
<div class="p-4 sm:p-6">

    {{-- Header Halaman --}}
    <div class="mb-8 bg-white rounded-xl p-4 md:p-6 border-l-4 border-purple-500 shadow-sm">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <nav class="text-sm mb-2 font-medium text-gray-500" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('superadmin.dashboard') }}" class="hover:text-purple-600">Dashboard</a>
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </li>
                        <li class="flex items-center"><span class="text-gray-700">Manajemen Program Survei</span></li>
                    </ol>
                </nav>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-purple-500 text-white p-3 rounded-lg shadow-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg></div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Program Survei (Wadah)</h1>
                        <p class="text-sm text-gray-500 mt-1">Kelola "wadah" atau program survei induk di sini.</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('programs.create') }}" class="mt-4 md:mt-0 bg-purple-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-purple-700 transition duration-300 shadow-md flex items-center space-x-2 self-start md:self-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Buat Program Baru</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Tabel Program Survei --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-purple-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Program</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Statistik</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($programs as $program)
                <tr class="hover:bg-purple-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $program->title }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($program->description, 80) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="text-center">
                                <p class="font-bold text-gray-800">{{ $program->targeted_unit_kerjas_count }}</p>
                                <p class="text-xs">Unit Target</p>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-gray-800">{{ $program->surveys_count }}</p>
                                <p class="text-xs">Pelaksanaan</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $program->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{ route('programs.show', $program) }}" class="text-blue-600 hover:text-blue-800" title="Lihat Detail & Pelaksanaan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('programs.edit', $program) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit Program">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button" @click="$dispatch('open-delete-modal', { url: '{{ route('programs.destroy', $program) }}', name: '{{ addslashes($program->title) }}' })" class="text-red-600 hover:text-red-800" title="Hapus Program">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-12 px-4">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="mt-4 font-semibold text-gray-600">Belum Ada Program Survei</p>
                            <p class="text-gray-500 text-sm mt-1">Klik tombol "Buat Program Baru" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $programs->links() }}
    </div>
</div>
@endsection