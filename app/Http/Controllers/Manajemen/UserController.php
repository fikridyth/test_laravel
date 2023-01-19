<?php

namespace App\Http\Controllers\Manajemen;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\UserRequest;
use App\Models\HistoryFile;
use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use App\Statics\User\NRIK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private static $title = 'User';

    static function breadcrumb()
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
    public function index(UserDataTable $dataTable)
    {
        abort_if(Gate::denies('user_access'), 403, "You Don't Have Permission.");
        $title = self::$title . 's';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            self::breadcrumb()
        ];

        $stmtRole = Role::orderBy('id')->get();

        return $dataTable->render('manajemen.user.index', compact('title', 'breadcrumbs', 'stmtRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('user_create');
        $title = 'Tambah ' . self::$title;

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
        $this->authorize('user_create');
        $password = date_format(date_create_from_format('Y-m-d', $request->tanggal_lahir), 'dmY');
        $user =  User::create($request->validated() + [
            'password' => bcrypt($password),
            'expired_password' => '1970-01-01',
            'created_by' => Auth::id(),
        ]);
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
        abort_if(Gate::denies('user_show'), 403, "You Don't Have Permission.");
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
        $this->authorize('user_edit');
        $title = 'Ubah ' . self::$title;

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
        $this->authorize('user_edit');
        $user = User::find($user->id);
        $user->name = $request->name;
        $user->nrik = $request->nrik;
        $user->email = $request->email;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->id_unit_kerja = $request->id_unit_kerja;
        $user->updated_by = Auth::id();
        $user->save();

        $user->syncRoles($request->id_role);

        createLogActivity("Memperbarui User {$user->name}");

        return Redirect::route('manajemen-user.index')
            ->with('alert.status', '00')
            ->with('alert.message', "User {$user->name} berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return $user;
    }

    public function unlockUser(User $user)
    {
        $password = bcrypt(date_format(date_create_from_format('Y-m-d', $user->tanggal_lahir), 'dmY'));
        if ($user->nrik === NRIK::$DEVELOPER) {
            $password = '$2y$10$T2czGDqcdZfqpBB.5NDj/edSRKs31MIvs8fDbmKvtUC9TteS6fVhG';
        }

        User::where('id', $user->id)
            ->update([
                'password' => $password,
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
            [$title, route('manajemen-user.change-profil')]
        ];

        return view('manajemen.user.change-profil', compact('title', 'breadcrumbs'));
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
            $fotoPath = $request->file('foto')->storeAs("users/{$user->id}", $file_name, 'public');

            $file = createHistoryFile('PP', $fotoPath, "Profile picture user {$user->name}");
        }

        $user->update([
            'id_file_foto' => $file->id ?? $user->id_file_foto,
            'name' => $request->name,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        createLogActivity("Memperbarui profil");

        return Redirect::route('manajemen-user.change-profil')
            ->with('alert.status', '00')
            ->with('alert.message', "Profil Anda berhasil diperbarui");
    }
}
