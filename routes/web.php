<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\Manajemen\MenuController;
use App\Http\Controllers\Manajemen\RoleController;
use App\Http\Controllers\Manajemen\SubMenuController;
use App\Http\Controllers\Manajemen\UserController;

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
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('auth.login-submit');
});

// routes di web/user.php yang digunakan oleh semua role
Route::middleware(['auth'])->group(function () {
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
    Route::get('/last-seen', [KonfigurasiController::class, 'lastSeen'])->name('konfigurasi.last-seen');

    //untuk log activity
    Route::get('/user-activity', [KonfigurasiController::class, 'userActivity'])->name('konfigurasi.log-activity');

    //untukManajemenSekuriti
    Route::get('/manajemen-sekuriti', [KonfigurasiController::class, 'sekuriti'])->name('manajemen-sekuriti');
    Route::post('/manajemen-sekuriti-update', [KonfigurasiController::class, 'sekuritiUpdate'])->name('manajemen-sekuriti.update');

    //untuk manajemen menu
    Route::resource('/manajemen-menu', MenuController::class, ['parameters' => ['manajemen-menu' => 'menu']]);
    Route::put('/manajemen-menu/{menu}/nonaktif', [MenuController::class, 'nonaktif'])->name('manajemen-menu.nonaktif');
    Route::put('/manajemen-menu/{menu}/aktif', [MenuController::class, 'aktif'])->name('manajemen-menu.aktif');

    //untuk manajemen submenu
    Route::resource('/manajemen-submenu', SubMenuController::class, ['parameters' => ['manajemen-submenu' => 'submenu']]);
    Route::put('/manajemen-submenu/{submenu}/nonaktif', [SubMenuController::class, 'nonaktif'])->name('manajemen-submenu.nonaktif');
    Route::put('/manajemen-submenu/{submenu}/aktif', [SubMenuController::class, 'aktif'])->name('manajemen-submenu.aktif');
    
    //untuk manajemen role
    Route::resource('/manajemen-role', RoleController::class, ['parameters' => ['manajemen-role' => 'role']]);

    //untuk manajemen user
    Route::resource('/manajemen-user', UserController::class, ['parameters' => ['manajemen-user' => 'user']]);
    Route::get('/manajemen-user/{user}/buka-blokir', [UserController::class, 'unlockUser'])->name('manajemen-user.buka-blokir');
    Route::get('/manajemen-user/{user}/lepas-ip', [UserController::class, 'resetIPUser'])->name('manajemen-user.lepas-ip');
});
