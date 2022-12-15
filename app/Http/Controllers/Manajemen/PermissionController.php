<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
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

        public function add()
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

        public function store(Request $request)
        {
                $this->validate($request, [
                        'id' => ['required', 'numeric', 'unique:permissions,id', 'min:1', 'max:100000'],
                        'name' => ['required', 'string', 'unique:permissions,name', 'min:2', 'max:50'],
                        'guard_name' => ['required', 'string', 'min:2', 'max:50'],
                ]);

                Permission::create(['id' => $request->id, 'name' => $request->name]);

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
                        [$title, route('role.edit', $permission->id)],
                ];

                return View::make('manajemen.permission.create', compact('title', 'breadcrumbs', 'permission'));
        }

        public function update(Request $request, $id)
        {
                $this->validate($request, [
                        'name' => ['required', 'string', 'unique:permissions,name,' . $id, 'min:2', 'max:50'],
                        'guard_name' => ['required', 'string', 'min:2', 'max:50'],
                ]);

                $permission = Permission::find($id);
                $permission->name = $request->name;
                $permission->save();

                createLogActivity("Memperbarui Akses {$permission->name}");

                return redirect(route('permission.index'))
                        ->with('alert.status', '00')
                        ->with('alert.message', "Permission {$request->name} berhasil diperbarui.");
        }
}
