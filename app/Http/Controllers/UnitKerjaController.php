<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\TipeUnit;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUnitKerjaRequest;

class UnitKerjaController extends Controller
{
    /**
     * Menampilkan daftar semua unit kerja dengan filter dan pengurutan.
     */
    public function index(Request $request)
    {
        // Memulai query dengan eager loading dan menghitung sub-unit
        $query = UnitKerja::with(['tipeUnit', 'parent'])
            ->withCount('children') // <-- Kunci untuk tombol "Lihat Sub-Unit"
            ->filter($request->only('search', 'type', 'parent'));

        // Menerapkan logika pengurutan berdasarkan input dari form filter
        if ($request->filled('sort')) {
            match ($request->sort) {
                'name_asc'  => $query->orderBy('unit_kerja_name', 'asc'),
                'name_desc' => $query->orderBy('unit_kerja_name', 'desc'),
                'latest'    => $query->latest(), // Urutkan berdasarkan created_at (terbaru)
                'oldest'    => $query->oldest(), // Urutkan berdasarkan created_at (terlama)
                default     => $query->orderBy('id', 'asc'),
            };
        } else {
            // Pengurutan default jika tidak ada input
            $query->orderBy('id', 'asc');
        }

        // Menjalankan query dengan pagination
        $unitKerja = $query->paginate(10)->withQueryString();

        // Mengambil data untuk mengisi dropdown di panel filter
        $tipeUnits = TipeUnit::orderBy('nama_tipe_unit', 'asc')->get();
        $parentUnits = UnitKerja::orderBy('unit_kerja_name', 'asc')->get();

        return view('unit_kerja.index', compact('unitKerja', 'tipeUnits', 'parentUnits'));
    }

    /**
     * Menampilkan formulir untuk membuat unit kerja baru.
     */
    public function create()
    {
        return view('unit_kerja.create', [
            'tipeUnits' => TipeUnit::pluck('nama_tipe_unit', 'id'),
            'parentUnits' => UnitKerja::pluck('unit_kerja_name', 'id')
        ]);
    }

    /**
     * Menyimpan unit kerja baru ke database.
     */
    public function store(StoreUnitKerjaRequest $request)
    {
        UnitKerja::create($request->validated());
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit unit kerja.
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
     * Memperbarui data unit kerja di database.
     */
    public function update(StoreUnitKerjaRequest $request, UnitKerja $unitKerja)
    {
        $unitKerja->update($request->validated());
        return redirect()->route('unit-kerja.index')->with('success', 'Data unit kerja berhasil diperbarui!');
    }

    /**
     * Menghapus unit kerja dari database.
     */
    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();
        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil dihapus!');
    }
}
