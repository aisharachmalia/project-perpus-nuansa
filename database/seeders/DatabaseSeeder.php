<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            UserSeeder::class,
            RoleSeeder::class,
            MenuSeeder::class,
            AksesUsrSeeder::class,
            KelasSeeder::class,
            DmGuruSeeder::class,
            DmMapelSeeder::class,
            DMPustakawanSeeder::class,
            DmPenulisSeeder::class,
            DmPenerbitSeeder::class,
            DmKategoriSeeder::class,
            DmBukuSeeder::class,
            SiswaSeeder::class,
        ]);
    }
}
