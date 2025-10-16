<?php

namespace App\Http\Controllers;

use App\Models\SurveyProgram;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SurveyProgramController extends Controller
{
    /**
     */
    public function index()
    {
        $programs = SurveyProgram::withCount('surveys', 'targetedUnitKerjas')->latest()->paginate(10);
        return view('survey_programs.index', compact('programs'));
    }

    /**
     */
    public function create()
    {
        $program = new SurveyProgram();
        $unitKerjas = UnitKerja::orderBy('unit_kerja_name')->get();
        return view('survey_programs.create', compact('program', 'unitKerjas'));
    }

    /**
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:survey_programs,title',
            'description' => 'nullable|string',
            'targeted_unit_kerjas' => 'required|array',
            'targeted_unit_kerjas.*' => 'exists:unit_kerjas,id',
        ]);

        $program = SurveyProgram::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'alias' => Str::slug($validated['title']), // Membuat alias secara otomatis
        ]);

        $program->targetedUnitKerjas()->sync($validated['targeted_unit_kerjas']);

        return redirect()->route('programs.index')->with('success', 'Program Survei berhasil dibuat.');
    }

    /**
     */
    public function show(SurveyProgram $program)
    {
        $program->load('targetedUnitKerjas', 'surveys.unitKerja');
        return view('survey_programs.show', compact('program'));
    }

    /**
     */
    public function edit(SurveyProgram $program)
    {
        $unitKerjas = UnitKerja::orderBy('unit_kerja_name')->get();
        return view('survey_programs.edit', compact('program', 'unitKerjas'));
    }

    /**
     */
    public function update(Request $request, SurveyProgram $program)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('survey_programs')->ignore($program->id)],
            'description' => 'nullable|string',
            'targeted_unit_kerjas' => 'required|array',
            'targeted_unit_kerjas.*' => 'exists:unit_kerjas,id',
        ]);

        $program->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'alias' => Str::slug($validated['title']),
        ]);

        $program->targetedUnitKerjas()->sync($validated['targeted_unit_kerjas']);

        return redirect()->route('programs.index')->with('success', 'Program Survei berhasil diperbarui.');
    }

    /**
     */
    public function destroy(SurveyProgram $program)
    {
        // Tambahkan pengecekan jika program sudah memiliki survei turunan
        if ($program->surveys()->exists()) {
            return back()->with('error', 'Program ini tidak dapat dihapus karena sudah memiliki survei pelaksanaan.');
        }

        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program Survei berhasil dihapus.');
    }
}
