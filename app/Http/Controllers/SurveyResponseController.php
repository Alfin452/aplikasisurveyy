<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Answer;
use App\Models\Option;
use App\Models\PreSurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SurveyResponseController extends Controller
{
    /**
     * Menampilkan form survei atau pra-survei sesuai kondisi.
     */
    public function showFillForm(Survey $survey)
    {
        $user = Auth::user();

        // Cek apakah pengguna sudah pernah mengisi survei utama
        $hasAnsweredMainSurvey = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $survey->questions->pluck('id'))
            ->exists();

        if ($hasAnsweredMainSurvey) {
            return redirect()
                ->route('surveys.thankyou')
                ->with('info', 'Anda sudah pernah mengisi survei ini sebelumnya.');
        }

        // Periksa apakah survei memerlukan pra-survei
        if ($survey->requires_pre_survey) {
            $hasFilledPreSurvey = PreSurveyResponse::where('user_id', $user->id)
                ->where('survey_id', $survey->id)
                ->exists();

            if (!$hasFilledPreSurvey) {
                return redirect()->route('surveys.pre-survey.create', $survey);
            }
        }

        // Tampilkan survei utama
        $survey->load('questions.options');
        return view('public.surveys.fill', compact('survey'));
    }

    /**
     * Menyimpan jawaban survei utama.
     */
    public function storeResponse(Request $request, Survey $survey)
    {
        $user = Auth::user();
        $questionIds = $survey->questions->pluck('id');

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|exists:options,id',
        ]);

        $submittedQuestionIds = collect($request->answers)->keys();
        if ($questionIds->diff($submittedQuestionIds)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'answers' => 'Harap jawab semua pertanyaan yang tersedia.',
            ]);
        }

        $hasAnswered = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $questionIds)
            ->exists();

        if ($hasAnswered) {
            return redirect()
                ->route('surveys.thankyou')
                ->with('info', 'Anda sudah pernah mengisi survei ini sebelumnya.');
        }

        foreach ($request->answers as $question_id => $option_id) {
            $option = Option::find($option_id);

            if (!$option) continue; // Lewati jika opsi tidak valid

            Answer::create([
                'user_id' => $user->id,
                'survey_id' => $survey->id,
                'question_id' => $question_id,
                'option_id' => $option_id,
                'answer_skor' => $option->option_score ?? 0,
            ]);
        }

        return redirect()->route('surveys.thankyou');
    }

    /**
     * Menampilkan halaman ucapan terima kasih.
     */
    public function thankYou()
    {
        return view('public.surveys.thank-you');
    }
}
