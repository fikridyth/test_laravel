<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private static $title = 'User';

    public static function breadcrumb()
    {
        return [
            self::$title, route('manajemen-user.index')
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

        $stmtUser = User::with('role')
            ->searchByName(request(['nama']))
            ->filter(request(['role', 'status_blokir']))
            ->orderBy('name')
            ->paginate(10);

        return view('manajemen.user.index', compact('title', 'breadcrumbs', 'stmtRole', 'stmtUser'));
    }

    public function unlockUser(User $user)
    {
        $resetPassword = $user->nrik . '@bdki';
        User::where('id', $user->id)
            ->update([
                'password' => bcrypt($resetPassword),
                'is_blokir' => 0
            ]);

        createLogActivity("Membuka blokir user {$user->name}");

        return Redirect::route('manajemen-user.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Berhasil membuka blokir User {$user->name}");
    }

    public function resetIPUser(User $user)
    {
        User::where('id', $user->id)->update(['ip_address' => null]);

        createLogActivity("Melepaskan IP Adress pada user {$user->name}");

        return Redirect::route('manajemen-user.index')
            ->with('alert.status', '00')
            ->with('alert.message', "Berhasil melepaskan IP Address User {$user->name}");
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
            [$title, route('manajemen-user.create')],
        ];

        $stmtRole = Role::orderBy('id')->get();

        $stmtUnitKerja = UnitKerja::orderBy('nama')->get();

        return view('manajemen.user.create', compact('title', 'breadcrumbs', 'stmtRole', 'stmtUnitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create($request->validated() + [
            'expired_password' => Carbon::now()->addMonths(config('secure.APP_SEKURITI_PASSWORD_EXP')),
            'password' => bcrypt($request->nrik . '@bdki')
        ]);
        createLogActivity('Membuat User Baru');

        return Redirect::route('manajemen-user.index')
            ->with('alert.status', '00')
            ->with('alert.message', "User berhasil dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = 'Edit ' . self::$title;

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb(),
            [$title, route('manajemen-user.edit', $user)],
        ];

        $stmtRole = Role::orderBy('id')->get();

        $stmtUnitKerja = UnitKerja::orderBy('nama')->get();

        $stmtUser = $user;

        return view('manajemen.user.edit', compact('title', 'breadcrumbs', 'stmtRole', 'stmtUnitKerja', 'stmtUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        User::where('id', $user->id)->update($request->validated() + ['updated_by' => Auth::id()]);

        createLogActivity("Memperbarui User {$user->nama}");

        return Redirect::route('manajemen-user.index')
            ->with('alert.status', '00')
            ->with('alert.message', "User {$user->nama} berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
