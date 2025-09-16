@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Survei</h1>
        <div>
            <a href="{{ route('surveys.create') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-md">
                + Tambah Survei Baru
            </a>
            <a href="{{ route('templates.index') }}" class="ml-2 bg-gray-600 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-gray-700 transition duration-300 shadow-md">
                Kelola Template
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="min-w-full bg-white border-collapse">
            <thead class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-sm uppercase font-semibold">
                <tr class="text-left">
                    <th class="py-4 px-6 border-b">ID</th>
                    <th class="py-4 px-6 border-b">Judul Survei</th>
                    <th class="py-4 px-6 border-b">Tanggal Mulai</th>
                    <th class="py-4 px-6 border-b">Tanggal Selesai</th>
                    <th class="py-4 px-6 border-b">Status</th>
                    <th class="py-4 px-6 border-b">Unit Kerja</th>
                    <th class="py-4 px-6 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $survey)
                <tr class="hover:bg-gray-50 transition duration-200 border-b text-sm text-gray-700">
                    <td class="py-3 px-6">{{ $survey->id }}</td>
                    <td class="py-3 px-6 font-medium text-gray-800 break-words max-w-xs">{{ $survey->title }}</td>
                    <td class="py-3 px-6">{{ \Carbon\Carbon::parse($survey->start_date)->format('d/m/Y') }}</td>
                    <td class="py-3 px-6">{{ \Carbon\Carbon::parse($survey->end_date)->format('d/m/Y') }}</td>
                    <td class="py-3 px-6">
                        @if($survey->is_active)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Aktif</span>
                        @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @foreach($survey->unitKerja as $unit)
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $unit->uk_short_name }}</span>
                        @endforeach
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex flex-col space-y-2 w-full">
                            <!-- Tombol Edit -->
                            <a href="{{ route('surveys.edit', $survey->id) }}"
                                class="inline-flex items-center gap-2 bg-blue-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-blue-600 transition duration-300 shadow-md transform hover:scale-105 w-max">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m4 0h2a2 2 0 012 2v2m0 4v2a2 2 0 01-2 2h-2m-4 0h-2m-4 0H7a2 2 0 01-2-2v-2m0-4V7a2 2 0 012-2h2" />
                                </svg>
                                Edit
                            </a>

                            <!-- Tombol Kelola Pertanyaan -->
                            <a href="{{ route('surveys.questions.index', $survey->id) }}"
                                class="inline-flex items-center gap-2 bg-purple-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-purple-600 transition duration-300 shadow-md transform hover:scale-105 w-max">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5m-7 0v2m0 2h.01" />
                                </svg>
                                Kelola Pertanyaan
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-2 bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-red-600 transition duration-300 shadow-md transform hover:scale-105 w-max">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8" />
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