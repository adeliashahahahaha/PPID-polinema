<?php

namespace Modules\Sisfo\App\Http\Controllers\HakAkses;

use Modules\Sisfo\App\Http\Controllers\TraitsController;
use Modules\Sisfo\App\Models\HakAkses\SetHakAksesModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class SetHakAksesController extends Controller
{
    use TraitsController;

    public $breadcrumb = 'Pengaturan Hak Akses';
    public $pagename = 'HakAkses';

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pengaturan Hak Akses',
            'list' => ['Home', 'Hak Akses']
        ];

        $page = (object) [
            'title' => 'Pengaturan Hak Akses'
        ];

        $activeMenu = 'pengaturanhakakses';

        // Mengambil data dari model
        $result = SetHakAksesModel::selectData();
        $levelUsers = $result['data'];

        return view("sisfo::HakAkses.index", [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'levelUsers' => $levelUsers
        ]);
    }

    public function getData() {
        //
    }

    public function addData() {
        //
    }

    public function createData() {
        //
    }

    public function editData($param1, $param2 = null)
    {
        // Jika param2 tidak ada, maka ini adalah permintaan hak akses berdasarkan level
        if ($param2 === null) {
            $hak_akses_kode = $param1;
            $menuData = SetHakAksesModel::getHakAksesData($hak_akses_kode);
            return response()->json($menuData);
        }
        // Jika param2 ada, maka ini adalah permintaan hak akses spesifik user dan menu
        else {
            $pengakses_id = $param1;
            $menu_id = $param2;
            $hakAkses = SetHakAksesModel::getHakAksesData($pengakses_id, $menu_id);
            return response()->json($hakAkses);
        }
    }

    public function updateData(Request $request)
    {
        try {
            // Menentukan apakah permintaan berasal dari form level atau individual
            $isLevel = $request->has('hak_akses_kode');
            
            // Proses data dengan model
            $result = SetHakAksesModel::updateData($request->all(), $isLevel);

            // Jika request adalah ajax (untuk level) atau jika request memiliki parameter untuk level
            if ($request->ajax() || $isLevel) {
                return response()->json([
                    'success' => $result['success'], 
                    'message' => $result['message']
                ]);
            } 
            // Jika permintaan untuk individual (form biasa)
            else {
                if ($result['success']) {
                    return redirect()->back()->with('success', $result['message']);
                } else {
                    return redirect()->back()->with('error', $result['message']);
                }
            }
        } catch (\Exception $e) {   
            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            // Jika ajax request, kembalikan response json
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMessage]);
            }
            // Jika bukan ajax request, redirect dengan error message
            else {
                return redirect()->back()->with('error', $errorMessage);
            }
        }
    }
}