{{-- Menghubungkan view ini dengan layout utama admin panel --}}
@extends('layouts.admin')

{{-- Semua konten di bawah ini akan dimasukkan ke dalam @yield('content') di layout utama --}}
@section('content')
<div class="p-4 sm:p-6" x-data="{}">

    {{-- Header Halaman Premium dengan Breadcrumbs dan Tombol Aksi --}}
    <div class="mb-8 bg-white rounded-xl p-4 md:p-6 border-l-4 border-indigo-500 shadow-sm">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start">
            <div>
                <!-- Breadcrumbs -->
                <nav class="text-sm mb-2 font-medium text-gray-500" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('superadmin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('surveys.index') }}" class="hover:text-indigo-600">Manajemen Survei</a>
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-700">Hasil Survei</span>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-4 mt-2">
                    <div class="flex-shrink-0 bg-indigo-500 text-white p-3 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $survey->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Analisis mendalam dari jawaban yang terkumpul.</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex items-center gap-3 self-start md:self-end">
                <a href="{{ route('surveys.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center justify-center space-x-2 border border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Kartu Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Responden -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 flex items-center gap-5 transform hover:scale-105 transition-transform duration-300">
            <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Responden</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalRespondents }}</p>
            </div>
        </div>
        <!-- Skor Rata-rata -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 flex items-center gap-5 transform hover:scale-105 transition-transform duration-300">
            <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0l-.07.004c-.03.002-.06.004-.09.006l-.09.006c-.03.002-.06.004-.09.006l-1.081.099a59.905 59.905 0 00-1.824 9.183M21.74 10.147l-1.081-.098a59.905 59.905 0 00-1.824-9.183M12 12.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Skor Rata-rata</p>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($averageScore, 2) }}</p>
            </div>
        </div>
        <!-- Peringkat Kinerja -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 flex items-center gap-5 transform hover:scale-105 transition-transform duration-300">
            <div class="{{ $performanceIndicator['bg_color'] }} {{ $performanceIndicator['text_color'] }} p-4 rounded-full">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Peringkat Kinerja</p>
                <p class="text-2xl font-bold {{ $performanceIndicator['text_color'] }}">{{ $performanceIndicator['label'] }}</p>
            </div>
        </div>
    </div>

    <!-- Analisis per Pertanyaan -->
    <div class="space-y-8">
        @forelse ($chartData as $index => $questionData)
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 transition-all duration-300 hover:shadow-2xl hover:border-indigo-300">
            <h3 class="font-bold text-lg text-gray-800 flex items-start">
                <span class="mr-2 text-indigo-600">{{ $loop->iteration }}.</span>
                <span class="flex-1">{{ $questionData['question_body'] }}</span>
            </h3>
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="relative h-64 md:h-72 flex items-center justify-center">
                    <canvas id="chart-{{ $questionData['question_id'] }}"></canvas>
                </div>
                <div>
                    <ul class="space-y-3">
                        @foreach($questionData['options'] as $optionIndex => $option)
                        @php
                        $count = $questionData['data'][$optionIndex];
                        $percentage = $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0;
                        @endphp
                        <li class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-sm mr-3" style="background-color: {{ $questionData['background_colors'][$optionIndex] }}"></span>
                                <span class="font-medium text-gray-700">{{ $option->option_body }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-semibold text-gray-800 w-8 text-right">{{ $count }}</span>
                                <span class="text-gray-500 w-16 text-right">({{ number_format($percentage, 1) }}%)</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-lg p-8 text-center border-2 border-dashed">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <p class="mt-4 font-semibold text-gray-600">Belum Ada Data Jawaban</p>
            <p class="text-gray-500 text-sm mt-1">Belum ada responden yang mengisi survei ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection


{{-- Menambahkan script khusus untuk halaman ini ke dalam layout --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = @json($chartData);

        chartData.forEach(questionData => {
            const ctx = document.getElementById(`chart-${questionData.question_id}`).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: questionData.labels,
                    datasets: [{
                        label: 'Jumlah Jawaban',
                        data: questionData.data,
                        backgroundColor: questionData.background_colors,
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Legenda kustom sudah dibuat di HTML
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? (context.parsed / total * 100).toFixed(1) + '%' : '0%';
                                        label += `${context.raw} (${percentage})`;
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        });
    });
</script>
@endpush