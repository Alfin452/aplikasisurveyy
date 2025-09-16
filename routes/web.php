<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\SuperadminDashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SurveyTemplateController;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk Halaman Beranda
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute untuk Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk Superadmin
Route::middleware(['auth', 'is.superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('surveys', SurveyController::class);
    Route::resource('surveys.questions', QuestionController::class);
    Route::resource('users', UserController::class);
    Route::get('templates', [SurveyTemplateController::class, 'index'])->name('templates.index');
    Route::post('templates/store', [SurveyTemplateController::class, 'store'])->name('templates.store');
    Route::get('surveys/templates/create-from/{survey}', [SurveyTemplateController::class, 'createFromTemplate'])->name('surveys.create_from_template');
    Route::delete('surveys/templates/{survey}', [SurveyTemplateController::class, 'destroy'])->name('templates.destroy');
});

// Rute untuk Admin Unit Kerja 
Route::middleware(['auth', 'is.unitkerja'])->group(function () {
    Route::get('/unitkerja/dashboard', function () {
        return view('dashboard.unitkerja-dashboard');
    })->name('unitkerja.dashboard');
    // Anda bisa tambahkan rute CRUD survei khusus untuk admin unit di sini jika diperlukan
});

// Rute untuk Responden (hanya butuh otentikasi)
Route::middleware(['auth'])->group(function () {
    Route::get('/responden/dashboard', function () {
        return view('dashboard.responden-dashboard');
    })->name('responden.dashboard');
});
