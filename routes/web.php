<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::name('auth.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login-submit');
});

// routes di web/user.php yang digunakan oleh semua role
Route::middleware('auth')->group(function () {

    // authentication
    Route::name('auth.')->group(function () {
        // logout
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        // untuk ganti password
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password/proses', [AuthController::class, 'changePasswordSubmit'])->name('change-password-submit');
        Route::get('/expired-password', [AuthController::class, 'expiredPassword'])->name('expired-password');
    });

    // dashboard
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('index');

    // konfigurasi
    Route::name('konfigurasi.')->group(function () {
        // last seen
        Route::get('/last-seen', [KonfigurasiController::class, 'lastSeen'])->name('last-seen')->middleware('permission:Users Last Seen');

        // untuk log activity
        Route::get('/user-activity', [KonfigurasiController::class, 'userActivity'])->name('log-activity')->middleware('permission:Users Log Activity');
        Route::post('/decrypt', [KonfigurasiController::class, 'decrypt'])->name('decrypt')->middleware('permission:Users Log Activity');
    });

    // untuk manajemen sekuriti
    Route::prefix('manajemen-sekuriti')->name('manajemen-sekuriti.')->middleware('permission:Security')->group(function () {
        Route::get('/', [KonfigurasiController::class, 'sekuriti'])->name('index');
        Route::post('/update', [KonfigurasiController::class, 'sekuritiUpdate'])->name('update');
    });

    // untuk manajemen user
    Route::resource('/manajemen-user', UserController::class, ['parameters' => ['manajemen-user' => 'user']])->middleware('permission:User List');
    Route::name('manajemen-user.')->group(function () {
        Route::get('/manajemen-user/{user}/buka-blokir', [UserController::class, 'unlockUser'])->name('buka-blokir')->middleware('permission:User Unblock');
        Route::get('/manajemen-user/{user}/lepas-ip', [UserController::class, 'resetIPUser'])->name('lepas-ip')->middleware('permission:User Remove IP');
        Route::get('/profil', [UserController::class, 'changeProfil'])->name('change-profil');
        Route::put('/update-profil', [UserController::class, 'updateProfil'])->name('update-profil');
    });

    // untuk manajemen menu
    Route::prefix('menus')->name('menu.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index')->middleware('permission:Menu List');
        Route::get('/create', [MenuController::class, 'add'])->name('create')->middleware('permission:Menu Create');
        Route::post('/store', [MenuController::class, 'store'])->name('store')->middleware('permission:Menu Create');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit')->middleware('permission:Menu Edit');
        Route::post('/{id}/update', [MenuController::class, 'update'])->name('update')->middleware('permission:Menu Edit');
        Route::get('/{id}/delete', [MenuController::class, 'delete'])->name('del')->middleware('permission:Menu Delete');
    });

    // untuk manajemen role
    Route::prefix('roles')->name('role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index')->middleware('permission:Role List');
        Route::get('/create', [RoleController::class, 'add'])->name('create')->middleware('permission:Role Create');
        Route::post('/store', [RoleController::class, 'store'])->name('store')->middleware('permission:Role Create');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit')->middleware('permission:Role Edit');
        Route::post('/{id}/update', [RoleController::class, 'update'])->name('update')->middleware('permission:Role Edit');
        Route::get('/{id}/delete', [RoleController::class, 'delete'])->name('del')->middleware('permission:Role Delete');
    });

    // untuk manajemen permission
    Route::prefix('permissions')->name('permission.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->middleware('permission:Permission List');
        Route::get('/create', [PermissionController::class, 'add'])->name('create')->middleware('permission:Permission Create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store')->middleware('permission:Permission Create');
        Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('edit')->middleware('permission:Permission Edit');
        Route::post('/{id}/update', [PermissionController::class, 'update'])->name('update')->middleware('permission:Permission Edit');
        Route::get('/{id}/delete', [PermissionController::class, 'delete'])->name('del')->middleware('permission:Permission Delete');
    });
});
