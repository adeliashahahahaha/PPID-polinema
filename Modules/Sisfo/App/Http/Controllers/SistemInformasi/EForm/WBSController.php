<?php

namespace Modules\Sisfo\App\Http\Controllers\SistemInformasi\EForm;

use Modules\Sisfo\App\Http\Controllers\TraitsController;
use Modules\Sisfo\App\Models\SistemInformasi\EForm\WBSModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WBSController extends Controller
{
    use TraitsController;

    public $breadcrumb = 'Whistle Blowing System';
    public $pagename = 'SistemInformasi/EForm/WBS';

    public function index()
    {
        $folder = $this->getUserFolder();

        $breadcrumb = (object) [
            'title' => 'Whistle Blowing System',
            'list' => ['Home', 'Whistle Blowing System']
        ];

        $page = (object) [
            'title' => 'Whistle Blowing System'
        ];

        $activeMenu = 'WBS';

        return view("sisfo::SistemInformasi/EForm/$folder/WBS.index", [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function getData()
    {
        $timeline = WBSModel::getTimeline();
        $ketentuanPelaporan = WBSModel::getKetentuanPelaporan();

        return [
            'timeline' => $timeline,
            'ketentuanPelaporan' => $ketentuanPelaporan
        ];
    }

    public function addData()
    {
        $folder = $this->getUserFolder();

        $breadcrumb = (object) [
            'title' => 'Whistle Blowing System',
            'list' => ['Home', 'Whistle Blowing System', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Pengajuan Whistle Blowing System'
        ];

        $activeMenu = 'WBS';

        return view("sisfo::SistemInformasi/EForm/$folder/WBS.pengisianForm", [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }

    public function createData(Request $request)
    {
        try {
            $folder = $this->getUserFolder();
            WBSModel::validasiData($request);
            $result = WBSModel::createData($request);

            if ($result['success']) {
                return $this->redirectSuccess("/SistemInformasi/EForm/$folder/WBS", $result['message']);
            }

            return $this->redirectError($result['message']);
        } catch (ValidationException $e) {
            return $this->redirectValidationError($e);
        } catch (\Exception $e) {
            return $this->redirectException($e, 'Terjadi kesalahan saat mengajukan Whistle Blowing System');
        }
    }

    private function getUserFolder()
    {
        $levelKode = Auth::user()->level->level_kode;
        return ($levelKode === 'ADM' || $levelKode === 'RPN') ? $levelKode : abort(403);
    }
}
