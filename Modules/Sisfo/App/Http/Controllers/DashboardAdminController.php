<?php

namespace Modules\Sisfo\App\Http\Controllers;

use Illuminate\Routing\Controller;


class DashboardAdminController extends Controller
{
    use TraitsController;

    public function index() {
        $breadcrumb = (object) [
            'title' => 'Pintasan Menu',
            'list' => ['Home', 'welcome']
        ];

        $activeMenu = 'dashboard';

        return view('sisfo::dashboardADM', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);

    }
}
