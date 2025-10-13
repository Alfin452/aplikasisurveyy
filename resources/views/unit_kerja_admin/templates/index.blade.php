@extends('layouts.unit_kerja_admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">

    <div class="mb-8 bg-white rounded-xl p-4 md:p-6 border-l-4 border-gray-500 shadow">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <nav class="text-sm mb-2 font-medium text-gray-500" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center"><a href="{{ route('unitkerja.admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a><svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg></li>
                        <li class="flex items-center"><a href="{{ route('unitkerja.admin.surveys.index') }}" class="hover:text-gray-700">Manajemen Survei</a><svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg></li>
                        <li class="flex items-center"><span class="text-gray-700">Template Survei</span></li>
                    </ol>
                </nav>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-gray-500 text-white p-3 rounded-lg shadow-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg></div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kelola Template Survei</h1>
                        <p class="text-sm text-gray-500 mt-1">Gunakan template untuk membuat survei baru dengan cepat.</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('unitkerja.admin.surveys.index') }}" @click="pageLoading = true" class="mt-4 md:mt-0 bg-white text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center space-x-2 border border-gray-300 self-start md:self-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @if(session('success')) <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('success') }}</p>
    </div> @endif
    @if(session('error')) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-semibold">{{ session('error') }}</p>
    </div> @endif
    @if($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
        <p class="font-bold">Terjadi Kesalahan</p>
        <ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div> @endif

    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Jadikan Survei sebagai Template</h2>
        <p class="text-gray-600 mb-6 text-sm max-w-2xl">Pilih salah satu survei yang sudah ada untuk menyimpannya sebagai cetakan.</p>
        <form action="{{ route('unitkerja.admin.templates.store') }}" method="POST">
            @csrf
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-grow min-w-[300px]">
                    <select id="survey-to-copy-select" name="survey_id">
                        <option value="">Pilih survei...</option>
                        @foreach($surveysToCopy as $survey)
                        <option value="{{ $survey->id }}">{{ $survey->title }} ({{ $survey->questions_count }} Pertanyaan)</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" @click="pageLoading = true" class="bg-teal-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-teal-700 transition shadow-md flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                    <span>Simpan sebagai Template</span>
                </button>
            </div>
        </form>
    </div>

    <div class="relative my-10">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center"><span class="bg-white px-4 text-gray-400"><svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg></span></div>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Template yang Tersedia</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-xl hover:border-teal-300 hover:-translate-y-1 transition-all duration-300 flex flex-col group">
            <div class="p-5 flex-grow">
                <div class="flex items-start justify-between">
                    <h3 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-teal-600 transition-colors duration-300">{{ $template->title }}</h3>
                    <div class="text-gray-300 group-hover:text-teal-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-500 space-x-4 mt-2">
                    <span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>{{ $template->questions_count }} Pertanyaan</span>
                    <span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>{{ $template->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <div class="bg-gray-50 p-3 flex items-center justify-between border-t">
                <button type="button" @click="$dispatch('open-delete-modal', { url: '{{ route('unitkerja.admin.templates.destroy', $template->id) }}', name: '{{ addslashes($template->title) }}' })" class="text-gray-500 hover:text-red-600 transition" title="Hapus Template">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                    </svg>
                </button>
                <a href="{{ route('unitkerja.admin.surveys.create_from_template', $template->id) }}" @click="pageLoading = true" class="bg-green-500 text-white px-4 py-1.5 rounded-lg text-xs font-semibold hover:bg-green-600 transition shadow-md hover:shadow-lg hover:-translate-y-0.5 transform flex items-center space-x-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Gunakan Template Ini</span>
                </a>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3 text-center py-12 px-4 bg-gray-50 border-2 border-dashed rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <p class="mt-4 font-semibold text-gray-600">Belum ada template yang disimpan</p>
            <p class="text-gray-500 text-sm mt-1">Gunakan form di atas untuk menyimpan survei sebagai template.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('survey-to-copy-select')) {
            new TomSelect('#survey-to-copy-select', {
                create: false,
                placeholder: 'Pilih survei yang sudah ada...',
            });
        }
    });
</script>
@endpush