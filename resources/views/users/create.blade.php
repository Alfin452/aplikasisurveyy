@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Pengguna Baru</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @include('users._form')
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Tom Select untuk dropdown yang canggih
        new TomSelect('#role_id', {
            create: false
        });
        new TomSelect('#unit_kerja_id', {
            create: false
        });
    });
</script>
@endpush