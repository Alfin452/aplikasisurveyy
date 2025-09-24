{{-- resources/views/unit_kerja/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Edit Unit Kerja</h1>
    <form action="{{ route('unit-kerja.update', $unitKerja) }}" method="POST">
        @method('PUT')
        @include('unit_kerja._form', ['unitKerja' => $unitKerja])
    </form>
</div>
@endsection