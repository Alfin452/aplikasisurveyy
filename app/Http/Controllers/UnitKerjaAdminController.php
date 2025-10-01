<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitKerjaAdminController extends Controller
{
    /**
     * Menampilkan halaman dasbor untuk Admin Unit Kerja.
     * Method ini mengambil data pengguna yang sedang login dan unit kerjanya,
     * lalu mengirimkannya ke view dasbor.
     */
    public function index()
    {
        // Mengambil objek pengguna yang sedang terotentikasi
        $user = Auth::user();

        // Mengambil relasi 'unitKerja' dari model User.
        // Ini efisien karena Eager Loading sudah diatur jika diperlukan.
        $unitKerja = $user->unitKerja;

        // Mengirimkan data user dan unit kerjanya ke view
        return view('unit_kerja_admin.dashboard', compact('user', 'unitKerja'));
    }
}
