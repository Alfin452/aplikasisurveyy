<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    // ... method index() dan create() Anda sudah sempurna ...
    public function index(Survey $survey)
    {
        return view('surveys.questions.index', compact('survey'));
    }

    public function create(Survey $survey)
    {
        return view('surveys.questions.create', compact('survey'));
    }

    // ... method store() Anda sudah sempurna ...
    public function store(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'question_body' => 'required|string',
            'type' => 'required|string|in:multiple_choice,text', // Lebih spesifik
            'options' => 'required_if:type,multiple_choice|array',
            'options.*.option_body' => 'required|string',
            'options.*.option_score' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $question = $survey->questions()->create([
                'question_body' => $validated['question_body'],
                'type' => $validated['type'],
            ]);

            if (isset($validated['options'])) {
                foreach ($validated['options'] as $optionData) {
                    $question->options()->create($optionData);
                }
            }

            DB::commit();
            return redirect()->route('surveys.show', $survey)->with('success', 'Pertanyaan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Survey $survey, Question $question)
    {
        // Diubah: Menggunakan abort_if untuk kode yang lebih singkat
        abort_if($question->survey_id !== $survey->id, 404);

        // Eager load options untuk ditampilkan di form edit
        $question->load('options');

        return view('surveys.questions.edit', compact('survey', 'question'));
    }

    /**
     * Ditambahkan: Implementasi lengkap untuk method update().
     */
    public function update(Request $request, Survey $survey, Question $question)
    {
        abort_if($question->survey_id !== $survey->id, 404);

        $validated = $request->validate([
            'question_body' => 'required|string',
            'type' => 'required|string|in:multiple_choice,text',
            'options' => 'required_if:type,multiple_choice|array',
            'options.*.id' => 'nullable|exists:options,id', // Untuk opsi yang sudah ada
            'options.*.option_body' => 'required|string',
            'options.*.option_score' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update data pertanyaan
            $question->update([
                'question_body' => $validated['question_body'],
                'type' => $validated['type'],
            ]);

            $incomingOptionIds = [];
            if (isset($validated['options'])) {
                foreach ($validated['options'] as $optionData) {
                    // Jika ada ID, update opsi yang ada. Jika tidak, buat baru.
                    $option = $question->options()->updateOrCreate(
                        ['id' => $optionData['id'] ?? null],
                        [
                            'option_body' => $optionData['option_body'],
                            'option_score' => $optionData['option_score'],
                        ]
                    );
                    $incomingOptionIds[] = $option->id;
                }
            }

            // 2. Hapus opsi lama yang tidak ada di data yang masuk
            $question->options()->whereNotIn('id', $incomingOptionIds)->delete();

            DB::commit();
            return redirect()->route('surveys.show', $survey)->with('success', 'Pertanyaan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Ditambahkan: Implementasi lengkap untuk method destroy().
     */
    public function destroy(Survey $survey, Question $question)
    {
        abort_if($question->survey_id !== $survey->id, 404);

        // Berkat onDelete('cascade'), semua opsi akan ikut terhapus.
        $question->delete();

        return redirect()->route('surveys.show', $survey)->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
