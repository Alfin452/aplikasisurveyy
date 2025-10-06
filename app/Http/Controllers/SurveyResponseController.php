<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Answer;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SurveyResponseController extends Controller
{
    /**
     * Menampilkan halaman untuk mengisi survei.
     */
    public function showFillForm(Survey $survey)
    {
        $user = Auth::user();
        $hasAnswered = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $survey->questions->pluck('id'))
            ->exists();

        if ($hasAnswered) {
            return redirect()->route('surveys.thankyou')->with('info', 'Anda sudah pernah mengisi survei ini sebelumnya.');
        }

        $survey->load('questions.options');
        return view('public.surveys.fill', compact('survey'));
    }

    /**
     * Menyimpan jawaban survei dari responden.
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
            throw ValidationException::withMessages(['answers' => 'Harap jawab semua pertanyaan yang tersedia.']);
        }

        $hasAnswered = Answer::where('user_id', $user->id)
            ->whereIn('question_id', $questionIds)
            ->exists();

        if ($hasAnswered) {
            return redirect()->route('surveys.thankyou')->with('info', 'Anda sudah pernah mengisi survei ini sebelumnya.');
        }

        // DIUBAH: Logika penyimpanan sekarang lebih aman
        foreach ($request->answers as $question_id => $option_id) {
            $option = Option::find($option_id);

            // Simpan jawaban, gunakan skor dari opsi. Jika skornya null, gunakan 0 sebagai default.
            Answer::create([
                'user_id' => $user->id,
                'survey_id' => $survey->id,
                'question_id' => $question_id,
                'option_id' => $option_id,
                'answer_skor' => $option->skor ?? 0, // Ini adalah perbaikan kuncinya
            ]);
        }

        return redirect()->route('surveys.thankyou');
    }

    /**
     * Menampilkan halaman terima kasih setelah mengisi survei.
     */
    public function thankYou()
    {
        return view('public.surveys.thank-you');
    }
}
