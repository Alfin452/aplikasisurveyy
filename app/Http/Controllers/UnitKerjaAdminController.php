<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitKerjaAdminController extends Controller
{
    /**
     */
    public function index()
    {
        $user = Auth::user();

        $unitKerja = $user->unitKerja;

        return view('unit_kerja_admin.dashboard', compact('user', 'unitKerja'));
    }
}
