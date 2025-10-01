<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\SuperadminDashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SurveyTemplateController;
use App\Http\Controllers\QuestionOrderController;
use App\Http\Controllers\UnitKerjaAdminController;
use App\Http\Controllers\UnitKerjaSurveyController;
use Illuminate\Support\Facades\Gate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk Halaman Beranda & Otentikasi
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk Superadmin
Route::middleware(['auth', 'is.superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');
    
    // DIKEMBALIKAN: Rute resource untuk survei diaktifkan kembali
    Route::resource('surveys', SurveyController::class);
    // Rute untuk pertanyaan berada di bawahnya
    Route::resource('surveys.questions', QuestionController::class)->except(['index', 'show']);

    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('users', UserController::class);
    Route::get('templates', [SurveyTemplateController::class, 'index'])->name('templates.index');
    Route::post('templates/store', [SurveyTemplateController::class, 'store'])->name('templates.store');
    Route::get('surveys/templates/create-from/{template}', [SurveyTemplateController::class, 'createFromTemplate'])->name('surveys.create_from_template');
    Route::delete('surveys/templates/{template}', [SurveyTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::post('surveys/{survey}/questions/reorder', QuestionOrderController::class)->name('surveys.questions.reorder');
});

// Grup Rute untuk Admin Unit Kerja
Route::middleware(['auth', 'is.unitkerja.admin'])->prefix('unit-kerja-admin')->name('unitkerja.admin.')->group(function () {
    Route::get('/dashboard', [UnitKerjaAdminController::class, 'index'])->name('dashboard');
    Route::resource('surveys', UnitKerjaSurveyController::class);
});

// Rute untuk Responden
Route::middleware(['auth'])->group(function () {
    Route::get('/responden/dashboard', function () {
        return view('dashboard.responden-dashboard');
    })->name('responden.dashboard');
});