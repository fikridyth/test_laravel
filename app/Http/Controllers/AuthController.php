<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PasswordRule;
use App\Statics\User\NRIK;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $recentIpAddress = $_SERVER['REMOTE_ADDR'];
        $max_fail = config('secure.APP_SEKURITI_FAIL_LOGIN');
        $expiredPassword = '1970-01-01';
        $user = User::where('nrik', $request->nrik)->first();

        $this->validate($request, [
            'nrik' => 'required',
            'password' => 'required',
        ], [], [
            'nrik' => 'NRIK',
            'password' => 'Password',
        ]);

        if (!empty($user) && $user->is_blokir == 1) {
            return redirect()->back()->withInput()->withErrors(["Akun anda terblokir karena sudah {$max_fail} kali melakukan kesalahan"]);
        }

        $credentials = $request->only('nrik', 'password');
        if (Auth::attempt($credentials)) { //berhasil login

            // cek dulu sedang login di IP lain atau tidak
            if (isset($user->ip_address) && $recentIpAddress != $user->ip_address) { // jika last IP dan IP saat ini berbeda, maka tidak bisa login
                Session::flush();
                Auth::logout();

                return redirect()->back()->withInput()->withErrors(["User sedang login di IP {$user->ip_address}"]);
            } else { // berhasil login
                // update IP Address
                User::where('nrik', $request->nrik)->update([
                    'ip_address' => $recentIpAddress
                ]);

                $todayDate = Carbon::now()->toDateString();
                $expiredPassword = auth()->user()->expired_password;
                if ($todayDate >= $expiredPassword) { //jika password expired
                    return redirect(route('auth.expired-password'));
                } else {
                    Session::put('errorLogin', 0);

                    return redirect(route('index'));
                }
            }
        } else { //jika salah password / keblokir
            if (Session::get('errorLogin') !== null) {
                $sessionErrorLogin = Session::get('errorLogin') + 1;
                $sessionErrorLoginNRIK = Session::get('errorLoginNRIK');
                Session::put('errorLogin', $sessionErrorLogin);

                if ($request->nrik === NRIK::$DEVELOPER) {
                    $expiredPassword = Carbon::now()->addMonths(config('secure.APP_SEKURITI_PASSWORD_EXP'));
                }

                // jika yg login sekarang berbeda dengan yg login sebelumnya, session error login kembalikan ke 1
                if ($request->nrik != $sessionErrorLoginNRIK) {
                    Session::put('errorLogin', 1);
                }

                if ($sessionErrorLogin >= $max_fail && $sessionErrorLoginNRIK == $request->nrik) {
                    //cek NRIK ada / tidak di DB
                    $countNRIK = User::where('nrik', $request->nrik)->count();
                    if ($countNRIK > 0) {
                        User::where('nrik', $request->nrik)->update([
                            'password' => bcrypt(Hash::make(rand(1000000000, 9999999999))),
                            'expired_password' => $expiredPassword,
                            'is_blokir' => '1'
                        ]);
                        return redirect()->back()->withInput()->withErrors(["Akun anda terblokir karena sudah {$max_fail} kali melakukan kesalahan"]);
                    } else {
                        return redirect()->back()->withInput()->withErrors(["Akun tidak ditemukan"]);
                    }
                }
                Session::put('errorLoginNRIK', $request->nrik);
            } else {
                Session::put('errorLogin', 1);
                Session::put('errorLoginNRIK', $request->nrik);
                $sessionErrorLogin = Session::get('errorLogin');
            }

            return redirect()->back()->withInput()->withErrors(["NRIK atau password salah"]);
        }
    }

    public function logout()
    {
        if (isset(auth()->user()->id)) {
            // update IP Address
            $id = auth()->user()->id;
            $ipAddress = NULL;
            User::where('id', $id)->update([
                'ip_address' => $ipAddress
            ]);

            Session::flush();
            Auth::logout();
        }

        return Redirect(route('auth.login'));
    }

    public function changePassword()
    {
        $title = 'Change Password';

        $breadcrumbs = [
            HomeController::breadcrumb(),
            [$title, route('auth.change-password')]
        ];

        return view('auth.change-password', compact('title', 'breadcrumbs'));
    }

    public function changePasswordSubmit(Request $request)
    {
        $this->validate($request, [
            'password' => [
                'required',
            ],
            'password_baru' => [
                'required',
                PasswordRule::min(config('secure.APP_SEKURITI_LENGTH_PASS_MIN'))
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'different:password',
            ],
            'konfirmasi_password' => [
                'required',
                'same:password_baru',
            ],
        ], [], [
            'password' => 'Password',
            'password_baru' => 'Password baru',
            'konfirmasi_password' => 'Konfirmasi password baru',
        ]);

        $nrik = Auth::user()->nrik;
        $credentials = [
            'nrik' => $nrik,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) { // jika password lama yang diinput tidak sama dengan password di database
            return redirect()->back()->withErrors(['Password lama tidak sesuai!']);
        } else {
            $today = Carbon::now();
            $bulanDepanFull = $today->addMonths(config('secure.APP_SEKURITI_PASSWORD_EXP'));
            $bulanDepanDate = $bulanDepanFull->toDateString();
            User::where('nrik', $nrik)->update([
                'password' => bcrypt($request->password_baru),
                'expired_password' => $bulanDepanDate,
            ]);

            return redirect(route('index'))
                ->with('alert.status', '00')
                ->with('alert.message', "Password berhasil diperbarui");
        }
    }

    public function expiredPassword()
    {
        return view('auth.expired-password');
    }
}
