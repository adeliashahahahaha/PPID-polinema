<?php

namespace Modules\Sisfo\App\Http\Controllers\AdminWeb\MenuManagement;

use Modules\Sisfo\App\Http\Controllers\TraitsController;
use Modules\Sisfo\App\Models\Website\WebMenuModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MenuManagementController extends Controller
{
    use TraitsController;

    public $breadcrumb = 'Menu Management';
    public $pagename = 'AdminWeb/MenuManagement';
    public function index()
    {
        try {
            $breadcrumb = (object)[
                'title' => 'Menu Management',
                'list' => ['Home', 'Menu Management'],
            ];

            $page = (object)[
                'title' => 'Menu Management System'
            ];

            $activeMenu = 'menumanagement';
            $menus = WebMenuModel::getMenusWithChildren();

            return view('sisfo::adminweb.MenuManagement.index', compact('breadcrumb', 'page', 'menus', 'activeMenu'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading menu management page');
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $result = WebMenuModel::createData($request);
            return response()->json($result);
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $result = WebMenuModel::getEditData($id);
            return response()->json($result);
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $result = WebMenuModel::updateData($request, $id);
            return response()->json($result);
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        if (request()->ajax()) {
            $result = WebMenuModel::deleteData($id);
            return response()->json($result);
        }
        return redirect()->back();
    }

    public function detail_menu($id)
    {
        if (request()->ajax()) {
            $result = WebMenuModel::getDetailData($id);
            return response()->json($result);
        }
        return redirect()->back();
    }

    public function reorder(Request $request)
    {
        if ($request->ajax()) {
            $result = WebMenuModel::reorderMenus($request->get('data'));
            return response()->json($result);
        }
        return redirect()->back();
    }
}