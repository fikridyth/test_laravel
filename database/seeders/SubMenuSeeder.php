<?php

namespace Database\Seeders;

use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collections = [
            ['nama' => 'Menu', 'id_menu' => '2', 'link' => '/manajemen-menu', 'urutan' => '1'],
            ['nama' => 'Submenu', 'id_menu' => '2', 'link' => '/manajemen-submenu', 'urutan' => '2'],
            ['nama' => 'Role', 'id_menu' => '2', 'link' => '/manajemen-role', 'urutan' => '3'],
            ['nama' => 'User', 'id_menu' => '2', 'link' => '/manajemen-user', 'urutan' => '4'],
            ['nama' => 'Sekuriti', 'id_menu' => '2', 'link' => '/manajemen-sekuriti', 'urutan' => '5'],
            ['nama' => 'Last Seen User', 'id_menu' => '3', 'link' => '/last-seen', 'urutan' => '1'],
            ['nama' => 'Log Activity User', 'id_menu' => '3', 'link' => '/user-activity', 'urutan' => '2'],
        ];

        collect($collections)->each(function ($data) {
            SubMenu::create($data);
        });
    }
}
