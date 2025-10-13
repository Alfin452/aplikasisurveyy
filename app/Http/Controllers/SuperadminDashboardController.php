<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Survey; 
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class SuperadminDashboardController extends Controller
{
    public function index()
    {
        $totalSurvei = Survey::count();
        $totalResponden = User::where('role_id', 3)->count();
        $totalUnitKerja = UnitKerja::count();

        return view('dashboard.superadmin-dashboard', compact('totalSurvei', 'totalResponden', 'totalUnitKerja'));
    }
}
