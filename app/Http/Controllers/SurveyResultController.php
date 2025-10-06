<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyResultController extends Controller
{
    /**
     * Menampilkan halaman hasil survei dengan visualisasi data.
     */
    public function show(Survey $survey)
    {
        // 1. Eager load relasi yang dibutuhkan untuk efisiensi
        $survey->load('questions.options');

        // 2. Hitung jumlah responden unik untuk survei ini
        $totalRespondents = Answer::where('survey_id', $survey->id)
            ->distinct('user_id')
            ->count('user_id');

        // 3. Siapkan data untuk dikirim ke chart (grafik)
        $chartData = [];
        foreach ($survey->questions as $question) {
            // Ambil jumlah jawaban untuk setiap opsi pada pertanyaan ini
            $answerCounts = Answer::where('question_id', $question->id)
                ->select('option_id', DB::raw('count(*) as total'))
                ->groupBy('option_id')
                ->pluck('total', 'option_id');

            // Siapkan label (teks opsi) dan data (jumlah suara) untuk grafik
            $labels = $question->options->pluck('option_body');
            $data = $question->options->map(function ($option) use ($answerCounts) {
                // Jika ada jawaban untuk opsi ini, ambil jumlahnya. Jika tidak, anggap 0.
                return $answerCounts->get($option->id, 0);
            });

            // Kumpulkan semua data yang dibutuhkan untuk satu pertanyaan
            $chartData[] = [
                'question_id' => $question->id,
                'question_body' => $question->question_body,
                'labels' => $labels,
                'data' => $data,
                'options' => $question->options // Kirim juga data opsi untuk tabel
            ];
        }

        // 4. Kirim semua data ke view
        return view('surveys.results', compact('survey', 'totalRespondents', 'chartData'));
    }
}
