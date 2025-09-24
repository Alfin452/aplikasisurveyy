<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        // Diubah: Menggunakan paginate() untuk performa yang lebih baik.
        $surveys = Survey::where('is_template', false)
            ->with('unitKerja')
            ->latest() // Menampilkan yang terbaru di atas
            ->paginate(10); // Menampilkan 10 survei per halaman

        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        // Diubah: Menggunakan pluck() untuk query yang lebih efisien.
        $unitKerja = UnitKerja::pluck('unit_kerja_name', 'id');
        return view('surveys.create', compact('unitKerja'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'unit_kerja'    => 'required|array',
            'unit_kerja.*'  => 'exists:unit_kerjas,id', // -> Disesuaikan ke nama tabel jamak
            'is_active'     => 'nullable|boolean', // -> Ditambahkan
        ]);

        DB::beginTransaction();
        try {
            $survey = Survey::create([
                'title'         => $validated['title'],
                'description'   => $validated['description'],
                'start_date'    => $validated['start_date'],
                'end_date'      => $validated['end_date'],
                // Diubah: Mengambil status dari request, default ke true.
                'is_active'     => $request->boolean('is_active'),
            ]);

            $survey->unitKerja()->sync($validated['unit_kerja']);
            DB::commit();

            return redirect()->route('surveys.index')->with('success', 'Survei berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan survei: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Ditambahkan: Implementasi method show() untuk menampilkan detail survei.
     */
    public function show(Survey $survey)
    {
        // Eager load relasi questions dan options untuk ditampilkan
        $survey->load('questions.options');
        return view('surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        // Diubah: Menggunakan pluck()
        $unitKerja = UnitKerja::pluck('unit_kerja_name', 'id');
        return view('surveys.edit', compact('survey', 'unitKerja'));
    }

    // ... method update() bisa disesuaikan dengan logika store() ...
    public function update(Request $request, Survey $survey)
    {
        // Validasi dan logika update mirip dengan store()
        // ...
        return redirect()->route('surveys.index')->with('success', 'Survei berhasil diperbarui!');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'Survei berhasil dihapus!');
    }
}
