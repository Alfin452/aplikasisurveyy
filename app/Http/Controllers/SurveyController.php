<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Menampilkan daftar semua survei untuk Superadmin dengan filter dan paginasi.
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
                'latest'     => $query->latest(),
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
     * Menampilkan form untuk membuat survei baru.
     */
    public function create()
    {
        $unitKerja = UnitKerja::pluck('unit_kerja_name', 'id');
        return view('surveys.create', compact('unitKerja'));
    }

    /**
     * Menyimpan survei baru yang dibuat oleh Superadmin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'unit_kerja'    => 'required|array',
            'unit_kerja.*'  => 'exists:unit_kerjas,id',
        ]);

        DB::beginTransaction();
        try {
            $survey = Survey::create([
                'title'         => $validated['title'],
                'description'   => $validated['description'],
                'start_date'    => $validated['start_date'],
                'end_date'      => $validated['end_date'],
                'is_active'     => $request->boolean('is_active'),
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
     * Menampilkan halaman detail survei (manajemen pertanyaan).
     */
    public function show(Survey $survey)
    {
        $survey->load(['questions' => function ($query) {
            $query->orderBy('order_column', 'asc');
        }, 'questions.options']);
        return view('surveys.show', compact('survey'));
    }

    /**
     * Menampilkan form untuk mengedit survei.
     */
    public function edit(Survey $survey)
    {
        $unitKerja = UnitKerja::pluck('unit_kerja_name', 'id');
        return view('surveys.edit', compact('survey', 'unitKerja'));
    }

    /**
     * Memperbarui data survei di database.
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'unit_kerja'    => 'required|array',
            'unit_kerja.*'  => 'exists:unit_kerjas,id',
        ]);

        DB::beginTransaction();
        try {
            $surveyData = [
                'title'         => $validated['title'],
                'description'   => $validated['description'],
                'start_date'    => $validated['start_date'],
                'end_date'      => $validated['end_date'],
                'is_active'     => $request->has('is_active'),
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
     * Menghapus survei dari database.
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'Survei berhasil dihapus!');
    }
}
