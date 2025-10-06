<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth; // Diperlukan untuk memeriksa peran pengguna

class QuestionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Menampilkan form untuk membuat pertanyaan baru, disesuaikan berdasarkan peran.
     */
    public function create(Survey $survey)
    {
        $this->authorize('update', $survey);

        // Cek peran untuk menampilkan view yang benar
        if (Auth::user()->role_id === 1) { // Superadmin
            return view('surveys.questions.create', compact('survey'));
        }

        // Admin Unit Kerja
        return view('unit_kerja_admin.surveys.questions.create', compact('survey'));
    }

    /**
     * Menyimpan pertanyaan baru dan mengarahkan kembali berdasarkan peran.
     */
    public function store(Request $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $validated = $request->validate([
            'question_body' => 'required|string',
            'type' => 'required|string|in:multiple_choice', // Hanya Pilihan Ganda
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

            // Tentukan rute redirect berdasarkan peran pengguna
            $redirectRoute = Auth::user()->role_id === 1
                ? 'surveys.show'
                : 'unitkerja.admin.surveys.show';

            return redirect()->route($redirectRoute, $survey)->with('success', 'Pertanyaan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit pertanyaan, disesuaikan berdasarkan peran.
     */
    public function edit(Survey $survey, Question $question)
    {
        $this->authorize('update', $survey);
        abort_if($question->survey_id !== $survey->id, 404);

        $question->load('options');

        // Cek peran untuk menampilkan view yang benar
        if (Auth::user()->role_id === 1) { // Superadmin
            return view('surveys.questions.edit', compact('survey', 'question'));
        }

        // Admin Unit Kerja
        return view('unit_kerja_admin.surveys.questions.edit', compact('survey', 'question'));
    }

    /**
     * Memperbarui pertanyaan dan mengarahkan kembali berdasarkan peran.
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

            // Tentukan rute redirect berdasarkan peran pengguna
            $redirectRoute = Auth::user()->role_id === 1
                ? 'surveys.show'
                : 'unitkerja.admin.surveys.show';

            return redirect()->route($redirectRoute, $survey)->with('success', 'Pertanyaan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus pertanyaan dan mengarahkan kembali berdasarkan peran.
     */
    public function destroy(Survey $survey, Question $question)
    {
        $this->authorize('update', $survey);
        abort_if($question->survey_id !== $survey->id, 404);

        $question->delete();

        // Tentukan rute redirect berdasarkan peran pengguna
        $redirectRoute = Auth::user()->role_id === 1
            ? 'surveys.show'
            : 'unitkerja.admin.surveys.show';

        return redirect()->route($redirectRoute, $survey)->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
