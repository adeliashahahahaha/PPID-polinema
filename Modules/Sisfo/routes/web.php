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
use Modules\Sisfo\App\Http\Controllers\Notifikasi\NotifAdminController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\Footer\FooterController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm\WBSController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\Footer\KategoriFooterController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\KategoriAkses\AksesCepatController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\Timeline\TimelineController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\KategoriAkses\KategoriAksesController;
use Modules\Sisfo\App\Http\Controllers\AdminWeb\MenuManagement\MenuManagementController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm\PengaduanMasyarakatController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm\PermohonanInformasiController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm\PermohonanPerawatanController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm\PernyataanKeberatanController;
use Modules\Sisfo\App\Http\Controllers\SistemInformasi\KetentuanPelaporan\KetentuanPelaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

    Route::get('/getHakAksesData/{param1}/{param2?}', [HakAksesController::class, 'edit'])->middleware('authorize:SAR');
    Route::get('/HakAkses', [HakAksesController::class, 'index'])->middleware('authorize:SAR');
    Route::post('/updateData', [HakAksesController::class, 'update'])->middleware('authorize:SAR');

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
    Route::group(['prefix' => 'adminweb/kategori-footer', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [KategoriFooterController::class, 'index']);
        Route::get('/getData', [KategoriFooterController::class, 'getData']);
        Route::get('/addData', [KategoriFooterController::class, 'addData']);
        Route::post('/createData', [KategoriFooterController::class, 'createData']);
        Route::get('/editData/{id}', [KategoriFooterController::class, 'editData']);
        Route::post('/updateData/{id}', [KategoriFooterController::class, 'updateData']);
        Route::get('/detailData/{id}', [KategoriFooterController::class, 'detailData']);
        Route::get('/deleteData/{id}', [KategoriFooterController::class, 'deleteData']);
        Route::delete('/deleteData/{id}', [KategoriFooterController::class, 'deleteData']);
    });
    Route::group(['prefix' => 'adminweb/footer', 'middleware' => 'authorize:ADM'], function () {
        Route::get('/', [FooterController::class, 'index']);
        Route::get('/getData', [FooterController::class, 'getData']);
        Route::get('/addData', [FooterController::class, 'addData']);
        Route::post('/createData', [FooterController::class, 'createData']);
        Route::get('/editData/{id}', [FooterController::class, 'editData']);
        Route::post('/updateData/{id}', [FooterController::class, 'updateData']);
        Route::get('/detailData/{id}', [FooterController::class, 'detailData']);
        Route::get('/deleteData/{id}', [FooterController::class, 'deleteData']);
        Route::delete('/deleteData/{id}', [FooterController::class, 'deleteData']);
    });
    Route::group(['prefix' => 'adminweb/kategori-akses', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [KategoriAksesController::class, 'index']);
        Route::get('/getData', [KategoriAksesController::class, 'getData']);
        Route::get('/addData', [KategoriAksesController::class, 'addData']);
        Route::post('/createData', [KategoriAksesController::class, 'createData']);
        Route::get('/editData/{id}', [KategoriAksesController::class, 'editData']);
        Route::post('/updateData/{id}', [KategoriAksesController::class, 'updateData']);
        Route::get('/detailData/{id}', [KategoriAksesController::class, 'detailData']);
        Route::get('/deleteData/{id}', [KategoriAksesController::class, 'deleteData']);
        Route::delete('/deleteData/{id}', [KategoriAksesController::class, 'deleteData']);
    });
    Route::group(['prefix' => 'adminweb/akses-cepat', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [AksesCepatController::class, 'index']);
        Route::get('/getData', [AksesCepatController::class, 'getData']);
        Route::get('/addData', [AksesCepatController::class, 'addData']);
        Route::post('/createData', [AksesCepatController::class, 'createData']);
        Route::get('/editData/{id}', [AksesCepatController::class, 'editData']);
        Route::post('/updateData/{id}', [AksesCepatController::class, 'updateData']);
        Route::get('/detailData/{id}', [AksesCepatController::class, 'detailData']);
        Route::get('/deleteData/{id}', [AksesCepatController::class, 'deleteData']);
        Route::delete('/deleteData/{id}', [AksesCepatController::class, 'deleteData']);
    });


    Route::group(['prefix' => 'SistemInformasi/EForm/RPN/PermohonanInformasi', 'middleware' => ['authorize:RPN']], function () {
        Route::get('/', [PermohonanInformasiController::class, 'index']);
        Route::get('/getData', [PermohonanInformasiController::class, 'getData']);
        Route::get('/addData', [PermohonanInformasiController::class, 'addData']);
        Route::post('/createData', [PermohonanInformasiController::class, 'createData']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/ADM/PermohonanInformasi', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [PermohonanInformasiController::class, 'index']);
        Route::get('/getData', [PermohonanInformasiController::class, 'getData']);
        Route::get('/addData', [PermohonanInformasiController::class, 'addData']);
        Route::post('/createData', [PermohonanInformasiController::class, 'createData']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/RPN/PernyataanKeberatan', 'middleware' => ['authorize:RPN']], function () {
        Route::get('/', [PernyataanKeberatanController::class, 'index']);
        Route::get('/getData', [PernyataanKeberatanController::class, 'getData']);
        Route::get('/addData', [PernyataanKeberatanController::class, 'addData']);
        Route::post('/createData', [PernyataanKeberatanController::class, 'createData']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/ADM/PernyataanKeberatan', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [PernyataanKeberatanController::class, 'index']);
        Route::get('/getData', [PernyataanKeberatanController::class, 'getData']);
        Route::get('/addData', [PernyataanKeberatanController::class, 'addData']);
        Route::post('/createData', [PernyataanKeberatanController::class, 'createData']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/RPN/PengaduanMasyarakat', 'middleware' => ['authorize:RPN']], function () {
        Route::get('/', [PengaduanMasyarakatController::class, 'index']);
        Route::get('/getData', [PengaduanMasyarakatController::class, 'getData']);
        Route::get('/addData', [PengaduanMasyarakatController::class, 'addData']);
        Route::post('/createData', [PengaduanMasyarakatController::class, 'createData']);
    });
    
    Route::group(['prefix' => 'SistemInformasi/EForm/ADM/PengaduanMasyarakat', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [PengaduanMasyarakatController::class, 'index']);
        Route::get('/getData', [PengaduanMasyarakatController::class, 'getData']);
        Route::get('/addData', [PengaduanMasyarakatController::class, 'addData']);
        Route::post('/createData', [PengaduanMasyarakatController::class, 'createData']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/RPN/WBS', 'middleware' => ['authorize:RPN']], function () {
        Route::get('/', [WBSController::class, 'index']);
        Route::get('/getData', [WBSController::class, 'getData']);
        Route::get('/addData', [WBSController::class, 'addData']);
        Route::post('/createData', [WBSController::class, 'createData']);
    });
    
    Route::group(['prefix' => 'SistemInformasi/EForm/ADM/WBS', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [WBSController::class, 'index']);
        Route::get('/getData', [WBSController::class, 'getData']);
        Route::get('/addData', [WBSController::class, 'addData']);
        Route::post('/createData', [WBSController::class, 'createData']);
    });

    Route::group(['prefix' => 'SistemInformasi/EForm/RPN/PermohonanPerawatan', 'middleware' => ['authorize:RPN']], function () {
        Route::get('/', [PermohonanPerawatanController::class, 'index']);
        Route::get('/getData', [PermohonanPerawatanController::class, 'getData']);
        Route::get('/addData', [PermohonanPerawatanController::class, 'addData']);
        Route::post('/createData', [PermohonanPerawatanController::class, 'createData']);
    });
    
    Route::group(['prefix' => 'SistemInformasi/EForm/ADM/PermohonanPerawatan', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [PermohonanPerawatanController::class, 'index']);
        Route::get('/getData', [PermohonanPerawatanController::class, 'getData']);
        Route::get('/addData', [PermohonanPerawatanController::class, 'addData']);
        Route::post('/createData', [PermohonanPerawatanController::class, 'createData']);
    });

    Route::group(['prefix' => 'Notifikasi/NotifAdmin', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [NotifAdminController::class, 'index']);
        Route::get('/notifPI', [NotifAdminController::class, 'notifikasiPermohonan']);
        Route::post('/tandai-dibaca/{id}', [NotifAdminController::class, 'tandaiDibaca'])->name('NotifAdmin.tandaiDibaca');
        Route::delete('/hapus/{id}', [NotifAdminController::class, 'hapusNotifikasi'])->name('NotifAdmin.hapus');
        Route::post('/tandai-semua-dibaca', [NotifAdminController::class, 'tandaiSemuaDibaca']);
        Route::delete('/hapus-semua-dibaca', [NotifAdminController::class, 'hapusSemuaDibaca']);
    });

    Route::group(['prefix' => 'SistemInformasi/Timeline', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [TimelineController::class, 'index']);
        Route::get('/getData', [TimelineController::class, 'getData']);
        Route::get('/addData', [TimelineController::class, 'addData']);
        Route::post('/createData', [TimelineController::class, 'createData']);
        Route::get('/editData/{id}', [TimelineController::class, 'editData']);
        Route::post('/updateData/{id}', [TimelineController::class, 'updateData']);
        Route::get('/detailData/{id}', [TimelineController::class, 'detailData']);
        Route::get('/deleteData/{id}', [TimelineController::class, 'deleteData']);
        Route::delete('/deleteData/{id}', [TimelineController::class, 'deleteData']);
    });

    Route::group(['prefix' => 'SistemInformasi/KetentuanPelaporan', 'middleware' => ['authorize:ADM']], function () {
        Route::get('/', [KetentuanPelaporanController::class, 'index']);
        Route::get('/getData', [KetentuanPelaporanController::class, 'getData']);
        Route::get('/addData', [KetentuanPelaporanController::class, 'addData']);
        Route::post('/createData', [KetentuanPelaporanController::class, 'createData']);
        Route::get('/editData/{id}', action: [KetentuanPelaporanController::class, 'editData']);
        Route::post('/updateData/{id}', [KetentuanPelaporanController::class, 'updateData']);
        Route::get('/detailData/{id}', [KetentuanPelaporanController::class, 'detailData']);
        Route::get('/deleteData/{id}', [KetentuanPelaporanController::class, 'deleteData']);
        Route::delete('/deleteData/{id}', [KetentuanPelaporanController::class, 'deleteData']);
        Route::post('/uploadImage', [KetentuanPelaporanController::class, 'uploadImage']);
        Route::post('/removeImage', [KetentuanPelaporanController::class, 'removeImage']);
    });
});