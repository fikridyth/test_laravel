<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\RoleRequest;
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

    public function create()
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

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());
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

    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->update([
            'name' => $request->name
        ]);

        $role->syncPermissions($request->permissions);

        createLogActivity("Memperbarui Role {$role->name}");

        return redirect(route('role.index'))
            ->with('alert.status', '00')
            ->with('alert.message', 'Role ' . $request->name . ' berhasil diperbarui.');
    }
}
