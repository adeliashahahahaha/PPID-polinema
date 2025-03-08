<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\PermohonanController;
use Modules\User\App\Http\Controllers\HomeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\EFormController;
use Modules\User\App\Http\Controllers\TimelineController;
use Modules\User\App\Http\Controllers\Form\InformasiController;
use Modules\User\App\Http\Controllers\Form\KeberatanController;
use Modules\User\App\Http\Controllers\Form\WBSController;
use Modules\User\App\Http\Controllers\Form\PengaduanMasyarakatController;


use Modules\User\App\Http\Controllers\UserController;


Route::get('/', [HomeController::class, 'index'])-> name('beranda');

Route::get('/landing_page', [HomeController::class, 'index']);


Route::get('/footer', [FooterController::class, 'index']);


// Form Controller ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Route::prefix('form-permohonan-informasi')->group(function () {
    Route::get('/', [InformasiController::class, 'index'])->name('form-informasi-publik');
});
Route::prefix('form-pernyataan-keberatan')->group(function () {
    Route::get('/', [KeberatanController::class, 'index'])->name('form-keberatan');
});
Route::prefix('form-whistle-blowing')->group(function () {
    Route::get('/', [WBSController::class, 'index'])->name('form-wbs');
});
Route::prefix('form-pengaduan-masyarakat')->group(function () {
    Route::get('/', [PengaduanMasyarakatController::class, 'index'])->name('form-aduanmasyarakat');
});
// ---- form dinamis untuk self made new form -----


// Timeline Controller ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Route::get('/permohonan-informasi', [TimelineController::class, 'permohonan_informasi'])-> name('permohonan_informasi');
Route::get('/pernyataan-keberatan', [TimelineController::class, 'pernyataan_keberatan'])-> name('pernyataan_keberatan');
Route::get('/whistle-blowing-system', [TimelineController::class, 'wbs'])-> name('wbs');
Route::get('/pengaduan-masyarakat', [TimelineController::class, 'pengaduan_masyarakat'])-> name('pengaduan_masyarakat');

// SOP Controller
// ~~~ soon ~~~

// Page Dinamis with
Route::get('/dashboard', function () {
    return view('user::dashboard');})->name('dashboard');
Route::get('/content-dinamis', function () {
    return view('user::content');})->name('content');


Route::get('/e-form_keberatan', function () {
    return view('user::e-form_keberatan');
});

Route::get('/e-form_wbs', function () {
    return view('user::e-form_wbs');
});

Route::get('/login-ppid', function () {
    return view('user::login');
}) ->name('login');

Route::get('/register', function () {
    return view('user::register');
}) ->name('register');


Route::prefix('informasi-publik')->group(function () {
    Route::get('/setiap-saat', [InformasiPublikController::class, 'setiapSaat'])->name('informasi-publik.setiap-saat');
    Route::get('/berkala', [InformasiPublikController::class, 'berkala'])->name('informasi-publik.berkala');
    Route::get('/serta-merta', [InformasiPublikController::class, 'sertaMerta'])->name('informasi-publik.serta-merta');
});

Route::get('/permohonan/lacak', [PermohonanController::class, 'lacak'])->name('permohonan.lacak');
