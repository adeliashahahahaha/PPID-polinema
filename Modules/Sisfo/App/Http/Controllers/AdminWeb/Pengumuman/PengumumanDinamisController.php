<?php

namespace Modules\Sisfo\App\Http\Controllers\AdminWeb\Pengumuman;

use Modules\Sisfo\App\Http\Controllers\TraitsController;
use Modules\Sisfo\App\Models\Website\Publikasi\Pengumuman\PengumumanDinamisModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PengumumanDinamisController extends Controller
{
    use TraitsController;

    public $breadcrumb = 'Pengaturan Pengumuman Dinamis';
    public $pagename = 'AdminWeb/PengumumanDinamis';

    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $breadcrumb = (object) [
            'title' => 'Pengaturan Pengumuman Dinamis',
            'list' => ['Home', 'Website', 'Pengumuman Dinamis']
        ];

        $page = (object) [
            'title' => 'Daftar Pengumuman Dinamis'
        ];

        $activeMenu = 'kategoriPengumuman';

        // Gunakan pagination dan pencarian
        $kategoriPengumuman = PengumumanDinamisModel::selectData(10, $search);

        return view("sisfo::AdminWeb/PengumumanDinamis.index", [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategoriPengumuman' => $kategoriPengumuman,
            'search' => $search
        ]);
    }

    // Update getData untuk mendukung pagination dan pencarian
    public function getData(Request $request)
    {
        $search = $request->query('search', '');
        $kategoriPengumuman = PengumumanDinamisModel::selectData(10, $search);

        if ($request->ajax()) {
            return view('sisfo::AdminWeb.PengumumanDinamis.data', compact('kategoriPengumuman', 'search'))->render();
        }

        return redirect()->route('pengumuman-dinamis.index');
    }

    public function addData()
    {
        try {
            return view("sisfo::AdminWeb.PengumumanDinamis.create");
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in addData: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memuat form tambah data'], 500);
        }
    }

    public function createData(Request $request)
    {
        try {
            PengumumanDinamisModel::validasiData($request);
            $result = PengumumanDinamisModel::createData($request);

            return $this->jsonSuccess(
                $result['data'] ?? null,
                $result['message'] ?? 'Pengumuman dinamis berhasil dibuat'
            );
        } catch (ValidationException $e) {
            return $this->jsonValidationError($e);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in createData: ' . $e->getMessage());
            return $this->jsonError($e, 'Terjadi kesalahan saat membuat pengumuman dinamis');
        }
    }

    public function editData($id)
    {
        try {
            $kategoriPengumuman = PengumumanDinamisModel::detailData($id);

            return view("sisfo::AdminWeb.PengumumanDinamis.update", [
                'kategoriPengumuman' => $kategoriPengumuman
            ]);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in editData: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memuat form edit data'], 500);
        }
    }

    public function updateData(Request $request, $id)
    {
        try {
            PengumumanDinamisModel::validasiData($request);
            $result = PengumumanDinamisModel::updateData($request, $id);

            return $this->jsonSuccess(
                $result['data'] ?? null,
                $result['message'] ?? 'Pengumuman dinamis berhasil diperbarui'
            );
        } catch (ValidationException $e) {
            return $this->jsonValidationError($e);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in updateData: ' . $e->getMessage());
            return $this->jsonError($e, 'Terjadi kesalahan saat memperbarui pengumuman dinamis');
        }
    }

    public function detailData($id)
    {
        try {
            $kategoriPengumuman = PengumumanDinamisModel::detailData($id);

            return view("sisfo::AdminWeb.PengumumanDinamis.detail", [
                'kategoriPengumuman' => $kategoriPengumuman,
                'title' => 'Detail Pengumuman Dinamis'
            ]);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in detailData: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memuat detail data'], 500);
        }
    }

    public function deleteData(Request $request, $id)
    {
        try {
            if ($request->isMethod('get')) {
                $kategoriPengumuman = PengumumanDinamisModel::detailData($id);

                return view("sisfo::AdminWeb.PengumumanDinamis.delete", [
                    'kategoriPengumuman' => $kategoriPengumuman
                ]);
            }

            $result = PengumumanDinamisModel::deleteData($id);

            return $this->jsonSuccess(
                $result['data'] ?? null,
                $result['message'] ?? 'Pengumuman dinamis berhasil dihapus'
            );
        } catch (\Exception $e) {
            // Log error
            Log::error('Error in deleteData: ' . $e->getMessage());
            return $this->jsonError($e, 'Terjadi kesalahan saat menghapus pengumuman dinamis');
        }
    }
}
