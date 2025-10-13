<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitKerjaTemplateController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $admin = Auth::user();
        $unitKerjaId = $admin->unit_kerja_id;

        // DIUBAH: Hanya ambil template yang relevan dengan unit kerja ini
        $templates = Survey::where('is_template', true)
            ->whereHas('unitKerja', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerjas.id', $unitKerjaId);
            })
            ->withCount('questions')
            ->latest()
            ->get();

        // DIUBAH: Hanya ambil survei yang bisa dijadikan template oleh admin unit kerja ini
        $surveysToCopy = Survey::where('is_template', false)
            ->whereHas('unitKerja', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerjas.id', $unitKerjaId);
            })
            ->withCount('questions')
            ->get();

        return view('unit_kerja_admin.templates.index', compact('templates', 'surveysToCopy'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['survey_id' => 'required|exists:surveys,id']);
        $originalSurvey = Survey::findOrFail($validated['survey_id']);
        $this->authorize('update', $originalSurvey);

        $newTemplate = DB::transaction(function () use ($originalSurvey) {
            return $this->duplicateSurvey($originalSurvey, true);
        });

        if (!$newTemplate) {
            return back()->with('error', 'Gagal membuat template.');
        }

        return redirect()->route('unitkerja.admin.templates.index')->with('success', 'Survei berhasil dijadikan template!');
    }

    public function createFromTemplate(Survey $template)
    {
        abort_if(!$template->is_template, 404, 'Survei yang dipilih bukan template.');
        $this->authorize('view', $template);

        $newSurvey = DB::transaction(function () use ($template) {
            return $this->duplicateSurvey($template, false);
        });

        if (!$newSurvey) {
            return back()->with('error', 'Gagal membuat survei dari template.');
        }

        return redirect()->route('unitkerja.admin.surveys.edit', $newSurvey->id)->with('success', 'Survei baru berhasil dibuat dari template! Silakan sesuaikan detailnya.');
    }

    public function destroy(Survey $template)
    {
        abort_if(!$template->is_template, 404);
        $this->authorize('delete', $template);
        $template->delete();
        return redirect()->route('unitkerja.admin.templates.index')->with('success', 'Template berhasil dihapus.');
    }

    private function duplicateSurvey(Survey $surveyToDuplicate, bool $asTemplate): Survey
    {
        $surveyToDuplicate->load('questions.options');

        $newSurvey = $surveyToDuplicate->replicate();
        $newSurvey->is_template = $asTemplate;

        if ($asTemplate) {
            $newSurvey->title = $surveyToDuplicate->title . ' (Template)';
            $newSurvey->is_active = false;
        } else {
            $newSurvey->title = str_replace(' (Template)', '', $surveyToDuplicate->title);
            $newSurvey->is_active = false;
            $newSurvey->start_date = now();
            $newSurvey->end_date = now()->addWeek();
        }

        $newSurvey->save();

        if (!$asTemplate) {
            $newSurvey->unitKerja()->attach(Auth::user()->unit_kerja_id);
        } else {
            $unitKerjaIds = $surveyToDuplicate->unitKerja->pluck('id');
            if ($unitKerjaIds->isNotEmpty()) {
                $newSurvey->unitKerja()->sync($unitKerjaIds);
            }
        }

        foreach ($surveyToDuplicate->questions as $question) {
            $newQuestion = $question->replicate()->fill(['survey_id' => $newSurvey->id]);
            $newQuestion->save();

            if ($question->options->isNotEmpty()) {
                $newOptions = $question->options->map(fn($option) => $option->replicate()->fill(['question_id' => $newQuestion->id]));
                $newQuestion->options()->saveMany($newOptions);
            }
        }

        return $newSurvey;
    }
}
