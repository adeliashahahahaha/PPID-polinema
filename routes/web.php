<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\EFormController;
use App\Http\Controllers\TimelineController;

// Route::get('/', function () {
//     return "Ini adalah halaman User Module!";
// })->name('user.home');

// Route::get('/sisfo', function () {
//     return "Ini halaman dashboard Admin!";
// });

// Route::get('/', function () {
//     return view('tryit');
// });
// Route::get('/', [HomeController::class, 'index'])-> name('beranda');

// Route::get('/landing_page', [HomeController::class, 'index']);

// Route::get('/Lsidebar', function () {
//     return view('layouts.left_sidebar');
// });
// Route::get('/Rsidebar', function () {
//     return view('user.layouts.right_sidebar');
// });


// Route::get('/landing_page', [HomeController::class, 'index']);


// Route::get('/footer', [FooterController::class, 'index']);

// Route::get('/e-form_informasi', function () {
//     return view('user.e-form_informasi');
// })->name('e-form');

// Route::get('/e-form_keberatan', function () {
//     return view('user.e-form_keberatan');
// });

// Route::get('/e-form_wbs', function () {
//     return view('user.e-form_wbs');
// });

// Route::get('/login', function () {
//     return view('user.login');
// }) ->name('login');

// Route::get('/register', function () {
//     return view('user.register');
// }) ->name('register');


// Route::get('/navbar', function () {
//     return view('navbaar');
// });

// Route::get('/eform', function () {
//     return view('user.timeline');
// })->name('eform');


// Route::prefix('informasi-publik')->group(function () {
//     Route::get('/setiap-saat', [InformasiPublikController::class, 'setiapSaat'])->name('informasi-publik.setiap-saat');
//     Route::get('/berkala', [InformasiPublikController::class, 'berkala'])->name('informasi-publik.berkala');
//     Route::get('/serta-merta', [InformasiPublikController::class, 'sertaMerta'])->name('informasi-publik.serta-merta');
// });

// Route::get('/permohonan/lacak', [PermohonanController::class, 'lacak'])->name('permohonan.lacak');

// Route::get('/eform', [TimelineController::class, 'index'])->name('eform');
