<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AksesUsrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Data yang diberikan
        $data = [
            [1, 1, 1, 1, 0, '2024-09-17 08:17:54', NULL, NULL],
            [2, 1, 1, 1, 0, '2024-09-17 08:18:04', NULL, NULL],
            [3, 1, 1, 1, 0, '2024-09-17 08:18:10', NULL, NULL],
            [4, 1, 1, 1, 0, '2024-09-17 08:18:19', NULL, NULL],
            [5, 1, 1, 2, 0, '2024-09-17 08:18:26', NULL, NULL],
            [6, 1, 1, 2, 0, '2024-09-17 08:18:32', NULL, NULL],
            [7, 1, 1, 2, 0, '2024-09-17 08:18:42', NULL, NULL],
            [8, 1, 1, 2, 0, '2024-09-17 08:18:52', NULL, NULL],
            [9, 1, 1, 3, 0, '2024-09-17 08:18:58', NULL, NULL],
            [10, 1, 1, 3, 0, '2024-09-17 08:19:08', NULL, NULL],
            [11, 1, 1, 3, 0, '2024-09-17 08:19:14', NULL, NULL],
            [12, 1, 1, 3, 0, '2024-09-17 08:19:21', NULL, NULL],
            [13, 1, 1, 4, 0, '2024-09-17 08:19:28', NULL, NULL],
            [14, 1, 1, 4, 0, '2024-09-17 08:19:42', NULL, NULL],
            [15, 1, 1, 4, 0, '2024-09-17 08:19:47', NULL, NULL],
            [16, 1, 1, 4, 0, '2024-09-17 08:19:53', NULL, NULL],
            [17, 2, 2, 1, 0, '2024-09-17 08:19:28', NULL, NULL],
            [18, 2, 2, 1, 0, '2024-09-17 08:19:42', NULL, NULL],
            [19, 2, 2, 1, 0, '2024-09-17 08:19:47', NULL, NULL],
            [20, 2, 2, 1, 0, '2024-09-17 08:19:53', NULL, NULL],
            [21, 2, 2, 2, 0, '2024-09-17 08:19:28', NULL, NULL],
            [22, 2, 2, 2, 0, '2024-09-17 08:19:42', NULL, NULL],
            [23, 2, 2, 2, 0, '2024-09-17 08:19:47', NULL, NULL],
            [24, 2, 2, 2, 0, '2024-09-17 08:19:53', NULL, NULL],
            [25, 2, 2, 3, 0, '2024-09-17 08:17:54', NULL, NULL],
            [26, 2, 2, 3, 0, '2024-09-17 08:18:04', NULL, NULL],
            [27, 2, 2, 3, 0, '2024-09-17 08:18:10', NULL, NULL],
            [28, 2, 2, 3, 0, '2024-09-17 08:18:19', NULL, NULL],
            [29, 2, 2, 4, 0, '2024-09-17 08:18:26', NULL, NULL],
            [30, 2, 2, 4, 0, '2024-09-17 08:18:32', NULL, NULL],
            [31, 2, 2, 4, 0, '2024-09-17 08:18:42', NULL, NULL],
            [32, 2, 2, 4, 0, '2024-09-17 08:18:52', NULL, NULL],
        ];

        // Insert ke database
        foreach ($data as $item) {
            \DB::table('akses_usrs')->insert([
                'id_akses' => $item[0],
                'id_usr' => $item[1],
                'id_role' => $item[2],
                'id_menu' => $item[3],
                'hak_akses' => $item[4],
                'created_at' => $item[5],
                'updated_at' => $item[6],
                'deleted_at' => $item[7],
            ]);
        }
    }
}
