<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyResultController extends Controller
{
    /**
     * Menampilkan halaman hasil survei yang sudah dianalisis.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\View\View
     */
    public function show(Survey $survey)
    {
        // 1. Ambil semua data yang relevan
        $questions = $survey->questions()->with('options')->orderBy('order_column')->get();
        $answers = Answer::where('survey_id', $survey->id)->get();

        // 2. Hitung metrik utama
        $totalRespondents = $answers->unique('user_id')->count();
        $totalScore = 0;
        if ($totalRespondents > 0) {
            // Menjumlahkan skor dari semua jawaban responden
            $totalScore = DB::table('answers')
                ->join('options', 'answers.option_id', '=', 'options.id')
                ->where('answers.survey_id', $survey->id)
                ->sum('options.option_score');
        }

        // Menghitung skor rata-rata per responden
        $averageScore = $totalRespondents > 0 ? $totalScore / $totalRespondents : 0;
        $performanceIndicator = $this->getPerformanceIndicator($averageScore);

        // 3. Siapkan data untuk Chart.js (diagram)
        $chartData = [];
        $colors = ['#4f46e5', '#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe', '#e0e7ff']; // Palet warna Indigo

        foreach ($questions as $question) {
            if ($question->type === 'multiple_choice') {
                $labels = $question->options->pluck('option_body')->toArray();
                $data = [];
                foreach ($question->options as $option) {
                    $data[] = $answers->where('option_id', $option->id)->count();
                }

                $chartData[] = [
                    'question_id' => $question->id,
                    'question_body' => $question->question_body,
                    'labels' => $labels,
                    'data' => $data,
                    'options' => $question->options, // Untuk tabel data
                    'background_colors' => array_slice($colors, 0, count($labels))
                ];
            }
        }

        // 4. Kirim semua data yang sudah diproses ke view
        return view('surveys.results', compact(
            'survey',
            'totalRespondents',
            'averageScore',
            'performanceIndicator',
            'chartData'
        ));
    }

    /**
     * Menentukan label dan warna indikator kinerja berdasarkan skor rata-rata.
     *
     * @param  float  $score
     * @return array
     */
    private function getPerformanceIndicator(float $score): array
    {
        if ($score >= 4.0) {
            return ['label' => 'Sangat Baik', 'text_color' => 'text-green-800', 'bg_color' => 'bg-green-100'];
        } elseif ($score >= 3.0) {
            return ['label' => 'Baik', 'text_color' => 'text-indigo-800', 'bg_color' => 'bg-indigo-100'];
        } elseif ($score >= 2.0) {
            return ['label' => 'Cukup', 'text_color' => 'text-amber-800', 'bg_color' => 'bg-amber-100'];
        } elseif ($score > 0) {
            return ['label' => 'Kurang', 'text_color' => 'text-red-800', 'bg_color' => 'bg-red-100'];
        } else {
            return ['label' => 'Belum Dinilai', 'text_color' => 'text-gray-800', 'bg_color' => 'bg-gray-100'];
        }
    }
}
