<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     */
    public function index(Request $request)
    {
        $query = Survey::where('is_template', false)
            ->with('unitKerja')
            ->filter($request->only('search', 'status', 'unit_kerja', 'year'));

        if ($request->filled('sort')) {
            match ($request->sort) {
                'title_asc'  => $query->orderBy('title', 'asc'),
                'title_desc' => $query->orderBy('title', 'desc'),
                'oldest'     => $query->oldest(),
                default      => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $surveys = $query->paginate(10)->withQueryString();
        $unitKerjas = UnitKerja::orderBy('unit_kerja_name', 'asc')->get();
        $years = Survey::where('is_template', false)
            ->selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('surveys.index', compact('surveys', 'unitKerjas', 'years'));
    }

    /**
     */
    public function create()
    {
        $survey = new Survey();
        $unitKerja = UnitKerja::pluck('unit_kerja_name', 'id');
        return view('surveys.create', compact('survey', 'unitKerja'));
    }

    /**
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'nullable|string',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
            'unit_kerja'            => 'required|array',
            'unit_kerja.*'          => 'exists:unit_kerjas,id',
            'requires_pre_survey'   => 'nullable|boolean', // Validasi baru
        ]);

        DB::beginTransaction();
        try {
            $survey = Survey::create([
                'title'                 => $validated['title'],
                'description'           => $validated['description'],
                'start_date'            => $validated['start_date'],
                'end_date'              => $validated['end_date'],
                'is_active'             => $request->boolean('is_active'),
                'requires_pre_survey'   => $request->boolean('requires_pre_survey'), // Logika penyimpanan baru
            ]);

            $survey->unitKerja()->sync($validated['unit_kerja']);
            DB::commit();

            return redirect()->route('surveys.show', $survey)->with('success', 'Survei berhasil dibuat! Sekarang Anda bisa mulai menambahkan pertanyaan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan survei: ' . $e->getMessage())->withInput();
        }
    }

    /**
     */
    public function show(Survey $survey)
    {
        $survey->load(['questions' => function ($query) {
            $query->orderBy('order_column', 'asc');
        }, 'questions.options']);
        return view('surveys.show', compact('survey'));
    }

    /**
     */
    public function edit(Survey $survey)
    {
        $unitKerja = UnitKerja::pluck('unit_kerja_name', 'id');
        return view('surveys.edit', compact('survey', 'unitKerja'));
    }

    /**
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'nullable|string',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
            'unit_kerja'            => 'required|array',
            'unit_kerja.*'          => 'exists:unit_kerjas,id',
            'requires_pre_survey'   => 'nullable|boolean', // Validasi baru
        ]);

        DB::beginTransaction();
        try {
            $surveyData = [
                'title'                 => $validated['title'],
                'description'           => $validated['description'],
                'start_date'            => $validated['start_date'],
                'end_date'              => $validated['end_date'],
                'is_active'             => $request->boolean('is_active'),
                'requires_pre_survey'   => $request->boolean('requires_pre_survey'), // Logika penyimpanan baru
            ];

            $survey->update($surveyData);
            $survey->unitKerja()->sync($validated['unit_kerja']);
            DB::commit();

            return redirect()->route('surveys.index')->with('success', 'Survei berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui survei.')->withInput();
        }
    }

    /**
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'Survei berhasil dihapus!');
    }
}
