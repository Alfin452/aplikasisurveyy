{{-- resources/views/unit_kerja/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Tambah Unit Kerja</h1>
    <form action="{{ route('unit-kerja.store') }}" method="POST">
        @include('unit_kerja._form')
    </form>
</div>
@endsection