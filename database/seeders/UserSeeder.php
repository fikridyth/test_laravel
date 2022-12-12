<?php

namespace Database\Seeders;

use App\Models\User;
use App\Statics\User\NRIK;
use Illuminate\Database\Seeder;
use App\Statics\User\UnitKerja as StaticUnitKerja;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collections = [
            [
                'name' => 'Super Admin',
                'nrik' => NRIK::$SUPER_ADMIN,
                'email' => 'superadmin@example.com',
                'password' => '$2y$10$p2.BMYY0Ne43yArEik7Ah.JsMdjFMJy0/Pkl5WsCok6QX8Y8/2wXS', // P@ssw0rd321
                'tanggal_lahir' => '1999-09-09',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => '1970-01-01',
            ],
            [
                'name' => 'Developer',
                'nrik' => NRIK::$DEVELOPER,
                'email' => 'noncoredev@gmail.com',
                'password' => '$2y$10$p2.BMYY0Ne43yArEik7Ah.JsMdjFMJy0/Pkl5WsCok6QX8Y8/2wXS', // P@ssw0rd321
                'tanggal_lahir' => '1999-09-09',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => Carbon::now()->addMonths(config('secure.APP_SEKURITI_PASSWORD_EXP')),
            ],
            [
                'name' => 'Adi Nugroho',
                'nrik' => NRIK::$ADI,
                'email' => '99999998@example.com',
                'password' => '$2y$10$PNNQcGIEAsN2pamkLWEtAOVcTPr6y/ypS1.AROh7g2mHxfww7CX0C', // 99999998@bdki
                'tanggal_lahir' => '1996-04-10',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => Carbon::now()->addMonths(config('secure.APP_SEKURITI_PASSWORD_EXP')),
            ],
            [
                'name' => 'Kusdhian Herlambang',
                'nrik' => NRIK::$KUSDHIAN,
                'email' => 'kusdhian@gmail.com',
                'password' => '$2y$10$UJF0jcUdyl..AeRTh7REgOCzVq0CyK2.qa7xxQSksFpCp.DbpQYjq', // 28451215@bdki
                'tanggal_lahir' => '1991-06-13',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => '1970-01-01',
            ],
            [
                'name' => 'Wildan Afifi',
                'nrik' => NRIK::$WILDAN,
                'email' => 'wildan.afifi@gmail.com',
                'password' => '$2y$10$be9d/cipKutFJGo2le7y1e2dv5Chj7nUrkBcx4TQvmGvsMElkLCl6', // 47071022@bdki
                'tanggal_lahir' => '1993-05-13',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => '1970-01-01',
            ],
            [
                'name' => 'Kal Kausar',
                'nrik' => NRIK::$KAUTSAR,
                'email' => 'kalkausar98@gmail.com',
                'password' => '$2y$10$dbhiOLNTtr/iiTo0hx9lBuuCaKmKvbBak6BOD7iyiXplj2L8u0Iaq', // 46050522@bdki
                'tanggal_lahir' => '1998-08-30',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => '1970-01-01',
            ],
            [
                'name' => 'Rendy Agustian',
                'nrik' => NRIK::$RENDY,
                'email' => 'rendy.bdki@gmail.com',
                'password' => '$2y$10$8YZJ3Dv.gZkQ4kXw3X9aFu5bN5slAzPTHVOBJg2lMrAiGRSkV2kYG', // 26011214@bdki
                'tanggal_lahir' => '1989-07-19',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => '1970-01-01',
            ],
            [
                'name' => 'Fiqqi Nurrakhman',
                'nrik' => NRIK::$FIQQI,
                'email' => 'fiqqirahman@gmail.com',
                'password' => '$2y$10$t520Y0ZzcZCo5NkVScmrcO8Lev4cFUXm5tqXf86dXNXX7WWdRZFVe', // 42101120@bdki
                'tanggal_lahir' => '1994-04-19',
                'id_unit_kerja' => StaticUnitKerja::$GRUP_TEKNOLOGI_INFORMASI,
                'expired_password' => '1970-01-01',
            ],
        ];

        collect($collections)->each(function ($data) {
            User::create($data);
        });
    }
}
