<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collections = [
            ['nama' => 'Super Admin', 'id_menu' => '1,2,3', 'id_submenu' => '1,2,3,4,5,6,7'],
            ['nama' => 'Developer', 'id_menu' => '1,2,3', 'id_submenu' => '1,2,3,4,5,6,7'],
            ['nama' => 'Developer', 'id_menu' => '1', 'id_submenu' => '0'],
        ];

        collect($collections)->each(function ($data) {
            Role::create($data);
        });
    }
}
