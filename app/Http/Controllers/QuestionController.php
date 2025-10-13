<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionController extends Controller
{
    use AuthorizesRequests;

    /**
     */
    public function create(Survey $survey)
    {
        $this->authorize('update', $survey);

        // DIUBAH: Menggunakan accessor is_superadmin untuk kode yang lebih bersih
        if (Auth::user()->is_superadmin) {
            return view('surveys.questions.create', compact('survey'));
        }

        return view('unit_kerja_admin.surveys.questions.create', compact('survey'));
    }

    /**
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $validated = $request->validate([
            'question_body' => 'required|string',
            'type' => 'required|string|in:multiple_choice',
            'options' => 'required|array|min:2',
            'options.*.option_body' => 'required|string',
            'options.*.option_score' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $question = $survey->questions()->create([
                'question_body' => $validated['question_body'],
                'type' => $validated['type'],
            ]);

            if (isset($validated['options'])) {
                $question->options()->createMany($validated['options']);
            }

            DB::commit();

            $redirectRoute = Auth::user()->is_superadmin ? 'surveys.show' : 'unitkerja.admin.surveys.show';
            return redirect()->route($redirectRoute, $survey)->with('success', 'Pertanyaan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     */
    public function edit(Survey $survey, Question $question)
    {
        $this->authorize('update', $survey);
        abort_if($question->survey_id !== $survey->id, 404);

        $question->load('options');

        if (Auth::user()->is_superadmin) {
            return view('surveys.questions.edit', compact('survey', 'question'));
        }

        return view('unit_kerja_admin.surveys.questions.edit', compact('survey', 'question'));
    }

    /**
     */
    public function update(Request $request, Survey $survey, Question $question)
    {
        $this->authorize('update', $survey);
        abort_if($question->survey_id !== $survey->id, 404);

        $validated = $request->validate([
            'question_body' => 'required|string',
            'type' => 'required|string|in:multiple_choice',
            'options' => 'required|array|min:2',
            'options.*.id' => 'nullable|exists:options,id',
            'options.*.option_body' => 'required|string',
            'options.*.option_score' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $question->update([
                'question_body' => $validated['question_body'],
                'type' => $validated['type'],
            ]);

            $incomingOptionIds = [];
            if (isset($validated['options'])) {
                foreach ($validated['options'] as $optionData) {
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

            $question->options()->whereNotIn('id', $incomingOptionIds)->delete();

            DB::commit();

            $redirectRoute = Auth::user()->is_superadmin ? 'surveys.show' : 'unitkerja.admin.surveys.show';
            return redirect()->route($redirectRoute, $survey)->with('success', 'Pertanyaan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     */
    public function destroy(Survey $survey, Question $question)
    {
        $this->authorize('update', $survey);
        abort_if($question->survey_id !== $survey->id, 404);

        $question->delete();

        $redirectRoute = Auth::user()->is_superadmin ? 'surveys.show' : 'unitkerja.admin.surveys.show';
        return redirect()->route($redirectRoute, $survey)->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
