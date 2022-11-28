<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;

class CustomClass
{
    public function rootApp()
    {
        // return "/laravel-apps/public";
    }

    public function enkrip($id)
    {
        $enkripString = Crypt::encryptString($id);
        return $enkripString;
    }

    public function dekrip($id)
    {
        $dekripString = Crypt::decryptString($id);
        return $dekripString;
    }

    public function ketStatusData($id)
    {
        if ($id == 1) {
            $ketStatusData = "Aktif";
        } elseif ($id == 0) {
            $ketStatusData = "Tidak Aktif";
        } else {
            $ketStatusData = "-";
        }
        return $ketStatusData;
    }

    public function notifSuksesTambah()
    {
        return "Data berhasil diinput";
    }

    public function notifTidakSesuai()
    {
        return "Data gagal diinput";
    }

    public function notifPasswordTidakSesuai()
    {
        return "Data gagal diinput. Password yang Anda masukkan tidak sesuai";
    }

    public function notifSuksesEdit()
    {
        return "Data berhasil diubah";
    }

    public function notifSuksesHapus()
    {
        return "Data berhasil dihapus";
    }

    public function notifHeaderForbiddenAkses()
    {
        return "Anda tidak berhak mengakses halaman ini";
    }

    public function notifBodyForbiddenAkses()
    {
        return "Hubungi administrator aplikasi";
    }

    public function kosongkanPassword()
    {
        return "Kosongkan kolom jika tidak ada perubahan password";
    }

    public function folderGambar()
    {
        return "document/";
    }
    public function folderFileUpload()
    {
        return "document/MRI";
    }

    public function notifGagalLogin()
    {
        // return "Login gagal. Email / Password salah atau User tidak terdaftar.";
        return "Login gagal. NRIK / Password salah atau User tidak terdaftar.";
    }

    public function notifIPNyangkut()
    {
        return "Login gagal. User masih login di tempat lain";
    }

    public function notifBlokirLogin()
    {
        return "User Anda diblokir karena sudah 3 (tiga) kali gagal login. ";
    }

    public function notifGagalGantiPassword()
    {
        return "Password gagal diubah.";
    }

    public function notifBerhasilGantiPassword()
    {
        return "Password berhasil diubah.";
    }

    public function notifKonfirmasiPasswordSalah()
    {
        return "Password gagal diubah. Password baru dan konfirmasi password baru tidak sesuai.";
    }

    public function notifPasswordLamaSalah()
    {
        return "Password gagal diubah. Password lama yang Anda masukkan salah.";
    }

    public function notifPasswordLamaPasswordBaruSama()
    {
        return "Password gagal diubah. Password baru tidak boleh sama dengan password lama.";
    }

    public function ketStatusBlokir($id)
    {
        if ($id == 1) {
            $ketStatusBlokir = "User Terblokir";
        } else {
            $ketStatusBlokir = "-";
        }
        return $ketStatusBlokir;
    }

    public function notifSuksesBukaBlokir()
    {
        return "Buka blokir user berhasil";
    }

    public function notifSuksesBukaIPNyangkut()
    {
        return "Melepaskan IP Address user berhasil";
    }
}