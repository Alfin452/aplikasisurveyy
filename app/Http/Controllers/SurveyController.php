<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surveys = Survey::where('is_template', false)->with('unitKerja')->get();
        return view('surveys.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitKerja = UnitKerja::all();
        return view('surveys.create', compact('unitKerja'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari formulir
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'unit_kerja'  => 'required|array',
            'unit_kerja.*' => 'exists:unit_kerja,id', // Memastikan ID unit kerja valid
        ]);

        // 2. Gunakan Transaction untuk memastikan data tersimpan dengan aman
        DB::beginTransaction();

        try {
            // 3. Buat survei baru
            $survey = Survey::create([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'start_date'  => $validated['start_date'],
                'end_date'    => $validated['end_date'],
                'is_active'   => true, // Survei baru aktif secara default
            ]);

            // 4. Hubungkan survei dengan unit kerja yang dipilih (Many-to-Many)
            $survey->unitKerja()->sync($validated['unit_kerja']);

            DB::commit();

            return redirect()->route('surveys.index')->with('success', 'Survei berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan survei: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        $unitKerja = UnitKerja::all();
        return view('surveys.edit', compact('survey', 'unitKerja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'unit_kerja'  => 'required|array',
            'unit_kerja.*' => 'exists:unit_kerja,id',
        ]);

        DB::beginTransaction();

        try {
            $survey->update([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'start_date'  => $validated['start_date'],
                'end_date'    => $validated['end_date'],
                'is_active'   => true,
            ]);

            $survey->unitKerja()->sync($validated['unit_kerja']);

            DB::commit();

            return redirect()->route('surveys.index')->with('success', 'Survei berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui survei: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        return redirect()->route('surveys.index')->with('success', 'Survei berhasil dihapus!');
    }

    
}
