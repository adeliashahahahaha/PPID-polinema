
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\PermohonanController;
use Modules\User\App\Http\Controllers\HomeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\EFormController;
use Modules\User\App\Http\Controllers\TimelineController;

use Modules\User\App\Http\Controllers\UserController;


Route::get('/', [HomeController::class, 'index'])-> name('beranda');

Route::get('/eform', [TimelineController::class, 'index'])-> name('eform');

Route::get('/Lsidebar', function () {
    return view('user::layouts.left_sidebar');
});
Route::get('/Rsidebar', function () {
    return view('user::layouts.right_sidebar');
});

Route::get('/landing_page', [HomeController::class, 'index']);


Route::get('/footer', [FooterController::class, 'index']);

Route::prefix('e-form')->group(function () {
    Route::get('/informasi-publik', function () {
        return view('user::e-form.informasi-publik');})->name('e-form.informasi-publik');
    Route::get('/keberatan', function () {
        return view('user::e-form.keberatan');})->name('e-form.keberatan');

    Route::get('/wbs', function () {
        return view('user::e-form.wbs');})->name('e-form.wbs');
});


Route::get('/e-form_informasi', function () {
    return view('user::e-form_informasi');
})->name('e-form');

Route::get('/e-form_keberatan', function () {
    return view('user::e-form_keberatan');
});

Route::get('/e-form_wbs', function () {
    return view('user::e-form_wbs');
});

Route::get('/login-ppid', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login']);

// Route untuk dashboard berdasarkan level
Route::get('/dashboardSAR', function () {
    $activeMenu = 'dashboard'; // Sesuaikan dengan kebutuhan Anda
    $breadcrumb = (object) [
        'title' => 'Selamat Datang Super Administrator',
        'list' => ['Home', 'welcome']
    ];
    return view('sisfo::dashboardSAR', compact('activeMenu', 'breadcrumb'));
})->name('dashboard.sar');

Route::get('/dashboardADM', function () {
    $activeMenu = 'dashboard';
    $breadcrumb = (object) [
        'title' => 'Selamat Datang Administrator',
        'list' => ['Home', 'welcome']
    ];
    return view('sisfo::dashboardADM', compact('activeMenu', 'breadcrumb'));
})->name('dashboard.adm');

Route::get('/dashboardMPU', function () {
    $activeMenu = 'dashboard';
    $breadcrumb = (object) [
        'title' => 'Selamat Datang Super Manajemen dan Pimpinan Unit',
        'list' => ['Home', 'welcome']
    ];
    return view('sisfo::dashboardMPU', compact('activeMenu', 'breadcrumb'));
})->name('dashboard.mpu');

Route::get('/dashboardVFR', function () {
    $activeMenu = 'dashboard';
    $breadcrumb = (object) [
        'title' => 'Selamat Datang Super Verifikator',
        'list' => ['Home', 'welcome']
    ];
    return view('sisfo::dashboardVFR', compact('activeMenu', 'breadcrumb'));
})->name('dashboard.vfr');

Route::get('/dashboardRPN', function () {
    $activeMenu = 'dashboard';
    $breadcrumb = (object) [
        'title' => 'Selamat Datang Super Responden',
        'list' => ['Home', 'welcome']
    ];
    return view('sisfo::dashboardRPN', compact('activeMenu', 'breadcrumb'));
})->name('dashboard.rpn');

Route::get('/register', function () {
    return view('user::register');
}) ->name('register');


Route::prefix('informasi-publik')->group(function () {
    Route::get('/setiap-saat', [InformasiPublikController::class, 'setiapSaat'])->name('informasi-publik.setiap-saat');
    Route::get('/berkala', [InformasiPublikController::class, 'berkala'])->name('informasi-publik.berkala');
    Route::get('/serta-merta', [InformasiPublikController::class, 'sertaMerta'])->name('informasi-publik.serta-merta');
});

Route::get('/permohonan/lacak', [PermohonanController::class, 'lacak'])->name('permohonan.lacak');
