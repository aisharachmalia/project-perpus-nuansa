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


        menu::create([
            'menu_nama' => 'Peminjaman dan Pegembalian',
            'menu_parent' => 0,
            'menu_url' => 'peminjaman-pengembalian',
            'menu_icon' => 'bi bi-book-half',
            'menu_urut' => 2,
            'menu_stat' => 1
        ]);

        menu::create([
            'menu_nama' => 'Denda',
            'menu_parent' => 0,
            'menu_url' => 'denda',
            'menu_icon' => 'bi bi-cash-stack',
            'menu_urut' => 3,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Laporan',
            'menu_parent' => 0,
            'menu_url' => 'laporan',
            'menu_icon' => 'bi bi-journal-bookmark-fill',
            'menu_urut' => 4,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Data Master',
            'menu_parent' => 0,
            'menu_url' => null,
            'menu_icon' => 'bi bi-info-circle',
            'menu_urut' => 5,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Siswa',
            'menu_parent' => 5,
            'menu_url' => 'siswa',
            'menu_icon' => null,
            'menu_urut' => 1,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Guru',
            'menu_parent' => 5,
            'menu_url' => 'guru',
            'menu_icon' => null,
            'menu_urut' => 2,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Pustakawan',
            'menu_parent' => 5,
            'menu_url' => 'pustakawan',
            'menu_icon' => null,
            'menu_urut' => 3,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Buku',
            'menu_parent' => 5,
            'menu_url' => 'buku',
            'menu_icon' => null,
            'menu_urut' => 4,
            'menu_stat' => 1
        ]);
        menu::create([
            'menu_nama' => 'Referensi',
            'menu_parent' => 5,
            'menu_url' => 'referensi',
            'menu_icon' => null,
            'menu_urut' => 5,
            'menu_stat' => 1
        ]);

        Menu::create([
            'menu_nama' => 'Setting',
            'menu_parent' => 0,
            'menu_url' => null,
            'menu_icon' => 'bi bi-gear-wide-connected',
            'menu_urut' => 6,
            'menu_stat' => 1
        ]);

        Menu::create([
            'menu_nama' => 'User',
            'menu_parent' => 11,
            'menu_url' => 'users',
            'menu_icon' => null,
            'menu_urut' => 1,
            'menu_stat' => 1
        ]);

        menu::create([
            'menu_nama' => 'Akses User',
            'menu_parent' => 11,
            'menu_url' => 'akses-users',
            'menu_icon' => null,
            'menu_urut' => 2,
            'menu_stat' => 1
        ]);
    }
}
