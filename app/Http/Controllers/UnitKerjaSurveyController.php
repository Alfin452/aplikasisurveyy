<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request; // <-- DITAMBAHKAN
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitKerjaSurveyController extends Controller
{
    use AuthorizesRequests;

    /**
     * DIUBAH: Method index() sekarang menangani filter dan sorting.
     */
    public function index(Request $request)
    {
        $unitKerjaId = Auth::user()->unit_kerja_id;

        if (!$unitKerjaId) {
            return view('unit_kerja_admin.surveys.index', ['surveys' => collect(), 'years' => collect()]);
        }

        // Mulai query dengan filter dasar: hanya survei milik unit kerja ini
        $query = Survey::whereHas('unitKerja', function ($q) use ($unitKerjaId) {
            $q->where('unit_kerjas.id', $unitKerjaId);
        })
        ->where('is_template', false)
        // Terapkan filter dari request (search, status, year)
        ->filter($request->only('search', 'status', 'year'));

        // Logika pengurutan
        $sort = $request->input('sort', 'latest'); // Default ke 'latest'
        match ($sort) {
            'title_asc'   => $query->orderBy('title', 'asc'),
            'title_desc'  => $query->orderBy('title', 'desc'),
            'oldest'      => $query->oldest(),
            default       => $query->latest(),
        };
        
        $surveys = $query->with('unitKerja')->paginate(10)->withQueryString();

        // Ambil tahun-tahun unik dari survei MILIK UNIT KERJA INI saja untuk dropdown filter
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

    // ... (method create, store, show, edit, update, destroy tidak berubah) ...
    public function create()
    {
        return view('unit_kerja_admin.surveys.create');
    }
    public function store(Request $request)
    {
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
    }
    public function show(Survey $survey)
    {
        // 1. Pastikan pengguna berhak melihat survei ini
        $this->authorize('view', $survey);

        // 2. Ambil semua pertanyaan & opsi terkait dari survei ini
        $survey->load('questions.options');

        // 3. Tampilkan halaman "Kelola Pertanyaan"
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

