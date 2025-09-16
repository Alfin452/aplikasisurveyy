<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Survey $survey)
    {
        return view('surveys.questions.index', compact('survey'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Survey $survey)
    {
        return view('surveys.questions.create', compact('survey'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Survey $survey)
    {
        // Validasi data
        $validated = $request->validate([
            'question_body' => 'required|string',
            'type' => 'required|string',
            'options' => 'required|array',
            'options.*.option_body' => 'required|string',
            'options.*.option_score' => 'nullable|integer',
        ]);

        // Simpan pertanyaan dan opsi dalam sebuah transaction
        DB::beginTransaction();
        try {
            // Buat pertanyaan baru yang terhubung ke survei
            $question = $survey->questions()->create([
                'question_body' => $validated['question_body'],
                'type' => $validated['type'],
            ]);

            // Simpan opsi jawaban
            foreach ($validated['options'] as $optionData) {
                $question->options()->create([
                    'option_body' => $optionData['option_body'],
                    'option_score' => $optionData['option_score'],
                ]);
            }

            DB::commit();
            return redirect()->route('surveys.questions.index', $survey->id)->with('success', 'Pertanyaan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey, Question $question)
    {
        // Pastikan pertanyaan yang diedit memang milik survei yang benar
        if ($question->survey_id !== $survey->id) {
            abort(404);
        }

        return view('surveys.questions.edit', compact('survey', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

