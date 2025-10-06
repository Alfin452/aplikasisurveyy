<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class PublicSurveyController extends Controller
{
    /**
     * Menampilkan halaman landing page dengan daftar survei yang aktif.
     */
    public function index()
    {
        $surveys = Survey::where('is_active', true)
            ->where('is_template', false)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->with('unitKerja')
            ->latest()
            ->get();

        // DIUBAH: Mengarahkan ke view 'welcome' sesuai dengan file yang Anda gunakan
        return view('welcome', compact('surveys'));
    }
}
