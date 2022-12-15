<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    private static $title = 'Role';

    public static function breadcrumb()
    {
        return [
            self::$title, route('role.index')
        ];
    }

    public function index()
    {
        $title = 'Manajemen Role';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb()
        ];

        $roles = Role::orderBy('id')->get();

        return View::make('manajemen.role.index', compact('title', 'breadcrumbs', 'roles'));
    }

    public function add()
    {
        $title = 'Tambah Role Baru';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('role.create')],
        ];

        $permissions = Permission::all();
        $role = new Role();
        $rolePermissions = [];

        return View::make('manajemen.role.create', compact('title', 'breadcrumbs', 'permissions', 'role', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'numeric', 'unique:roles,id', 'min:1', 'max:50'],
            'name' => ['required', 'string', 'unique:roles,name', 'min:2', 'max:50'],
            'guard_name' => ['required', 'string', 'min:2', 'max:50'],
        ]);

        $role = Role::create(['id' => $request->id, 'name' => $request->name]);
        $role->syncPermissions($request->permissions);

        createLogActivity('Membuat Role Baru');

        return redirect(route('role.index'))
            ->with('alert.status', '00')
            ->with('alert.message', 'Role ' . $request->name . ' berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $title = 'Ubah Role';

        $role = Role::with(['permissions'])->find($id);

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('role.edit', $role->id)],
        ];

        $rolePermissions = [];
        foreach ($role->permissions as $item)
            $rolePermissions[] = $item->name;

        $permissions = Permission::all();

        return View::make('manajemen.role.create', compact('title', 'breadcrumbs', 'permissions', 'role', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:roles,name,' . $id, 'min:2', 'max:50'],
            'guard_name' => ['required', 'string'],
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::find($id);
        $role->name = $request->name;
        $role->updated_at = date('Y-m-d H:i:s');
        $role->save();

        $role->syncPermissions($request->permissions);

        createLogActivity("Memperbarui Role {$role->name}");

        return redirect(route('role.index'))
            ->with('alert.status', '00')
            ->with('alert.message', 'Role ' . $request->name . ' berhasil diperbarui.');
    }
}
