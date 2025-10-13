<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\TipeUnit;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUnitKerjaRequest;

class UnitKerjaController extends Controller
{
    /**
     */
    public function index(Request $request)
    {
        $query = UnitKerja::with(['tipeUnit', 'parent'])
            ->withCount('children') // <-- Kunci untuk tombol "Lihat Sub-Unit"
            ->filter($request->only('search', 'type', 'parent'));

        if ($request->filled('sort')) {
            match ($request->sort) {
                'name_asc'  => $query->orderBy('unit_kerja_name', 'asc'),
                'name_desc' => $query->orderBy('unit_kerja_name', 'desc'),
                'latest'    => $query->latest(), // Urutkan berdasarkan created_at (terbaru)
                'oldest'    => $query->oldest(), // Urutkan berdasarkan created_at (terlama)
                default     => $query->orderBy('id', 'asc'),
            };
        } else {
            $query->orderBy('id', 'asc');
        }

        $unitKerja = $query->paginate(10)->withQueryString();

        $tipeUnits = TipeUnit::orderBy('nama_tipe_unit', 'asc')->get();
        $parentUnits = UnitKerja::orderBy('unit_kerja_name', 'asc')->get();

        return view('unit_kerja.index', compact('unitKerja', 'tipeUnits', 'parentUnits'));
    }

    /**
     */
    public function create()
    {
        return view('unit_kerja.create', [
            'tipeUnits' => TipeUnit::pluck('nama_tipe_unit', 'id'),
            'parentUnits' => UnitKerja::pluck('unit_kerja_name', 'id')
        ]);
    }

    /**
     */
    public function store(StoreUnitKerjaRequest $request)
    {
        UnitKerja::create($request->validated());
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil ditambahkan!');
    }

    /**
     */
    public function edit(UnitKerja $unitKerja)
    {
        return view('unit_kerja.edit', [
            'unitKerja' => $unitKerja,
            'tipeUnits' => TipeUnit::pluck('nama_tipe_unit', 'id'),
            'parentUnits' => UnitKerja::pluck('unit_kerja_name', 'id')
        ]);
    }

    /**
     */
    public function update(StoreUnitKerjaRequest $request, UnitKerja $unitKerja)
    {
        $unitKerja->update($request->validated());
        return redirect()->route('unit-kerja.index')->with('success', 'Data unit kerja berhasil diperbarui!');
    }

    /**
     */
    public function destroy(UnitKerja $unitKerja)
    {
        if ($unitKerja->users()->exists() || $unitKerja->surveys()->exists()) {
            return redirect()->route('unit-kerja.index')
                ->with('error', 'Gagal! Unit kerja "' . $unitKerja->unit_kerja_name . '" tidak dapat dihapus karena masih memiliki pengguna atau survei terkait.');
        }

        $unitKerja->delete();
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil dihapus!');
    }
}
