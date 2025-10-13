<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyTemplateController extends Controller
{
    public function index()
    {
        $templates = Survey::where('is_template', true)->withCount('questions')->latest()->get();
        // Mengambil survei lengkap beserta jumlah pertanyaannya
        $surveysToCopy = Survey::where('is_template', false)->withCount('questions')->get();

        return view('templates.index', compact('templates', 'surveysToCopy'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'survey_id' => 'required|exists:surveys,id'
        ]);

        $originalSurvey = Survey::findOrFail($validated['survey_id']);

        $newTemplate = DB::transaction(function () use ($originalSurvey) {
            return $this->duplicateSurvey($originalSurvey, true);
        });

        if (!$newTemplate) {
            return back()->with('error', 'Gagal membuat template.');
        }

        return redirect()->route('templates.index')->with('success', 'Survei berhasil dijadikan template!');
    }

    public function createFromTemplate(Survey $template)
    {
        abort_if(!$template->is_template, 404, 'Survei yang dipilih bukan template.');

        $newSurvey = DB::transaction(function () use ($template) {
            return $this->duplicateSurvey($template, false);
        });

        if (!$newSurvey) {
            return back()->with('error', 'Gagal membuat survei dari template.');
        }

        return redirect()->route('surveys.edit', $newSurvey->id)->with('success', 'Survei baru berhasil dibuat dari template!');
    }

    public function destroy(Survey $template)
    {
        abort_if(!$template->is_template, 404);
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus!');
    }

    /**
     */
    private function duplicateSurvey(Survey $surveyToDuplicate, bool $asTemplate): Survey
    {
        $surveyToDuplicate->load('questions.options', 'unitKerja');

        $newSurvey = $surveyToDuplicate->replicate();

        $newSurvey->is_template = $asTemplate;

        if ($asTemplate) {
            $newSurvey->title = $surveyToDuplicate->title . ' (Template)';
            $newSurvey->is_active = false;
        } else {
            $newSurvey->title = str_replace(' (Template)', '', $surveyToDuplicate->title) . ' (Copy)';
            $newSurvey->is_active = false;
        }

        $newSurvey->save();

        if ($surveyToDuplicate->questions->isNotEmpty()) {
            foreach ($surveyToDuplicate->questions as $question) {
                $newQuestion = $question->replicate()->fill(['survey_id' => $newSurvey->id]);
                $newQuestion->save();

                if ($question->options->isNotEmpty()) {
                    $newOptions = $question->options->map(function ($option) use ($newQuestion) {
                        return $option->replicate()->fill(['question_id' => $newQuestion->id]);
                    });
                    $newQuestion->options()->saveMany($newOptions);
                }
            }
        }

        $unitKerjaIds = $surveyToDuplicate->unitKerja->pluck('id');
        if ($unitKerjaIds->isNotEmpty()) {
            $newSurvey->unitKerja()->sync($unitKerjaIds);
        }

        return $newSurvey;
    }
}
