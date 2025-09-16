<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Tampilkan daftar semua unit kerja.
     */
    public function index(Request $request)
    {
        $query = UnitKerja::query();

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $unitKerja = $query->orderBy('id', 'asc')->get();
        $types = UnitKerja::select('type')->distinct()->pluck('type');

        return view('unit_kerja.index', compact('unitKerja', 'types'));
    }

    /**
     * Tampilkan formulir untuk membuat unit kerja baru.
     */
    public function create()
    {
        return view('unit_kerja.create');
    }

    /**
     * Simpan unit kerja yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unit_kerja_name' => 'required|max:255',
            'uk_short_name'   => 'nullable|max:255',
            'type'            => 'required|max:255',
            'parent_id'       => 'nullable|integer',
            'contact'         => 'nullable|max:255',
            'address'         => 'nullable|max:255',
            'start_time'      => 'nullable',
            'end_time'        => 'nullable',
        ]);

        UnitKerja::create($validatedData);

        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil ditambahkan!');
    }

    /**
     * Tampilkan formulir untuk mengedit unit kerja.
     */
    public function edit(UnitKerja $unitKerja)
    {
        return view('unit_kerja.edit', compact('unitKerja'));
    }

    /**
     * Perbarui data unit kerja di database.
     */
    public function update(Request $request, UnitKerja $unitKerja)
    {
        $validatedData = $request->validate([
            'unit_kerja_name' => 'required|max:255',
            'uk_short_name'   => 'nullable|max:255',
            'type'            => 'required|max:255',
            'parent_id'       => 'nullable|integer',
            'contact'         => 'nullable|max:255',
            'address'         => 'nullable|max:255',
            'start_time'      => 'nullable',
            'end_time'        => 'nullable',
        ]);

        $unitKerja->update($validatedData);

        return redirect()->route('unit-kerja.index')->with('success', 'Data unit kerja berhasil diperbarui!');
    }

    /**
     * Hapus unit kerja dari database.
     */
    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();

        return redirect()->route('unit-kerja.index')->with('success', 'Unit kerja berhasil dihapus!');
    }
}
