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
use App\Http\Controllers\PublicSurveyController;
use App\Http\Controllers\SurveyResponseController; 
use App\Http\Controllers\SurveyResultController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute utama (Landing Page)
Route::get('/', [PublicSurveyController::class, 'index'])->name('home');

// Rute Otentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/auth/google/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');

// <-- DITAMBAHKAN: Rute untuk Responden Mengisi Survei -->
Route::middleware(['auth'])->group(function () {
    // Rute untuk menampilkan halaman form pengisian survei
    Route::get('/surveys/{survey}/fill', [SurveyResponseController::class, 'showFillForm'])->name('surveys.fill');
    // Rute untuk menyimpan jawaban dari form
    Route::post('/surveys/{survey}/fill', [SurveyResponseController::class, 'storeResponse'])->name('surveys.storeResponse');
    Route::get('/surveys/thank-you', [SurveyResponseController::class, 'thankYou'])->name('surveys.thankyou');

    // Rute manajemen pertanyaan (tetap di sini agar aman)
    Route::resource('surveys.questions', QuestionController::class)->except(['index', 'show']);
    Route::post('surveys/{survey}/questions/reorder', QuestionOrderController::class)->name('surveys.questions.reorder');
});


// Rute untuk Superadmin
Route::middleware(['auth', 'is.superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('surveys', SurveyController::class);
    Route::resource('users', UserController::class);
    Route::get('templates', [SurveyTemplateController::class, 'index'])->name('templates.index');
    Route::post('templates/store', [SurveyTemplateController::class, 'store'])->name('templates.store');
    Route::get('surveys/templates/create-from/{template}', [SurveyTemplateController::class, 'createFromTemplate'])->name('surveys.create_from_template');
    Route::delete('surveys/templates/{template}', [SurveyTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::get('/surveys/{survey}/results', [SurveyResultController::class, 'show'])->name('surveys.results');
});

// Grup Rute untuk Admin Unit Kerja
Route::middleware(['auth', 'is.unitkerja.admin'])->prefix('unit-kerja-admin')->name('unitkerja.admin.')->group(function () {
    Route::get('/dashboard', [UnitKerjaAdminController::class, 'index'])->name('dashboard');
    Route::resource('surveys', UnitKerjaSurveyController::class);
});
