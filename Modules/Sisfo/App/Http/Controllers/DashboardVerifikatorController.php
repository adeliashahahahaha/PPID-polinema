<?php

namespace Modules\Sisfo\App\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardVerifikatorController extends Controller
{
    use TraitsController;
    
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang Pengguna',
            'list' => ['Home', 'welcome']
        ];

        $activeMenu = 'dashboard';

        return view('Sisfo::dashboardVFR', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
