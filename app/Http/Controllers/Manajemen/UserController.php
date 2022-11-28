<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        $stmtUser = User::with(['roles'])
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
                'is_blokir' => null
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

    public function changeProfil()
    {
        $title = 'Ubah Profil';

        $breadcrumbs = [
            [$title, route('auth.change-profil')]
        ];

        return view('auth.change-profil', compact('title', 'breadcrumbs'));
    }

    public function updateProfil(Request $request)
    {
        $user = User::find(Auth::id());

        $this->validate($request, [
            'foto' => 'nullable|mimes:png,jpg,jpeg',
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'tanggal_lahir' => 'required|date',
        ], [
            'name.regex' => 'Nama hanya boleh diisi menggunakan huruf atau spasi saja.'
        ]);

        if ($request->foto) {
            $file_original = $request->foto->getClientOriginalName();
            $extension = pathinfo($file_original, PATHINFO_EXTENSION);
            $file_name = $user->id . '.' . $extension;
            $fotoPath = $request->file('foto')->storeAs('files/users', $file_name, 'public');
        }

        User::where('id', $user->id)->update([
            'foto' => $request->foto ? $fotoPath : $user->foto,
            'name' => $request->name,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);


        createLogActivity("User {$user->nama} memperbarui profil");

        return Redirect::route('auth.change-profil')
            ->with('alert.status', '00')
            ->with('alert.message', "Profil Anda berhasil diperbarui");
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
        $user = new User();
        $user->name = $request->name;
        $user->nrik = $request->nrik;
        $user->email = $request->email;
        $user->password = bcrypt($request->nrik . '@bdki');
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->id_unit_kerja = $request->id_unit_kerja;
        $user->status_data = 1;
        $user->expired_password = Carbon::now()->addMonths(config('secure.APP_SEKURITI_PASSWORD_EXP'));
        $user->updated_by = Auth::id();
        $user->save();

        $user->assignRole($request->id_role);

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
        $user = User::find($user->id);
        $user->name = $request->name;
        $user->nrik = $request->nrik;
        $user->email = $request->email;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->id_unit_kerja = $request->id_unit_kerja;
        $user->updated_by = Auth::id();
        $user->save();

        $user->syncRoles($request->id_role);

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
