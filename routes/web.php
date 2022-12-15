<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\Manajemen\UserController;
use App\Http\Controllers\Manajemen\MenuController;
use App\Http\Controllers\Manajemen\PermissionController;
use App\Http\Controllers\Manajemen\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// login
Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('auth.login-submit');
});

// routes di web/user.php yang digunakan oleh semua role
Route::middleware('auth')->group(function () {
        // logout
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

        // dashboard
        Route::redirect('/', '/dashboard');
        Route::get('/dashboard', [HomeController::class, 'index'])->name('index');

        //untuk ganti password
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('auth.change-password');
        Route::post('/change-password/proses', [AuthController::class, 'changePasswordSubmit'])->name('auth.change-password-submit');
        Route::get('/expired-password', [AuthController::class, 'expiredPassword'])->name('auth.expired-password');

        //last seen
        Route::get('/last-seen', [KonfigurasiController::class, 'lastSeen'])->name('konfigurasi.last-seen')->middleware('permission:Users Last Seen');

        //untuk log activity
        Route::get('/user-activity', [KonfigurasiController::class, 'userActivity'])->name('konfigurasi.log-activity')->middleware('permission:Users Log Activity');

        //untukManajemenSekuriti
        Route::get('/manajemen-sekuriti', [KonfigurasiController::class, 'sekuriti'])->name('manajemen-sekuriti')->middleware('permission:Security');
        Route::post('/manajemen-sekuriti-update', [KonfigurasiController::class, 'sekuritiUpdate'])->name('manajemen-sekuriti.update')->middleware('permission:Security');

        //untuk manajemen user
        Route::resource('/manajemen-user', UserController::class, ['parameters' => ['manajemen-user' => 'user']]);
        Route::get('/manajemen-user/{user}/buka-blokir', [UserController::class, 'unlockUser'])->name('manajemen-user.buka-blokir')->middleware('permission:User Unblock');
        Route::get('/manajemen-user/{user}/lepas-ip', [UserController::class, 'resetIPUser'])->name('manajemen-user.lepas-ip')->middleware('permission:User Remove IP');
        Route::get('/profil', [UserController::class, 'changeProfil'])->name('auth.change-profil');
        Route::put('/update-profil', [UserController::class, 'updateProfil'])->name('auth.update-profil');

        //////// V2 
        // untuk manajemen menu
        Route::get('/menus', [MenuController::class, 'index'])->name('menu.index')->middleware('permission:Menu List');
        Route::get('/menus/create', [MenuController::class, 'add'])->name('menu.create')->middleware('permission:Menu Create');
        Route::post('/menus/store', [MenuController::class, 'store'])->name('menu.store')->middleware('permission:Menu Create');
        Route::get('/menus/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit')->middleware('permission:Menu Edit');
        Route::post('/menus/{id}/update', [MenuController::class, 'update'])->name('menu.update')->middleware('permission:Menu Edit');
        Route::get('/menus/{id}/delete', [MenuController::class, 'delete'])->name('menu.del')->middleware('permission:Menu Delete');

        // untuk manajemen role
        Route::get('/roles', [RoleController::class, 'index'])->name('role.index')->middleware('permission:Role List');
        Route::get('/roles/create', [RoleController::class, 'add'])->name('role.create')->middleware('permission:Role Create');
        Route::post('/roles/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:Role Create');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:Role Edit');
        Route::post('/roles/{id}/update', [RoleController::class, 'update'])->name('role.update')->middleware('permission:Role Edit');
        Route::get('/roles/{id}/delete', [RoleController::class, 'delete'])->name('role.del')->middleware('permission:Role Delete');

        // untuk manajemen permission
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index')->middleware('permission:Permission List');
        Route::get('/permissions/create', [PermissionController::class, 'add'])->name('permission.create')->middleware('permission:Permission Create');
        Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:Permission Create');
        Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:Permission Edit');
        Route::post('/permissions/{id}/update', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:Permission Edit');
        Route::get('/permissions/{id}/delete', [PermissionController::class, 'delete'])->name('permission.del')->middleware('permission:Permission Delete');
});