<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnitKerjaSurveyResultController extends Controller
{
    /**
     * Menampilkan hasil survei yang sudah difilter untuk Admin Unit Kerja.
     */
    public function show(Survey $survey)
    {
        // LOGIKA DIUBAH: Kita tidak lagi memfilter berdasarkan asal responden.
        // Sebaliknya, kita akan menampilkan SEMUA jawaban untuk survei ini,
        // karena hak akses ke survei ini sendiri sudah diatur di halaman sebelumnya.

        // 1. Eager load relasi yang dibutuhkan
        $survey->load('questions.options');

        // 2. Hitung jumlah total responden unik untuk survei ini (tanpa filter unit kerja)
        $totalRespondents = Answer::where('survey_id', $survey->id)
            ->distinct('user_id')
            ->count('user_id');

        // 3. Siapkan data untuk grafik
        $chartData = [];
        foreach ($survey->questions as $question) {
            // Ambil jumlah jawaban untuk setiap opsi (tanpa filter unit kerja)
            $answerCounts = Answer::where('question_id', $question->id)
                ->select('option_id', DB::raw('count(*) as total'))
                ->groupBy('option_id')
                ->pluck('total', 'option_id');

            $labels = $question->options->pluck('option_body');
            $data = $question->options->map(function ($option) use ($answerCounts) {
                return $answerCounts->get($option->id, 0);
            });

            $chartData[] = [
                'question_id' => $question->id,
                'question_body' => $question->question_body,
                'labels' => $labels,
                'data' => $data,
                'options' => $question->options
            ];
        }

        // 4. Kirim semua data yang sudah terfilter ke view
        return view('unit_kerja_admin.surveys.results', compact('survey', 'totalRespondents', 'chartData'));
    }
}
