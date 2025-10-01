@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('surveys.index') }}" class="text-gray-500 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Survei Baru</h1>
    </div>

    <form action="{{ route('surveys.store') }}" method="POST">
        @include('surveys._form')
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Flatpickr untuk input tanggal
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
        });

        // Inisialisasi Tom Select untuk dropdown yang canggih
        new TomSelect('#unit_kerja_select', {
            plugins: ['remove_button'],
            placeholder: 'Pilih satu atau lebih unit kerja...'
        });
    });
</script>
@endpush