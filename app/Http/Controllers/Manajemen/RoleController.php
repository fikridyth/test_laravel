<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Menu;
use App\Models\Role;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    private static $title = 'Role';

    public static function breadcrumb()
    {
        return [
            self::$title, route('manajemen-role.index')
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb()
        ];

        $stmtRole = Role::orderBy('id')->get();

        return view('manajemen.role.index', compact('title', 'breadcrumbs', 'stmtRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create ' . self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('manajemen-role.create')],
        ];

        $stmtMenu = Menu::orderBy('urutan')->get();

        $stmtSubMenu = SubMenu::with('menu')->orderBy('urutan')->get();

        return view('manajemen.role.create', compact('title', 'breadcrumbs', 'stmtMenu', 'stmtSubMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_menu = '';
        $id_submenu = '';

        $rules = $request->validate([
            'nama' => 'required|regex:/^[\pL\s\-]+$/u|unique:tbl_master_role,nama',
            'id_menu' => 'required',
            'id_submenu' => 'nullable',
        ], [
            'nama.regex' => 'Nama role hanya boleh diisi dengan huruf dan spasi saja.'
        ]);


        if (count($request->input('id_menu')) > 0) {
            $id_menu = implode(',', $request->input('id_menu'));
        }
        if (count($request->input('id_submenu')) > 0) {
            $id_submenu = implode(',', $request->input('id_submenu'));
        }

        $rules['id_menu'] = $id_menu;
        $rules['id_submenu'] = $id_submenu;

        Role::create($rules);

        createLogActivity('Membuat Role Baru');

        return Redirect::route('manajemen-role.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Role berhasil dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $title = 'Edit ' . self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('manajemen-role.edit', $role)],
        ];

        $stmtMenu = Menu::orderBy('urutan')->get();

        $stmtSubMenu = SubMenu::with('menu')->orderBy('urutan')->get();

        $stmtRole = $role;

        return view('manajemen.role.edit', compact('title', 'breadcrumbs', 'stmtMenu', 'stmtSubMenu', 'stmtRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $id_menu = '';
        $id_submenu = '';

        $rules = $request->validate([
            'nama' => 'required|regex:/^[\pL\s\-]+$/u|unique:tbl_master_role,nama,' . $role->id,
            'id_menu' => 'required',
            'id_submenu' => 'nullable',
        ], [
            'nama.regex' => 'Nama role hanya boleh diisi dengan huruf dan spasi saja.'
        ]);


        if (count($request->input('id_menu')) > 0) {
            $id_menu = implode(',', $request->input('id_menu'));
        }
        if (count($request->input('id_submenu')) > 0) {
            $id_submenu = implode(',', $request->input('id_submenu'));
        }

        $rules['id_menu'] = $id_menu;
        $rules['id_submenu'] = $id_submenu;

        Role::where('id', $role->id)->update($rules);

        createLogActivity("Memperbarui Role {$role->nama}");

        return Redirect::route('manajemen-role.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Role {$role->nama} berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Role::destroy($role->id);

        createLogActivity("Role {$role->nama} berhasil dihapus");

        return Redirect::route('manajemen-role.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Role {$role->nama} berhasil dihapus");
    }
}
