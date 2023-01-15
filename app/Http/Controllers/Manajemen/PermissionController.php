<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;

class PermissionController extends Controller
{
    private static $title = 'Akses';

    public static function breadcrumb()
    {
        return [
            self::$title, route('permission.index')
        ];
    }

    public function index()
    {
        $title = 'Manajemen Akses';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb()
        ];

        $permissions = Permission::filter(request(['name']))
            ->orderBy('id')
            ->paginate(10);

        return View::make('manajemen.permission.index', compact('title', 'breadcrumbs', 'permissions'));
    }

    public function create()
    {
        $title = 'Tambah Akses Baru';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('permission.create')],
        ];

        $permission = new Permission();

        return View::make('manajemen.permission.create', compact('title', 'breadcrumbs', 'permission'));
    }

    public function store(PermissionRequest $request)
    {
        Permission::create(array_map('strtolower', $request->validated()));

        createLogActivity('Membuat Akses Baru');

        return redirect(route('permission.index'))
            ->with('alert.status', '00')
            ->with('alert.message', "Akses {$request->name} berhasil ditambahkan.");
    }

    public function edit($id)
    {
        $title = 'Ubah Akses';

        $permission = Permission::find($id);

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('permission.edit', $permission->id)],
        ];

        return View::make('manajemen.permission.create', compact('title', 'breadcrumbs', 'permission'));
    }

    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::find($id);
        $permission->update(array_map('strtolower', [
            'id' => $request->id,
            'name' => $request->name,
        ]));

        createLogActivity("Memperbarui Akses {$request->name}");

        return redirect(route('permission.index'))
            ->with('alert.status', '00')
            ->with('alert.message', "Permission {$request->name} berhasil diperbarui.");
    }
}
