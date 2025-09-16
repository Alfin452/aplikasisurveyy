<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyTemplateController extends Controller
{
    /**
     * Tampilkan daftar survei yang berfungsi sebagai template.
     */
    public function index()
    {
        $templates = Survey::where('is_template', true)->get();
        $surveysToCopy = Survey::where('is_template', false)->with('questions')->get();

        return view('templates.index', compact('templates', 'surveysToCopy')); // Perubahan ada di sini
    }

    /**
     * Simpan survei yang ada sebagai template.
     */
    // app/Http/Controllers/SurveyTemplateController.php

    // ...

    public function store(Request $request)
    {
        $validated = $request->validate([
            'survey_id' => 'required|exists:surveys,id'
        ]);

        $originalSurvey = Survey::findOrFail($validated['survey_id']);

        // Duplikasi survei yang asli
        $newTemplate = $originalSurvey->replicate();
        $newTemplate->title = $originalSurvey->title . ' (Template)';
        $newTemplate->is_template = true; // Tandai salinan sebagai template
        $newTemplate->save();

        // Sekarang, duplikasi juga semua pertanyaan dan opsi jawabannya
        foreach ($originalSurvey->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->survey_id = $newTemplate->id;
            $newQuestion->save();

            foreach ($question->options as $option) {
                $newOption = $option->replicate();
                $newOption->question_id = $newQuestion->id;
                $newOption->save();
            }
        }

        return redirect()->route('templates.index')->with('success', 'Survei berhasil dijadikan template!');
    }

    /**
     * Buat survei baru dari template yang sudah ada.
     */
    public function createFromTemplate(Survey $survey)
    {
        // Duplikasi survei template
        $newSurvey = $survey->replicate();
        $newSurvey->title = $newSurvey->title . ' (Copy)';
        $newSurvey->is_template = false; // Survei baru bukan template
        $newSurvey->save();

        // Duplikasi pertanyaan dan opsi dari template
        foreach ($survey->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->survey_id = $newSurvey->id;
            $newQuestion->save();

            // Duplikasi opsi jawaban
            foreach ($question->options as $option) {
                $newOption = $option->replicate();
                $newOption->question_id = $newQuestion->id;
                $newOption->save();
            }
        }

        return redirect()->route('surveys.edit', $newSurvey->id)->with('success', 'Survei baru berhasil dibuat dari template!');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        
        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus!');
    }
}

