<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'usr_nama' => 'Super User',
            'usr_username' => 'Super user',
            'usr_email' => 'superuser@gmail.com',
            'password' => bcrypt('SuperUser@2024'),
            'usr_stat' => 1,
            'email_verified' => now(),
        ]);

        User::create([
            'usr_nama' => 'Admin',
            'usr_username' => 'admin',
            'usr_email' => 'admin@gmail.com',
            'password' => bcrypt('Admin@2024'),
            'usr_stat' => 1,
            'email_verified' => now(),
        ]);
    }
}
