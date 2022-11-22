<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SidebarModel extends Model
{
    use HasFactory;

    public function getMenu()
    {
        $id = Auth::user()->id;
        // $RouteName = Route::current()->uri();
        $RouteName = Request::segment(1);

        // cek menu & submenu apa saja yang dapat diakses oleh role yang login
        $stmtUsers = DB::table('users as a')
            ->join('tbl_master_role as b', 'a.id_role', '=', 'b.id')
            ->select('a.id_role', 'b.id_menu', 'b.id_submenu')
            ->where('a.id', $id)
            ->get();
        foreach ($stmtUsers as $dataUsers) {
            $idRole = $dataUsers->id_role;
            $idMenu = $dataUsers->id_menu;
            $idSubMenu = $dataUsers->id_submenu;
        }

        $stmtMenu = Menu::whereIn('id', explode(',', $idMenu))
            ->where('status_data', '1')
            ->orderBy('urutan')
            ->get();

        $stmtSubMenu = SubMenu::whereIn('id', explode(',', $idSubMenu))
            ->where('status_data', '1')
            ->orderBy('urutan')
            ->get();

        $stmtMenuId = DB::select("select id from tbl_master_menu where link like '%" . $RouteName . "' ");
        $stmtSubMenuId = DB::select("select id, id_menu from tbl_master_submenu where link like '%" . $RouteName . "' ");

        foreach ($stmtMenuId as $dataMenuId) {
            $regIdMenu = $dataMenuId->id;
            $stmtRoleMenu = DB::select("select count(id) as jum_menu from tbl_master_role where id = " . $idRole . " and id_menu ~ '[[:<:]]" . $regIdMenu . "[[:>:]]' ");
        }

        foreach ($stmtSubMenuId as $dataSubMenuId) {
            $regIdSubMenu = $dataSubMenuId->id;
            $stmtRoleSubMenu = DB::select("select count(id) as jum_submenu from tbl_master_role where id = " . $idRole . " and id_submenu ~ '[[:<:]]" . $regIdSubMenu . "[[:>:]]' ");
        }

        (isset($stmtRoleMenu[0]->jum_menu) && $stmtRoleMenu[0]->jum_menu > 0) ? $aksesMenu = 1 : $aksesMenu = 0;
        (isset($stmtRoleSubMenu[0]->jum_submenu) && $stmtRoleSubMenu[0]->jum_submenu > 0) ? $aksesSubMenu = 1 : $aksesSubMenu = 0;

        return [
            'stmtMenu' => $stmtMenu,
            'stmtSubMenu' => $stmtSubMenu,
            'stmtMenuId' => $stmtMenuId,
            'stmtSubMenuId' => $stmtSubMenuId,
            'aksesMenu' => $aksesMenu,
            'aksesSubMenu' => $aksesSubMenu
        ];
    }
}
