<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    private static $title = 'Menu';

    public static function breadcrumb()
    {
        return [
            self::$title, route('manajemen-menu.index')
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

        $stmtMenu = Menu::filter(request(['status']))->orderBy('urutan')->get();

        return view('manajemen.menu.index', compact('title', 'breadcrumbs', 'stmtMenu'));
    }

    public function aktif(Menu $menu)
    {
        $menu->update(['status_data' => 1, 'updated_by' => Auth::id()]);

        createLogActivity("Mengaktifkan kembali menu {$menu->nama}");

        return Redirect::route('manajemen-menu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Menu {$menu->nama} berhasil diaktifkan kembali");
    }

    public function nonaktif(Menu $menu)
    {
        $menu->update(['status_data' => 2, 'updated_by' => Auth::id()]);

        createLogActivity("Menonaktifkan menu {$menu->nama}");

        return Redirect::route('manajemen-menu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Menu {$menu->nama} berhasil dinonaktifkan");
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
            [$title, route('manajemen-menu.create')],
        ];

        return view('manajemen.menu.create', compact('title', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\MenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        Menu::create($request->validated() + ['created_by' => Auth::id()]);
        createLogActivity('Membuat Menu Baru');

        return Redirect::route('manajemen-menu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Menu berhasil dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return $menu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $title = 'Edit ' . self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('manajemen-menu.edit', $menu)],
        ];

        $stmtMenu = $menu;

        return view('manajemen.menu.edit', compact('title', 'breadcrumbs', 'stmtMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\MenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        Menu::where('id', $menu->id)->update($request->validated() + ['updated_by' => Auth::id()]);

        createLogActivity("Memperbarui Menu {$menu->nama}");

        return Redirect::route('manajemen-menu.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Menu {$menu->nama} berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        // 
    }
}
