@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kelola Template Survei</h1>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Jadikan Survei sebagai Template</h2>
        <form action="{{ route('templates.store') }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <select name="survey_id" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                <option value="">Pilih Survei...</option>
                @foreach($surveysToCopy as $survey)
                <option value="{{ $survey->id }}">{{ $survey->title }} ({{ $survey->questions->count() }} Pertanyaan)</option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300">
                Simpan sebagai Template
            </button>
        </form>
    </div>

    <hr class="my-8">

    <h2 class="text-xl font-bold text-gray-800 mb-4">Template yang Tersedia</h2>
    <div class="space-y-4">
        @foreach($templates as $template)
        <div class="bg-gray-50 p-4 rounded-lg shadow-inner flex justify-between items-center">
            <div>
                <p class="font-semibold text-gray-800">{{ $template->title }}</p>
                <p class="text-sm text-gray-500">Dibuat pada: {{ $template->created_at->format('d/m/Y') }}</p>
            </div>
            <div>
                <a href="{{ route('surveys.create_from_template', $template->id) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition duration-300">
                    Buat Survei dari Template
                </a>
                <form action="{{ route('templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition duration-300">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection