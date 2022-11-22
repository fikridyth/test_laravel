<?php

namespace Database\Seeders;

use App\Models\StatusDistribusi;
use App\Models\StatusProses;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // Data Menu
            MenuSeeder::class,
            SubMenuSeeder::class,

            // Data User
            UnitKerjaSeeder::class,
            DivisiSeeder::class,
            DepartemenSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}