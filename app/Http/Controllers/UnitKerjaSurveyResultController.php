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
     */
    public function show(Survey $survey)
    {
        $survey->load('questions.options');

        $totalRespondents = Answer::where('survey_id', $survey->id)
            ->distinct('user_id')
            ->count('user_id');

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

        return view('unit_kerja_admin.surveys.results', compact('survey', 'totalRespondents', 'chartData'));
    }
}
