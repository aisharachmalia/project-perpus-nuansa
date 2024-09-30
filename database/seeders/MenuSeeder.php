<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Menu::create([
            'menu_nama' => 'Dashboard',
            'menu_parent' => 0,
            'menu_url' => 'dashboard',
            'menu_icon' => 'bi bi-grid-fill',
            'menu_urut' => 1,
            'menu_stat' => 1
        ]);


        Menu::create([
            'menu_nama' => 'Setting',
            'menu_parent' => 0,
            'menu_url' => null,
            'menu_icon' => 'bi bi-gear-wide-connected',
            'menu_urut' => 3,
            'menu_stat' => 1
        ]);

        Menu::create([
            'menu_nama' => 'User',
            'menu_parent' => 2,
            'menu_url' => 'users',
            'menu_icon' => null,
            'menu_urut' => 1,
            'menu_stat' => 1
        ]);

        menu::create([
            'menu_nama' => 'Akses User',
            'menu_parent' => 2,
            'menu_url' => 'akses-users',
            'menu_icon' => null,
            'menu_urut' => 2,
            'menu_stat' => 1
        ]);

        menu::create([
            'menu_nama' => 'Transaction',
            'menu_parent' => 0,
            'menu_url' => 'transaction',
            'menu_icon' => 'bi bi-receipt-cutoff',
            'menu_urut' => 2,
            'menu_stat' => 1
        ]);

        menu::create([
            'menu_nama' => 'About',
            'menu_parent' => 0,
            'menu_url' => 'about',
            'menu_icon' => 'bi bi-info-circle',
            'menu_urut' => 0,
            'menu_stat' => 1
        ]);
    }
}
