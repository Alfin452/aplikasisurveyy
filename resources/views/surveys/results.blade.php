@extends('layouts.admin')

@section('header-title', 'Hasil Survei: ' . $survey->title)

@section('content')
<div class="py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header Halaman -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">{{ $survey->title }}</h1>
            <p class="mt-2 text-gray-600">{{ $survey->description }}</p>
            <div class="border-t my-4"></div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="h-5 w-5 mr-1.5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    <span class="font-semibold">{{ $totalRespondents }}</span>
                    <span class="ml-1">Total Responden</span>
                </div>
            </div>
        </div>

        <!-- Analisis per Pertanyaan -->
        <div class="space-y-8">
            @foreach ($chartData as $index => $questionData)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="font-bold text-gray-800">{{ $loop->iteration }}. {{ $questionData['question_body'] }}</h3>
                <div class="mt-6">
                    {{-- Kanvas untuk Grafik --}}
                    <canvas id="chart-{{ $questionData['question_id'] }}"></canvas>
                </div>

                {{-- Tabel Detail Jawaban --}}
                <div class="mt-6 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Opsi Jawaban</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jumlah</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($questionData['options'] as $optionIndex => $option)
                                    @php
                                    $count = $questionData['data'][$optionIndex];
                                    $percentage = $totalRespondents > 0 ? ($count / $totalRespondents) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $option->option_body }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $count }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ number_format($percentage, 1) }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

{{-- Memuat library Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = @json($chartData);

        chartData.forEach(questionData => {
            const ctx = document.getElementById(`chart-${questionData.question_id}`).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: questionData.labels,
                    datasets: [{
                        label: 'Jumlah Jawaban',
                        data: questionData.data,
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Pastikan hanya integer yang ditampilkan di sumbu Y
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legenda karena sudah jelas
                        }
                    }
                }
            });
        });
    });
</script>
@endsection