<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyTemplateController extends Controller
{
    public function index()
    {
        // Dioptimasi: Menggunakan pluck untuk dropdown lebih efisien
        $templates = Survey::where('is_template', true)->latest()->get();
        $surveysToCopy = Survey::where('is_template', false)->pluck('title', 'id');

        return view('templates.index', compact('templates', 'surveysToCopy'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'survey_id' => 'required|exists:surveys,id'
        ]);

        $originalSurvey = Survey::findOrFail($validated['survey_id']);

        // Dibungkus dalam Transaction
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
        // Safety check
        abort_if(!$template->is_template, 404, 'Survei yang dipilih bukan template.');
        
        // Dibungkus dalam Transaction
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
     * Ditambahkan: Private method untuk logika duplikasi (Prinsip DRY).
     *
     * @param Survey $surveyToDuplicate Survei yang akan diduplikasi.
     * @param bool $asTemplate Apakah hasil duplikasi adalah template?
     * @return Survey
     */
    private function duplicateSurvey(Survey $surveyToDuplicate, bool $asTemplate): Survey
    {
        // Dioptimasi: Eager load semua relasi sebelum loop
        $surveyToDuplicate->load('questions.options');

        $newSurvey = $surveyToDuplicate->replicate();
        $newSurvey->is_template = $asTemplate;
        
        if ($asTemplate) {
            $newSurvey->title = $surveyToDuplicate->title . ' (Template)';
        } else {
            // Hapus '(Template)' dari judul jika ada, dan tambahkan '(Copy)'
            $newSurvey->title = str_replace(' (Template)', '', $surveyToDuplicate->title) . ' (Copy)';
        }
        
        $newSurvey->save();

        foreach ($surveyToDuplicate->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->survey_id = $newSurvey->id;
            $newQuestion->save();

            foreach ($question->options as $option) {
                $newOption = $option->replicate();
                $newOption->question_id = $newQuestion->id;
                $newOption->save();
            }
        }

        return $newSurvey;
    }
}