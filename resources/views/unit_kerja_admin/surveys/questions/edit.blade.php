@extends('layouts.unit_kerja_admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">
    {{-- Header Halaman dengan Desain Baru --}}
    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
        <div class="flex items-center gap-4">
            {{-- Tombol Batal yang Benar --}}
            <a href="{{ route('unitkerja.admin.surveys.show', $survey) }}" class="text-gray-400 hover:text-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Pertanyaan</h1>
                <p class="text-sm text-gray-500 mt-1">Untuk survei: <span class="font-medium text-gray-700">{{ $survey->title }}</span></p>
            </div>
        </div>
    </div>

    <form action="{{ route('surveys.questions.update', ['survey' => $survey, 'question' => $question]) }}" method="POST">
        @method('PUT')
        @include('surveys.questions._form', ['question' => $question])
    </form>
</div>
@endsection