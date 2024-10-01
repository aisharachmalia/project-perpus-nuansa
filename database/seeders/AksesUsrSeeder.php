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
            // Untuk id_usr = 1, id_role = 1
            [1, 1, 1, 1, 0, now(), NULL, NULL],  // Menu 1
            [2, 1, 1, 1, 1, now(), NULL, NULL],
            [3, 1, 1, 1, 2, now(), NULL, NULL],
            [4, 1, 1, 1, 3, now(), NULL, NULL],

            [5, 1, 1, 2, 0, now(), NULL, NULL],  // Menu 2
            [6, 1, 1, 2, 1, now(), NULL, NULL],
            [7, 1, 1, 2, 2, now(), NULL, NULL],
            [8, 1, 1, 2, 3, now(), NULL, NULL],

            [9, 1, 1, 3, 0, now(), NULL, NULL],  // Menu 3
            [10, 1, 1, 3, 1, now(), NULL, NULL],
            [11, 1, 1, 3, 2, now(), NULL, NULL],
            [12, 1, 1, 3, 3, now(), NULL, NULL],

            [13, 1, 1, 4, 0, now(), NULL, NULL],  // Menu 4
            [14, 1, 1, 4, 1, now(), NULL, NULL],
            [15, 1, 1, 4, 2, now(), NULL, NULL],
            [16, 1, 1, 4, 3, now(), NULL, NULL],

            [17, 1, 1, 6, 0, now(), NULL, NULL],  // Menu 6
            [18, 1, 1, 6, 1, now(), NULL, NULL],
            [19, 1, 1, 6, 2, now(), NULL, NULL],
            [20, 1, 1, 6, 3, now(), NULL, NULL],

            [21, 1, 1, 7, 0, now(), NULL, NULL],  // Menu 7
            [22, 1, 1, 7, 1, now(), NULL, NULL],
            [23, 1, 1, 7, 2, now(), NULL, NULL],
            [24, 1, 1, 7, 3, now(), NULL, NULL],

            [25, 1, 1, 8, 0, now(), NULL, NULL],  // Menu 8
            [26, 1, 1, 8, 1, now(), NULL, NULL],
            [27, 1, 1, 8, 2, now(), NULL, NULL],
            [28, 1, 1, 8, 3, now(), NULL, NULL],

            [29, 1, 1, 9, 0, now(), NULL, NULL],  // Menu 9
            [30, 1, 1, 9, 1, now(), NULL, NULL],
            [31, 1, 1, 9, 2, now(), NULL, NULL],
            [32, 1, 1, 9, 3, now(), NULL, NULL],

            [33, 1, 1, 10, 0, now(), NULL, NULL], // Menu 10
            [34, 1, 1, 10, 1, now(), NULL, NULL],
            [35, 1, 1, 10, 2, now(), NULL, NULL],
            [36, 1, 1, 10, 3, now(), NULL, NULL],

            [37, 1, 1, 12, 0, now(), NULL, NULL], // Menu 12
            [38, 1, 1, 12, 1, now(), NULL, NULL],
            [39, 1, 1, 12, 2, now(), NULL, NULL],
            [40, 1, 1, 12, 3, now(), NULL, NULL],

            [41, 1, 1, 13, 0, now(), NULL, NULL], // Menu 13
            [42, 1, 1, 13, 1, now(), NULL, NULL],
            [43, 1, 1, 13, 2, now(), NULL, NULL],
            [44, 1, 1, 13, 3, now(), NULL, NULL],

            // Untuk id_usr = 2, id_role = 2
            [45, 2, 2, 1, 0, now(), NULL, NULL],  // Menu 1
            [46, 2, 2, 1, 1, now(), NULL, NULL],
            [47, 2, 2, 1, 2, now(), NULL, NULL],
            [48, 2, 2, 1, 3, now(), NULL, NULL],

            [49, 2, 2, 2, 0, now(), NULL, NULL],  // Menu 2
            [50, 2, 2, 2, 1, now(), NULL, NULL],
            [51, 2, 2, 2, 2, now(), NULL, NULL],
            [52, 2, 2, 2, 3, now(), NULL, NULL],

            [53, 2, 2, 3, 0, now(), NULL, NULL],  // Menu 3
            [54, 2, 2, 3, 1, now(), NULL, NULL],
            [55, 2, 2, 3, 2, now(), NULL, NULL],
            [56, 2, 2, 3, 3, now(), NULL, NULL],

            [57, 2, 2, 4, 0, now(), NULL, NULL],  // Menu 4
            [58, 2, 2, 4, 1, now(), NULL, NULL],
            [59, 2, 2, 4, 2, now(), NULL, NULL],
            [60, 2, 2, 4, 3, now(), NULL, NULL],

            [61, 2, 2, 6, 0, now(), NULL, NULL],  // Menu 6
            [62, 2, 2, 6, 1, now(), NULL, NULL],
            [63, 2, 2, 6, 2, now(), NULL, NULL],
            [64, 2, 2, 6, 3, now(), NULL, NULL],

            [65, 2, 2, 7, 0, now(), NULL, NULL],  // Menu 7
            [66, 2, 2, 7, 1, now(), NULL, NULL],
            [67, 2, 2, 7, 2, now(), NULL, NULL],
            [68, 2, 2, 7, 3, now(), NULL, NULL],

            [69, 2, 2, 8, 0, now(), NULL, NULL],  // Menu 8
            [70, 2, 2, 8, 1, now(), NULL, NULL],
            [71, 2, 2, 8, 2, now(), NULL, NULL],
            [72, 2, 2, 8, 3, now(), NULL, NULL],

            [73, 2, 2, 9, 0, now(), NULL, NULL],  // Menu 9
            [74, 2, 2, 9, 1, now(), NULL, NULL],
            [75, 2, 2, 9, 2, now(), NULL, NULL],
            [76, 2, 2, 9, 3, now(), NULL, NULL],

            [77, 2, 2, 10, 0, now(), NULL, NULL], // Menu 10
            [78, 2, 2, 10, 1, now(), NULL, NULL],
            [79, 2, 2, 10, 2, now(), NULL, NULL],
            [80, 2, 2, 10, 3, now(), NULL, NULL],

            [81, 2, 2, 12, 0, now(), NULL, NULL], // Menu 12
            [82, 2, 2, 12, 1, now(), NULL, NULL],
            [83, 2, 2, 12, 2, now(), NULL, NULL],
            [84, 2, 2, 12, 3, now(), NULL, NULL],

            [85, 2, 2, 13, 0, now(), NULL, NULL], // Menu 13
            [86, 2, 2, 13, 1, now(), NULL, NULL],
            [87, 2, 2, 13, 2, now(), NULL, NULL],
            [88, 2, 2, 13, 3, now(), NULL, NULL],

            // Untuk id_usr = 3, id_role = 3
            [89, 3, 3, 1, 0, now(), NULL, NULL],  // Menu 1
            [90, 3, 3, 1, 1, now(), NULL, NULL],
            [91, 3, 3, 1, 2, now(), NULL, NULL],
            [92, 3, 3, 1, 3, now(), NULL, NULL],

            [93, 3, 3, 2, 0, now(), NULL, NULL],  // Menu 2
            [94, 3, 3, 2, 1, now(), NULL, NULL],
            [95, 3, 3, 2, 2, now(), NULL, NULL],
            [96, 3, 3, 2, 3, now(), NULL, NULL],

            [97, 3, 3, 3, 0, now(), NULL, NULL],  // Menu 3
            [98, 3, 3, 3, 1, now(), NULL, NULL],
            [99, 3, 3, 3, 2, now(), NULL, NULL],
            [100, 3, 3, 3, 3, now(), NULL, NULL],

            [101, 3, 3, 4, 0, now(), NULL, NULL],  // Menu 4
            [102, 3, 3, 4, 1, now(), NULL, NULL],
            [103, 3, 3, 4, 2, now(), NULL, NULL],
            [104, 3, 3, 4, 3, now(), NULL, NULL],

            [105, 3, 3, 6, 0, now(), NULL, NULL],  // Menu 6
            [106, 3, 3, 6, 1, now(), NULL, NULL],
            [107, 3, 3, 6, 2, now(), NULL, NULL],
            [108, 3, 3, 6, 3, now(), NULL, NULL],

            [109, 3, 3, 7, 0, now(), NULL, NULL],  // Menu 7
            [110, 3, 3, 7, 1, now(), NULL, NULL],
            [111, 3, 3, 7, 2, now(), NULL, NULL],
            [112, 3, 3, 7, 3, now(), NULL, NULL],

            [113, 3, 3, 8, 0, now(), NULL, NULL],  // Menu 8
            [114, 3, 3, 8, 1, now(), NULL, NULL],
            [115, 3, 3, 8, 2, now(), NULL, NULL],
            [116, 3, 3, 8, 3, now(), NULL, NULL],

            [117, 3, 3, 9, 0, now(), NULL, NULL],  // Menu 9
            [118, 3, 3, 9, 1, now(), NULL, NULL],
            [119, 3, 3, 9, 2, now(), NULL, NULL],
            [120, 3, 3, 9, 3, now(), NULL, NULL],

            [121, 3, 3, 10, 0, now(), NULL, NULL], // Menu 10
            [122, 3, 3, 10, 1, now(), NULL, NULL],
            [123, 3, 3, 10, 2, now(), NULL, NULL],
            [124, 3, 3, 10, 3, now(), NULL, NULL],

            [125, 3, 3, 12, 0, now(), NULL, NULL], // Menu 12
            [126, 3, 3, 12, 1, now(), NULL, NULL],
            [127, 3, 3, 12, 2, now(), NULL, NULL],
            [128, 3, 3, 12, 3, now(), NULL, NULL],

            [129, 3, 3, 13, 0, now(), NULL, NULL], // Menu 13
            [130, 3, 3, 13, 1, now(), NULL, NULL],
            [131, 3, 3, 13, 2, now(), NULL, NULL],
            [132, 3, 3, 13, 3, now(), NULL, NULL],
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
