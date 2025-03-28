<?php

namespace Modules\Sisfo\App\Http\Controllers\Api\Auth;

use Modules\Sisfo\App\Http\Controllers\Api\BaseApiController;
use Modules\Sisfo\App\Models\Website\WebMenuModel;

class AuthMenuController extends BaseApiController
{
    
    public function getAuthMenus()
    {
        return $this->eksekusiDenganOtentikasi(
            function() {
                $menus = WebMenuModel::selectData();
                return $this->buildMenuTree($menus);
            },
            'menu' // hanya penanda data yang akan diambil
        );
    }
    private function buildMenuTree(array $menus, $parentId = null): array
    {
        $tree = [];

        foreach ($menus as $menu) {
            if ($menu['wm_parent_id'] == $parentId) {
                // Rekursi untuk mencari anak dari menu saat ini
                $children = $this->buildMenuTree($menus, $menu['id']);
                if (!empty($children)) {
                    $menu['children'] = $children;
                }
                $tree[] = $menu;
            }
        }

        return $tree;
    }
}