<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collections = [
            ['nama' => 'Dashboard', 'link' => '/dashboard', 'urutan' => '1'],
            ['nama' => 'Manajemen', 'link' => '#', 'urutan' => '98'],
            ['nama' => 'Konfigurasi', 'link' => '#', 'urutan' => '99'],
        ];

        collect($collections)->each(function ($data) {
            Menu::create($data);
        });
    }
}
