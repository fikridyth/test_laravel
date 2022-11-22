<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\SubMenuRequest;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SubMenuController extends Controller
{
    private static $title = 'SubMenu';

    public static function breadcrumb()
    {
        return [
            self::$title, route('manajemen-submenu.index')
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

        $stmtMenu = Menu::orderBy('urutan')->get();

        $stmtSubMenu = SubMenu::with('menu')->filter(request(['status', 'menu']))->orderBy('urutan')->get();

        return view('manajemen.submenu.index', compact('title', 'breadcrumbs', 'stmtMenu', 'stmtSubMenu'));
    }

    public function aktif(SubMenu $submenu)
    {
        $submenu->update(['status_data' => 1, 'updated_by' => Auth::id()]);

        createLogActivity("Mengaktifkan kembali submenu {$submenu->nama}");

        return Redirect::route('manajemen-submenu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "SubMenu {$submenu->nama} berhasil diaktifkan kembali");
    }

    public function nonaktif(SubMenu $submenu)
    {
        $submenu->update(['status_data' => 2, 'updated_by' => Auth::id()]);

        createLogActivity("Menonaktifkan submenu {$submenu->nama}");

        return Redirect::route('manajemen-submenu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "SubMenu {$submenu->nama} berhasil dinonaktifkan");
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
            [$title, route('manajemen-submenu.create')],
        ];

        $stmtMenu = Menu::orderBy('urutan')->get();

        return view('manajemen.submenu.create', compact('title', 'breadcrumbs', 'stmtMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SubMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubMenuRequest $request)
    {
        SubMenu::create($request->validated() + ['created_by' => Auth::id()]);
        createLogActivity('Membuat SubMenu Baru');

        return Redirect::route('manajemen-submenu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "SubMenu berhasil dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubMenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function show(SubMenu $submenu)
    {
        return $submenu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubMenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function edit(SubMenu $submenu)
    {
        $title = 'Edit ' . self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('manajemen-submenu.edit', $submenu)],
        ];

        $stmtMenu = Menu::orderBy('urutan')->get();

        $stmtSubMenu = $submenu;

        return view('manajemen.submenu.edit', compact('title', 'breadcrumbs', 'stmtMenu', 'stmtSubMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SubMenuRequest  $request
     * @param  \App\Models\SubMenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function update(SubMenuRequest $request, SubMenu $submenu)
    {
        SubMenu::where('id', $submenu->id)->update($request->validated() + ['updated_by' => Auth::id()]);

        createLogActivity("Memperbarui SubMenu {$submenu->nama}");

        return Redirect::route('manajemen-submenu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "SubMenu {$submenu->nama} berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubMenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubMenu $submenu)
    {
        //
    }
}
