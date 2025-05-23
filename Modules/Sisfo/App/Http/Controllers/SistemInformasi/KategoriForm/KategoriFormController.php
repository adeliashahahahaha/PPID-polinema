<?php

namespace Modules\Sisfo\App\Http\Controllers\SistemInformasi\KategoriForm;

use Modules\Sisfo\App\Http\Controllers\TraitsController;
use Modules\Sisfo\App\Models\SistemInformasi\KategoriForm\KategoriFormModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class KategoriFormController extends Controller
{
    use TraitsController;

    public $breadcrumb = 'Pengaturan Kategori Form';
    public $pagename = 'SistemInformasi/KategoriForm';

    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $breadcrumb = (object) [
            'title' => 'Pengaturan Kategori Form',
            'list' => ['Home', 'Pengaturan Kategori Form']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori Form'
        ];

        $activeMenu = 'KategoriForm';
        
        // Gunakan pagination dan pencarian
        $kategoriForm = KategoriFormModel::selectData(10, $search);

        return view("sisfo::SistemInformasi/KategoriForm.index", [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategoriForm' => $kategoriForm,
            'search' => $search
        ]);
    }

    // Update getData untuk mendukung pagination dan pencarian
    public function getData(Request $request)
    {
        $search = $request->query('search', '');
        $kategoriForm = KategoriFormModel::selectData(10, $search);
        
        if ($request->ajax()) {
            return view('sisfo::SistemInformasi/KategoriForm.data', compact('kategoriForm', 'search'))->render();
        }
        
        return redirect()->route('kategori-form.index');
    }

    public function addData()
    {
        return view("sisfo::SistemInformasi/KategoriForm.create");
    }

    public function createData(Request $request)
    {
        try {
            KategoriFormModel::validasiData($request);
            $result = KategoriFormModel::createData($request);

            return $this->jsonSuccess(
                $result['data'] ?? null, 
                $result['message'] ?? 'Kategori form berhasil dibuat'
            );
        } catch (ValidationException $e) {
            return $this->jsonValidationError($e);
        } catch (\Exception $e) {
            return $this->jsonError($e, 'Terjadi kesalahan saat membuat kategori form');
        }
    }

    public function editData($id)
    {
        $kategoriForm = KategoriFormModel::detailData($id);

        return view("sisfo::SistemInformasi/KategoriForm.update", [
            'kategoriForm' => $kategoriForm
        ]);
    }

    public function updateData(Request $request, $id)
    {
        try {
            KategoriFormModel::validasiData($request);
            $result = KategoriFormModel::updateData($request, $id);

            return $this->jsonSuccess(
                $result['data'] ?? null, 
                $result['message'] ?? 'Kategori form berhasil diperbarui'
            );
        } catch (ValidationException $e) {
            return $this->jsonValidationError($e);
        } catch (\Exception $e) {
            return $this->jsonError($e, 'Terjadi kesalahan saat memperbarui kategori form');
        }
    }

    public function detailData($id)
    {
        $kategoriForm = KategoriFormModel::detailData($id);
        
        return view("sisfo::SistemInformasi/KategoriForm.detail", [
            'kategoriForm' => $kategoriForm,
            'title' => 'Detail Kategori Form'
        ]);
    }

    public function deleteData(Request $request, $id)
    {
        if ($request->isMethod('get')) {
            $kategoriForm = KategoriFormModel::detailData($id);
            
            return view("sisfo::SistemInformasi/KategoriForm.delete", [
                'kategoriForm' => $kategoriForm
            ]);
        }
        
        try {
            $result = KategoriFormModel::deleteData($id);
            
            return $this->jsonSuccess(
                $result['data'] ?? null, 
                $result['message'] ?? 'Kategori form berhasil dihapus'
            );
        } catch (\Exception $e) {
            return $this->jsonError($e, 'Terjadi kesalahan saat menghapus kategori form');
        }
    }
}