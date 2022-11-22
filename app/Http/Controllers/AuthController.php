<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $request->validate([
            'nrik' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('nrik', 'password');
        if (Auth::attempt($credentials)) { //berhasil login

            // cek dulu sedang login di IP lain atau tidak
            $stmtCekIP = User::where('nrik', $request->nrik)
                ->get();
            foreach ($stmtCekIP as $dataCekIP) {
                $lastIP = $dataCekIP->ip_address;
            }

            if (isset($lastIP) && $ipAddress <> $lastIP) { // jika last IP dan IP saat ini berbeda, maka tidak bisa login
                Session::flush();
                Auth::logout();

                return redirect()->back()->withInput()->withErrors(["User sedang login di IP {$lastIP}"]);
            } else { // berhasil login
                // update IP Address
                User::where('nrik', $request->nrik)->update([
                    'ip_address' => $ipAddress
                ]);

                Session::put('errorLogin', 0);

                return redirect(route('index'));
            }
        } else { //jika salah password / keblokir
            if (Session::get('errorLogin') !== null) {
                $sessionErrorLogin = Session::get('errorLogin') + 1;
                Session::put('errorLogin', $sessionErrorLogin);
                $max_fail = config('secure.APP_SEKURITI_FAIL_LOGIN');

                if ($sessionErrorLogin >= $max_fail) {
                    error_log($request->email);
                    User::where('nrik', $request->nrik)->update([
                        'password' => bcrypt($request->nrik . '@bdki'),
                        'expired_password' => '1970-01-01',
                        'is_blokir' => '1'
                    ]);

                    return redirect()->back()->withInput()->withErrors(["Akun anda keblokir karena sudah {$max_fail} kali "
                        . "melakukan kesalahan"]);
                }
            } else {
                Session::put('errorLogin', 1);
                $sessionErrorLogin = Session::get('errorLogin');
            }

            return redirect()->back()->withInput()->withErrors(["Username atau password salah"]);
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
                'min:' . config('secure.APP_SEKURITI_LENGTH_PASS_MIN') . '',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@#$%]).*$/',
                'different:password',
            ],
            'konfirmasi_password' => [
                'required',
                'same:password_baru',
            ],
        ], [
            'password.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal berisi 8 karakter',
            'password_baru.regex' => 'Password baru tidak sesuai dengan ketentuan.',
            'password_baru.different' => 'Password baru harus berbeda dengan password lama.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
            'konfirmasi_password.same' => 'Konfirmasi password dan password baru harus sama.',
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
                ->with('alert.message', "Berhasil mengganti password");
        }
    }
}
