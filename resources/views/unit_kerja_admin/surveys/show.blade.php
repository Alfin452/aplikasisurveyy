@extends('layouts.unit_kerja_admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $survey->title }}</h1>
            <p class="text-gray-500">Kelola pertanyaan untuk survei ini.</p>
        </div>
        {{-- DIUBAH: Memastikan tombol ini menggunakan rute yang benar dan akan ditangani oleh QuestionController yang cerdas --}}
        <a href="{{ route('surveys.questions.create', $survey->id) }}" class="bg-teal-500 text-white px-5 py-2 rounded-lg font-medium hover:bg-teal-600 transition duration-300 shadow-md flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <span>Tambah Pertanyaan</span>
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Daftar Pertanyaan --}}
    <div class="space-y-4">
        @forelse($survey->questions as $question)
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center justify-between">
            <div>
                <p class="font-semibold text-gray-800">{{ $loop->iteration }}. {{ $question->question_body }}</p>
                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $question->type === 'multiple_choice' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $question->type === 'multiple_choice' ? 'Pilihan Ganda' : 'Teks' }}
                </span>
            </div>
            <div class="flex items-center space-x-4">
                {{-- DIUBAH: Memastikan tombol Edit juga menggunakan rute yang benar --}}
                <a href="{{ route('surveys.questions.edit', ['survey' => $survey->id, 'question' => $question->id]) }}" class="text-teal-600 hover:text-teal-800" title="Edit Pertanyaan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <form action="{{ route('surveys.questions.destroy', ['survey' => $survey->id, 'question' => $question->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus Pertanyaan">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 py-10 border-2 border-dashed rounded-lg">
            <p>Belum ada pertanyaan untuk survei ini.</p>
            <p class="text-sm">Klik tombol "Tambah Pertanyaan" untuk memulai.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        <a href="{{ route('unitkerja.admin.surveys.index') }}" class="text-teal-600 hover:text-teal-800 font-medium">&larr; Kembali ke Daftar Survei</a>
    </div>
</div>
@endsection