<?php

namespace App\Http\Controllers\Manajemen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Menu;
use App\Models\Role;
use App\Services\MenuService;
use App\Statics\User\Role as UserRole;

class MenuController extends Controller
{

    private static $title = 'Menu';

    public static function breadcrumb()
    {
        return [
            self::$title, route('v2.menu.index')
        ];
    }

    private function picklistMenu($menu, $titlePadding = 0)
    {
        if ($menu['children'] == []) return '';

        $padding = '';
        for ($i = 0; $i < $titlePadding; $i++)
            $padding .= '&nbsp;';

        $html = [];
        foreach ($menu['children'] as $child) {
            $menu = new Menu();
            $menu->id = $child['id'];
            $menu->name = $padding . $child['id'] . ' ' . $child['title'];

            $html[] = $menu;

            if ($child['children'] != []) {
                $html = array_merge($html, $this->picklistMenu($child, $titlePadding + 5));
            }
        }

        return $html;
    }

    private function printMenu($menu, $titlePadding = 0)
    {
        if ($menu['children'] == []) return '';

        $padding = '';
        for ($i = 0; $i < $titlePadding; $i++)
            $padding .= '&nbsp;';

        $html = '<tbody>';
        foreach ($menu['children'] as $child) {
            $html .= '<tr>'
                . '<td>' . $padding . $child['id'] . ' - ' . $child['title'] . '</td>'
                . '<td>' . $child['route'] . '</td>'
                . '<td>' . $child['icon'] . '</td>'
                . '<td>' . implode(", ", $child['roleNames']) . '</td>'
                . '<td>' . $child['order'] . '</td>'
                . '<td>'
                . '<a class=\'btn btn-small btn-secondary me-2\' href=\'' . route('v2.menu.edit', ['id' => $child['id']]) . '\'>Ubah</a>'
                . '<a class=\'btn btn-small btn-danger btn-del\' href=\'' . route('v2.menu.del', ['id' => $child['id']]) . '\'>Hapus</a>'
                . '</td>'
                . '</tr>';
            $html .= $this->printMenu($child, $titlePadding + 5);
        }
        $html .= '</tbody>';

        return $html;
    }

    public function index()
    {
        $title = self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb()
        ];

        $html = '<table class=\'table align-middle table-row-dashed fs-6 gy-5 kt_default_datatable\'>'
            . '<thead><tr class=\'text-start text-muted fw-bold fs-7 text-uppercase gs-0\'><th>Title</th><th>Route</th><th>Icon</th><th>Roles</th><th>Order</th><th>Action</th></tr></thead>';

        $menu = [
            'children' => MenuService::getMenus(0, UserRole::getAll()),
        ];
        $html .= $this->printMenu($menu);

        $html .= '</table>';

        return View::make('manajemen.menu.index', compact('title', 'breadcrumbs', 'html'));
    }

    public function add()
    {
        $title = 'Tambah Menu Baru';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('v2.menu.create')],
        ];

        $menu = new Menu();
        $menus = $this->picklistMenu([
            'children' => MenuService::getMenus(0, UserRole::getAll())
        ]);
        $roles = Role::all();
        $menuRoles = [];

        return View::make('manajemen.menu.create', compact('title', 'breadcrumbs', 'roles', 'menu', 'menus', 'menuRoles'));
    }

    public function edit($id)
    {
        $title = 'Ubah Menu';

        $query = Menu::with(['roles']);
        $menu = $query->find($id);

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('v2.menu.edit', $menu->id)],
        ];


        $menus = $this->picklistMenu([
            'children' => MenuService::getMenus(0, UserRole::getAll())
        ]);
        $roles = Role::all();
        $menuRoles = [];

        foreach ($menu->roles as $role) {
            $menuRoles[] = $role->id;
        }

        return View::make('manajemen.menu.create', compact('title', 'breadcrumbs', 'roles', 'menu', 'menus', 'menuRoles'));
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        $menu->roles()->sync([]);
        $menu->delete();

        createLogActivity("Menghapus Menu {$menu->name}");

        return redirect(route('v2.menu.index'))
            ->with('alert.status', '00')
            ->with('alert.message', 'Delete successful');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'numeric', 'unique:menus,id', 'min:1', 'max:10000'],
            'name' => ['required', 'string', 'unique:menus,name', 'min:2', 'max:50'],
            'route' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'order' => ['required', 'numeric'],
            'parent' => ['required', 'numeric'],
        ]);

        $menu = new Menu();
        $menu->id = $request->id;
        $menu->route = $request->route;
        $menu->name = $request->name;
        $menu->icon = $request->icon;
        $menu->order = $request->order;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->created_at = date('Y-m-d H:i:s');
        $menu->parent_id = $request->parent;
        $menu->save();

        $menu->roles()->sync($request->roles);

        createLogActivity('Membuat Menu Baru');

        $message = 'Menu ' . $request->name . ' berhasil ditambahkan. ';

        return redirect(route('v2.menu.index'))
            ->with('alert.status', '00')
            ->with('alert.message', $message);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:menus,name,' . $id, 'min:2', 'max:50'],
            'route' => ['required', 'string'],
            'icon' => ['required', 'string'],
            'order' => ['required', 'numeric'],
            'parent' => ['required', 'numeric'],
        ]);

        $menu = Menu::find($id);
        $menu->route = $request->route;
        $menu->name = $request->name;
        $menu->icon = $request->icon;
        $menu->order = $request->order;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->parent_id = $request->parent;
        $menu->save();

        $menu->roles()->sync($request->roles);

        createLogActivity("Memperbarui Menu {$menu->name}");

        $message = 'Menu ' . $request->name . ' berhasil diperbarui. ';

        return redirect(route('v2.menu.index'))
            ->with('alert.status', '00')
            ->with('alert.message', $message);
    }
}
