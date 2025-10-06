<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitKerjaSurveyController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $unitKerjaId = Auth::user()->unit_kerja_id;

        if (!$unitKerjaId) {
            return view('unit_kerja_admin.surveys.index', ['surveys' => collect(), 'years' => collect()]);
        }

        $query = Survey::whereHas('unitKerja', function ($q) use ($unitKerjaId) {
            $q->where('unit_kerjas.id', $unitKerjaId);
        })
            ->where('is_template', false)
            ->filter($request->only('search', 'status', 'year'));

        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'title_asc'   => $query->orderBy('title', 'asc'),
            'title_desc'  => $query->orderBy('title', 'desc'),
            'oldest'      => $query->oldest(),
            default       => $query->latest(),
        };

        $surveys = $query->with('unitKerja')->paginate(10)->withQueryString();

        $years = Survey::whereHas('unitKerja', function ($q) use ($unitKerjaId) {
            $q->where('unit_kerjas.id', $unitKerjaId);
        })
            ->where('is_template', false)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('unit_kerja_admin.surveys.index', compact('surveys', 'years'));
    }

    public function create()
    {
        return view('unit_kerja_admin.surveys.create');
    }

    /**
     * DIUBAH: Method store() sekarang sudah lengkap dengan logika penyimpanan.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $unitKerjaId = Auth::user()->unit_kerja_id;

        if (!$unitKerjaId) {
            return back()->with('error', 'Anda tidak terhubung dengan unit kerja manapun.');
        }

        DB::beginTransaction();
        try {
            // 2. Buat survei baru
            $survey = Survey::create([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'start_date'  => $validated['start_date'],
                'end_date'    => $validated['end_date'],
                'is_active'   => $request->boolean('is_active'),
            ]);

            // 3. Hubungkan survei dengan unit kerja admin secara otomatis
            $survey->unitKerja()->attach($unitKerjaId);

            DB::commit();

            return redirect()->route('unitkerja.admin.surveys.index')->with('success', 'Survei berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat survei: ' . $e->getMessage());
        }
    }

    public function show(Survey $survey)
    {
        $this->authorize('view', $survey);
        $survey->load('questions.options');
        return view('unit_kerja_admin.surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $this->authorize('update', $survey);
        return view('unit_kerja_admin.surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $survey->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('unitkerja.admin.surveys.index')->with('success', 'Survei berhasil diperbarui!');
    }

    public function destroy(Survey $survey)
    {
        $this->authorize('delete', $survey);
        $survey->delete();
        return redirect()->route('unitkerja.admin.surveys.index')->with('success', 'Survei berhasil dihapus!');
    }
}
