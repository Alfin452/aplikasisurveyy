@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 animate-fade-in-up">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 animate-fade-in-up transform hover:scale-105 transition duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-indigo-500 text-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Survei</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalSurvei }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 animate-fade-in-up transform hover:scale-105 transition duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-green-500 text-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H9a1 1 0 01-1-1v-1a4 4 0 014-4h.29a.75.75 0 01.599.309L15 17m-6.75-2.25V5.25a2.25 2.25 0 10-4.5 0v10.5a2.25 2.25 0 104.5 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Responden</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalResponden }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 animate-fade-in-up transform hover:scale-105 transition duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-500 text-white rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 10h.01M9 14h.01M15 10h.01M15 14h.01M7 17h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Unit Kerja</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUnitKerja }}</p>
            </div>
        </div>
    </div>
</div>
@endsection