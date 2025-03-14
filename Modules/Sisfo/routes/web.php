
<?php

use Illuminate\Support\Facades\Route;
use Modules\Sisfo\App\Http\Controllers\AuthController;
use Modules\Sisfo\App\Http\Controllers\ProfileController;
use Modules\Sisfo\App\Http\Controllers\DashboardMPUController;
use Modules\Sisfo\App\Http\Controllers\DashboardSARController;
use Modules\Sisfo\App\Http\Controllers\DashboardAdminController;
use Modules\Sisfo\App\Http\Controllers\HakAkses\HakAksesController;
use Modules\Sisfo\App\Http\Controllers\DashboardRespondenController;
use Modules\Sisfo\App\Http\Controllers\DashboardVerifikatorController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\Footer\FooterController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\Footer\KategoriFooterController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\MenuManagement\MenuManagementController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm\PermohonanInformasiController;
use Modules\Sisfo\App\Models\Website\Footer\KategoriFooterModel;

Route::pattern('id', '[0-9]+'); // Artinya: Ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);

// Group route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboardSAR', [DashboardSARController::class, 'index'])->middleware('authorize:SAR');
    Route::get('/dashboardADM', [DashboardAdminController::class, 'index'])->middleware('authorize:ADM');
    Route::get('/dashboardRPN', [DashboardRespondenController::class, 'index'])->middleware('authorize:RPN');
    Route::get('/dashboardMPU', [DashboardMPUController::class, 'index'])->middleware('authorize:MPU');
    Route::get('/dashboardVFR', [DashboardVerifikatorController::class, 'index'])->middleware('authorize:VFR');

    Route::get('/HakAkses', [HakAksesController::class, 'index'])->middleware('authorize:SAR');
    Route::post('/simpanHakAkses', [HakAksesController::class, 'simpan'])->middleware('authorize:SAR');
    Route::get('/getHakAkses/{user_id}/{menu}', [HakAksesController::class, 'getHakAkses'])->middleware('authorize:SAR');

    Route::get('/session', [AuthController::class, 'getData']);

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/update_pengguna/{id}', [ProfileController::class, 'update_pengguna']);
        Route::put('/update_password/{id}', [ProfileController::class, 'update_password']);
    });

    Route::group(['prefix' => 'adminweb/menu-management', 'middleware' => 'authorize:ADM'], function () {
        Route::get('/', [MenuManagementController::class, 'index'])->middleware('permission:view');;
        Route::get('/menu-item', [MenuManagementController::class, 'menu-item']);
        Route::post('/list', [MenuManagementController::class, 'list']);
        Route::post('/store', [MenuManagementController::class, 'store'])->middleware('permission:create');;
        Route::get('/{id}/edit', [MenuManagementController::class, 'edit']);

        Route::put('/{id}/update', [MenuManagementController::class, 'update'])->middleware('permission:update');;
        Route::delete('/{id}/delete', [MenuManagementController::class, 'delete'])->middleware('permission:delete');;
        Route::get('/{id}/detail_menu', [MenuManagementController::class, 'detail_menu']);
        Route::post('/reorder', [MenuManagementController::class, 'reorder']); // New route for drag-drop reordering
    });
    Route::group(['prefix' => 'adminweb/kategori-footer', 'middleware' => 'authorize:ADM'], function () {
        Route::get('/', [KategoriFooterController::class, 'index']);
        Route::post('/list', [KategoriFooterController::class, 'list']); 
        Route::get('/create', [KategoriFooterController::class, 'create']);
        Route::post('/store', [KategoriFooterController::class, 'store']); 
        Route::get('/{id}/edit', [KategoriFooterController::class, 'edit']); 
        Route::put('/{id}/update', [KategoriFooterController::class, 'update']);
        Route::delete('/{id}/delete', [KategoriFooterController::class, 'delete']);
        Route::get('{id}/detail_kategoriFooter', [KategoriFooterController::class, 'detail_kategoriFooter']);
    });
    Route::group(['prefix' => 'adminweb/footer', 'middleware' => 'authorize:ADM'], function () {
        Route::get('/', [FooterController::class, 'index']);
        Route::post('/list', [FooterController::class, 'list']); 
        Route::get('/create', [FooterController::class, 'create']); 
        Route::post('/store', [FooterController::class, 'store']);
        Route::get('/{id}/edit', [FooterController::class, 'edit']);
        Route::put('/{id}/update', [FooterController::class, 'update']); 
        Route::delete('/{id}/delete', [FooterController::class, 'delete']);
        Route::get('/{id}/detail_footer', [FooterController::class, 'detail_footer']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/RPN/PermohonanInformasi', 'middleware' => ['authorize:RPN']], function () {
        Route::get('/', [PermohonanInformasiController::class, 'index']);
        Route::get('/create', [PermohonanInformasiController::class, 'create']);
        Route::post('/store', [PermohonanInformasiController::class, 'store']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/ADM/PermohonanInformasi', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [PermohonanInformasiController::class, 'index']);
        Route::get('/create', [PermohonanInformasiController::class, 'create']);
        Route::post('/store', [PermohonanInformasiController::class, 'store']);
    });
});
