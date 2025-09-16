@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Pengguna Baru</h1>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
        </div>
        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="role_id" name="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="unit_kerja_id" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
            <select id="unit_kerja_id" name="unit_kerja_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                <option value="">-- Pilih Unit Kerja --</option>
                @foreach($unitKerja as $unit)
                <option value="{{ $unit->id }}">{{ $unit->unit_kerja_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center space-x-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
                Simpan
            </button>
            <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-lg font-medium hover:bg-gray-400 transition duration-300 shadow-lg transform hover:scale-105">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection