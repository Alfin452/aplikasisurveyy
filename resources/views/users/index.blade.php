@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengguna</h1>
        <a href="{{ route('users.create') }}"
            class="mt-4 md:mt-0 bg-indigo-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-md flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    {{-- Panel Filter dengan Desain Baru yang Lebih Modern dan Minimalis --}}
    <div class="bg-white rounded-lg p-4 mb-6 border border-gray-200 shadow-sm">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="flex flex-wrap items-center gap-4">
                {{-- Pencarian Nama (Elemen Utama) --}}
                <div class="flex-grow relative min-w-[250px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                </div>

                {{-- Dropdown Filter Lainnya --}}
                <select name="role" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Peran</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <select name="unit_kerja" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Unit</option>
                    @foreach ($unitKerjas as $unit)
                    <option value="{{ $unit->id }}" {{ request('unit_kerja') == $unit->id ? 'selected' : '' }}>{{ $unit->uk_short_name }}</option>
                    @endforeach
                </select>
                <select name="sort" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Urutkan</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                </select>

                {{-- Tombol Aksi di Sebelah Kanan --}}
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('users.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800">Reset</a>
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
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Desktop Table View dengan Desain dan Font Baru --}}
    <div class="overflow-x-auto rounded-lg shadow-xl border border-gray-200">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Unit Kerja</th>
                    <th scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 align-top">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td class="px-6 py-4 whitespace-normal break-words align-top">
                        <div class="font-semibold text-gray-900">{{ $user->username }}</div>
                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($user->role->role_name === 'Superadmin') bg-red-100 text-red-800
                            @elseif($user->role->role_name === 'Admin') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $user->role->role_name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap align-top text-gray-700">
                        {{ $user->unitKerja->uk_short_name ?? '—' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-top">
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit Pengguna">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button"
                                @if($user->id === Auth::id())
                                disabled
                                class="text-gray-400 cursor-not-allowed"
                                @else
                                @click="openDeleteModal = true; deleteUrl = '{{ route('users.destroy', $user->id) }}'; deleteItemName = '{{ addslashes($user->username) }}'"
                                class="text-red-600 hover:text-red-800"
                                @endif
                                title="Hapus Pengguna">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-6">Data pengguna tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection