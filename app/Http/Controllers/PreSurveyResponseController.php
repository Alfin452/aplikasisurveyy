<?php

namespace App\Http\Controllers;

use App\Models\PreSurveyResponse;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreSurveyResponseController extends Controller
{
    /**
     * Menampilkan formulir data awal (pra-survei).
     */
    public function create(Survey $survey)
    {
        // Cukup tampilkan view dan kirim data survei yang relevan
        return view('public.surveys.pre_survey_form', compact('survey'));
    }

    /**
     * Menyimpan data dari formulir pra-survei.
     */
    public function store(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'full_name'                 => 'required|string|max:255',
            'gender'                    => 'required|string|in:Laki-laki,Perempuan',
            'age'                       => 'required|integer|min:15|max:100',
            'status'                    => 'required|string|max:255',
            'unit_kerja_or_fakultas'    => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Buat atau perbarui data pra-survei untuk user dan survei ini
        PreSurveyResponse::updateOrCreate(
            [
                'survey_id' => $survey->id,
                'user_id'   => $user->id,
            ],
            [
                'full_name'                 => $validated['full_name'],
                'gender'                    => $validated['gender'],
                'age'                       => $validated['age'],
                'status'                    => $validated['status'],
                'unit_kerja_or_fakultas'    => $validated['unit_kerja_or_fakultas'],
            ]
        );

        // Setelah berhasil menyimpan, arahkan pengguna ke halaman pengisian survei yang sebenarnya
        return redirect()->route('surveys.fill', $survey);
    }
}
