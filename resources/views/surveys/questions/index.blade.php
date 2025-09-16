@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        <h1 class="text-3xl font-bold text-gray-800"><br class="md:hidden">{{ $survey->title }}</h1>
        <a href="{{ route('surveys.questions.create', $survey->id) }}"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-blue-600 transition duration-300 shadow-lg transform hover:scale-105">
            + Tambah Pertanyaan
        </a>
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
                    <th class="py-4 px-6 border-b">Teks Pertanyaan</th>
                    <th class="py-4 px-6 border-b">Tipe</th>
                    <th class="py-4 px-6 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($survey->questions as $question)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} text-sm text-gray-700 border-b">
                    <td class="py-3 px-6">{{ $question->id }}</td>
                    <td class="py-3 px-6 font-medium text-gray-800 break-words max-w-xs">{{ $question->question_body }}</td>
                    <td class="py-3 px-6">{{ Str::of($question->type)->title()->replace('_', ' ') }}</td>
                    <td class="py-3 px-6">
                        <div class="flex flex-col space-y-2 w-full">
                            <!-- Tombol Edit -->
                            <a href="{{ route('surveys.questions.edit', [$survey->id, $question->id]) }}"
                                class="inline-flex items-center gap-2 bg-blue-500 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-blue-600 transition duration-300 shadow-md transform hover:scale-105 w-max">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m4 0h2a2 2 0 012 2v2m0 4v2a2 2 0 01-2 2h-2m-4 0h-2m-4 0H7a2 2 0 01-2-2v-2m0-4V7a2 2 0 012-2h2" />
                                </svg>
                                Edit
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