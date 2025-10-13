<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitKerjaSurveyController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $admin = Auth::user();
        $unitKerjaId = $admin->unit_kerja_id;

        $query = Survey::where('is_template', false)
            ->whereHas('unitKerja', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerjas.id', $unitKerjaId);
            });

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $surveys = $query->paginate(10)->withQueryString();

        $years = Survey::where('is_template', false)
            ->whereHas('unitKerja', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerjas.id', $unitKerjaId);
            })
            ->select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('unit_kerja_admin.surveys.index', compact('surveys', 'years'));
    }

    public function create()
    {
        $survey = new Survey();
        $templates = Survey::where('is_template', true)
            ->where(function ($query) {
                $query->whereHas('unitKerja', function ($q) {
                    $q->where('unit_kerjas.id', Auth::user()->unit_kerja_id);
                })->orWhere('is_global_template', true);
            })
            ->orderBy('title')
            ->get();

        return view('unit_kerja_admin.surveys.create', compact('survey', 'templates'));
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
            'is_active'             => 'nullable|boolean',
            'requires_pre_survey'   => 'nullable|boolean', // DITAMBAHKAN: Validasi
        ]);

        DB::beginTransaction();
        try {
            $surveyData = [
                'title'                 => $validated['title'],
                'description'           => $validated['description'],
                'start_date'            => $validated['start_date'],
                'end_date'              => $validated['end_date'],
                'is_active'             => $request->boolean('is_active'),
                'is_template'           => false,
                'requires_pre_survey'   => $request->boolean('requires_pre_survey'), // DITAMBAHKAN: Logika penyimpanan
            ];

            $survey = Survey::create($surveyData);

            if (!$survey) {
                throw new \Exception('Model Survey::create() gagal dan mengembalikan null.');
            }

            $adminUnitKerjaId = Auth::user()->unit_kerja_id;
            $survey->unitKerja()->attach($adminUnitKerjaId);

            DB::commit();

            return redirect()->route('unitkerja.admin.surveys.show', $survey)
                ->with('success', 'Survei berhasil dibuat. Sekarang Anda bisa menambahkan pertanyaan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan survei: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Survey $survey)
    {
        $this->authorize('view', $survey);

        $survey->load(['questions' => function ($query) {
            $query->orderBy('order_column', 'asc');
        }, 'questions.options']);

        return view('unit_kerja_admin.surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $this->authorize('update', $survey);
        // Menambahkan data templates untuk form edit juga jika diperlukan
        $templates = Survey::where('is_template', true)
            ->where(function ($query) {
                $query->whereHas('unitKerja', function ($q) {
                    $q->where('unit_kerjas.id', Auth::user()->unit_kerja_id);
                })->orWhere('is_global_template', true);
            })
            ->orderBy('title')
            ->get();
        return view('unit_kerja_admin.surveys.edit', compact('survey', 'templates'));
    }

    public function update(Request $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $validated = $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'nullable|string',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
            'is_active'             => 'nullable|boolean',
            'requires_pre_survey'   => 'nullable|boolean', // DITAMBAHKAN: Validasi
        ]);

        $surveyData = [
            'title'                 => $validated['title'],
            'description'           => $validated['description'],
            'start_date'            => $validated['start_date'],
            'end_date'              => $validated['end_date'],
            'is_active'             => $request->boolean('is_active'),
            'requires_pre_survey'   => $request->boolean('requires_pre_survey'), // DITAMBAHKAN: Logika penyimpanan
        ];

        $survey->update($surveyData);

        return redirect()->route('unitkerja.admin.surveys.index')->with('success', 'Survei berhasil diperbarui.');
    }

    public function destroy(Survey $survey)
    {
        $this->authorize('delete', $survey);
        $survey->delete();
        return redirect()->route('unitkerja.admin.surveys.index')->with('success', 'Survei berhasil dihapus.');
    }
}
