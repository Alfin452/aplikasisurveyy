@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md">
    <div class="border-b pb-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pertanyaan Baru</h1>
        <p class="mt-1 text-gray-600">Untuk survei: <span class="font-semibold">{{ $survey->title }}</span></p>
    </div>

    <form action="{{ route('surveys.questions.store', $survey) }}" method="POST">
        @include('surveys.questions._form')
    </form>
</div>
@endsection