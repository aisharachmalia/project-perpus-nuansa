<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [1, 1, 1, 1, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 1
            [2, 1, 1, 1, 2, now('Asia/Jakarta'), NULL, NULL],
            [3, 1, 1, 1, 3, now('Asia/Jakarta'), NULL, NULL],
            [4, 1, 1, 1, 4, now('Asia/Jakarta'), NULL, NULL],

            [5, 1, 1, 2, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 2
            [6, 1, 1, 2, 2, now('Asia/Jakarta'), NULL, NULL],
            [7, 1, 1, 2, 3, now('Asia/Jakarta'), NULL, NULL],
            [8, 1, 1, 2, 4, now('Asia/Jakarta'), NULL, NULL],

            [9, 1, 1, 3, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 3
            [10, 1, 1, 3, 2, now('Asia/Jakarta'), NULL, NULL],
            [11, 1, 1, 3, 3, now('Asia/Jakarta'), NULL, NULL],
            [12, 1, 1, 3, 4, now('Asia/Jakarta'), NULL, NULL],

            [13, 1, 1, 4, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 4
            [14, 1, 1, 4, 2, now('Asia/Jakarta'), NULL, NULL],
            [15, 1, 1, 4, 3, now('Asia/Jakarta'), NULL, NULL],
            [16, 1, 1, 4, 4, now('Asia/Jakarta'), NULL, NULL],

            [17, 1, 1, 5, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 5
            [18, 1, 1, 5, 2, now('Asia/Jakarta'), NULL, NULL],
            [19, 1, 1, 5, 3, now('Asia/Jakarta'), NULL, NULL],
            [20, 1, 1, 5, 4, now('Asia/Jakarta'), NULL, NULL],

            [21, 1, 1, 6, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 6
            [22, 1, 1, 6, 2, now('Asia/Jakarta'), NULL, NULL],
            [23, 1, 1, 6, 3, now('Asia/Jakarta'), NULL, NULL],
            [24, 1, 1, 6, 4, now('Asia/Jakarta'), NULL, NULL],

            [25, 1, 1, 7, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 7
            [26, 1, 1, 7, 2, now('Asia/Jakarta'), NULL, NULL],
            [27, 1, 1, 7, 3, now('Asia/Jakarta'), NULL, NULL],
            [28, 1, 1, 7, 4, now('Asia/Jakarta'), NULL, NULL],

            [29, 1, 1, 8, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 8
            [30, 1, 1, 8, 2, now('Asia/Jakarta'), NULL, NULL],
            [31, 1, 1, 8, 3, now('Asia/Jakarta'), NULL, NULL],
            [32, 1, 1, 8, 4, now('Asia/Jakarta'), NULL, NULL],

            [33, 1, 1, 9, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 9
            [34, 1, 1, 9, 2, now('Asia/Jakarta'), NULL, NULL],
            [35, 1, 1, 9, 3, now('Asia/Jakarta'), NULL, NULL],
            [36, 1, 1, 9, 4, now('Asia/Jakarta'), NULL, NULL],

            [37, 1, 1, 10, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 10
            [38, 1, 1, 10, 2, now('Asia/Jakarta'), NULL, NULL],
            [39, 1, 1, 10, 3, now('Asia/Jakarta'), NULL, NULL],
            [40, 1, 1, 10, 4, now('Asia/Jakarta'), NULL, NULL],

            [41, 1, 1, 11, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 11
            [42, 1, 1, 11, 2, now('Asia/Jakarta'), NULL, NULL],
            [43, 1, 1, 11, 3, now('Asia/Jakarta'), NULL, NULL],
            [44, 1, 1, 11, 4, now('Asia/Jakarta'), NULL, NULL],

            [45, 1, 1, 12, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 12
            [46, 1, 1, 12, 2, now('Asia/Jakarta'), NULL, NULL],
            [47, 1, 1, 12, 3, now('Asia/Jakarta'), NULL, NULL],
            [48, 1, 1, 12, 4, now('Asia/Jakarta'), NULL, NULL],



            // Untuk id_usr = 2, id_role = 2
            [53, 2, 2, 1, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 1
            [54, 2, 2, 1, 2, now('Asia/Jakarta'), NULL, NULL],
            [55, 2, 2, 1, 3, now('Asia/Jakarta'), NULL, NULL],
            [56, 2, 2, 1, 4, now('Asia/Jakarta'), NULL, NULL],

            [57, 2, 2, 2, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 2
            [58, 2, 2, 2, 2, now('Asia/Jakarta'), NULL, NULL],
            [59, 2, 2, 2, 3, now('Asia/Jakarta'), NULL, NULL],
            [60, 2, 2, 2, 4, now('Asia/Jakarta'), NULL, NULL],

            [61, 2, 2, 3, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 3
            [62, 2, 2, 3, 2, now('Asia/Jakarta'), NULL, NULL],
            [63, 2, 2, 3, 3, now('Asia/Jakarta'), NULL, NULL],
            [64, 2, 2, 3, 4, now('Asia/Jakarta'), NULL, NULL],

            [65, 2, 2, 4, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 4
            [66, 2, 2, 4, 2, now('Asia/Jakarta'), NULL, NULL],
            [67, 2, 2, 4, 3, now('Asia/Jakarta'), NULL, NULL],
            [68, 2, 2, 4, 4, now('Asia/Jakarta'), NULL, NULL],

            [69, 2, 2, 5, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 5
            [70, 2, 2, 5, 2, now('Asia/Jakarta'), NULL, NULL],
            [71, 2, 2, 5, 3, now('Asia/Jakarta'), NULL, NULL],
            [72, 2, 2, 5, 4, now('Asia/Jakarta'), NULL, NULL],

            [73, 2, 2, 6, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 6
            [74, 2, 2, 6, 2, now('Asia/Jakarta'), NULL, NULL],
            [75, 2, 2, 6, 3, now('Asia/Jakarta'), NULL, NULL],
            [76, 2, 2, 6, 4, now('Asia/Jakarta'), NULL, NULL],

            [77, 2, 2, 7, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 7
            [78, 2, 2, 7, 2, now('Asia/Jakarta'), NULL, NULL],
            [79, 2, 2, 7, 3, now('Asia/Jakarta'), NULL, NULL],
            [80, 2, 2, 7, 4, now('Asia/Jakarta'), NULL, NULL],

            [81, 2, 2, 8, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 8
            [82, 2, 2, 8, 2, now('Asia/Jakarta'), NULL, NULL],
            [83, 2, 2, 8, 3, now('Asia/Jakarta'), NULL, NULL],
            [84, 2, 2, 8, 4, now('Asia/Jakarta'), NULL, NULL],

            [85, 2, 2, 9, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 9
            [86, 2, 2, 9, 2, now('Asia/Jakarta'), NULL, NULL],
            [87, 2, 2, 9, 3, now('Asia/Jakarta'), NULL, NULL],
            [88, 2, 2, 9, 4, now('Asia/Jakarta'), NULL, NULL],

            [89, 2, 2, 10, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 10
            [90, 2, 2, 10, 2, now('Asia/Jakarta'), NULL, NULL],
            [91, 2, 2, 10, 3, now('Asia/Jakarta'), NULL, NULL],
            [92, 2, 2, 10, 4, now('Asia/Jakarta'), NULL, NULL],

            [93, 2, 2, 11, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 11
            [94, 2, 2, 11, 2, now('Asia/Jakarta'), NULL, NULL],
            [95, 2, 2, 11, 3, now('Asia/Jakarta'), NULL, NULL],
            [96, 2, 2, 11, 4, now('Asia/Jakarta'), NULL, NULL],

            [97, 2, 2, 12, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 12
            [98, 2, 2, 12, 2, now('Asia/Jakarta'), NULL, NULL],
            [99, 2, 2, 12, 3, now('Asia/Jakarta'), NULL, NULL],
            [100, 2, 2, 12,4, now('Asia/Jakarta'), NULL, NULL],



            // Untuk id_usr = 3, id_role = 3
            [105, 3, 3, 1, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 1
            [106, 3, 3, 1, 2, now('Asia/Jakarta'), NULL, NULL],
            [107, 3, 3, 1, 3, now('Asia/Jakarta'), NULL, NULL],
            [108, 3, 3, 1, 4, now('Asia/Jakarta'), NULL, NULL],

            [109, 3, 3, 2, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 2
            [110, 3, 3, 2, 2, now('Asia/Jakarta'), NULL, NULL],
            [111, 3, 3, 2, 3, now('Asia/Jakarta'), NULL, NULL],
            [112, 3, 3, 2, 4, now('Asia/Jakarta'), NULL, NULL],

            [113, 3, 3, 3, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 3
            [114, 3, 3, 3, 2, now('Asia/Jakarta'), NULL, NULL],
            [115, 3, 3, 3, 3, now('Asia/Jakarta'), NULL, NULL],
            [116, 3, 3, 3, 4, now('Asia/Jakarta'), NULL, NULL],

            [117, 3, 3, 4, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 4
            [118, 3, 3, 4, 2, now('Asia/Jakarta'), NULL, NULL],
            [119, 3, 3, 4, 3, now('Asia/Jakarta'), NULL, NULL],
            [120, 3, 3, 4, 4, now('Asia/Jakarta'), NULL, NULL],

            [121, 3, 3, 5, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 5
            [122, 3, 3, 5, 2, now('Asia/Jakarta'), NULL, NULL],
            [123, 3, 3, 5, 3, now('Asia/Jakarta'), NULL, NULL],
            [124, 3, 3, 5, 4, now('Asia/Jakarta'), NULL, NULL],

            [125, 3, 3, 6, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 6
            [126, 3, 3, 6, 2, now('Asia/Jakarta'), NULL, NULL],
            [127, 3, 3, 6, 3, now('Asia/Jakarta'), NULL, NULL],
            [128, 3, 3, 6, 4, now('Asia/Jakarta'), NULL, NULL],

            [137, 3, 3, 9, 1, now('Asia/Jakarta'), NULL, NULL],  // Menu 9
            [138, 3, 3, 9, 2, now('Asia/Jakarta'), NULL, NULL],
            [139, 3, 3, 9, 3, now('Asia/Jakarta'), NULL, NULL],
            [140, 3, 3, 9, 4, now('Asia/Jakarta'), NULL, NULL],

            [141, 3, 3, 10, 0, now('Asia/Jakarta'), NULL, NULL], // Menu 10
            [142, 3, 3, 10, 0, now('Asia/Jakarta'), NULL, NULL],
            [143, 3, 3, 10, 0, now('Asia/Jakarta'), NULL, NULL],
            [144, 3, 3, 10, 0, now('Asia/Jakarta'), NULL, NULL],

            [145, 3, 3, 11, 0, now('Asia/Jakarta'), NULL, NULL], // Menu 11
            [146, 3, 3, 11, 0, now('Asia/Jakarta'), NULL, NULL],
            [147, 3, 3, 11, 0, now('Asia/Jakarta'), NULL, NULL],
            [148, 3, 3, 11, 0, now('Asia/Jakarta'), NULL, NULL],

            [149, 3, 3, 12, 0, now('Asia/Jakarta'), NULL, NULL], // Menu 12
            [150, 3, 3, 12, 0, now('Asia/Jakarta'), NULL, NULL],
            [151, 3, 3, 12, 0, now('Asia/Jakarta'), NULL, NULL],
            [152, 3, 3, 12, 0, now('Asia/Jakarta'), NULL, NULL],



            [157, 3, 3, 7, 0, now('Asia/Jakarta'), NULL, NULL], // Menu 7
            [158, 3, 3, 7, 0, now('Asia/Jakarta'), NULL, NULL],
            [159, 3, 3, 7, 0, now('Asia/Jakarta'), NULL, NULL],
            [160, 3, 3, 7, 0, now('Asia/Jakarta'), NULL, NULL],

            [161, 3, 3, 8, 1, now('Asia/Jakarta'), NULL, NULL], // Menu 8
            [162, 3, 3, 8, 2, now('Asia/Jakarta'), NULL, NULL],
            [163, 3, 3, 8, 3, now('Asia/Jakarta'), NULL, NULL],
            [164, 3, 3, 8, 4, now('Asia/Jakarta'), NULL, NULL],

        ];



        // Insert ke database
        foreach ($data as $item) {
            DB::table('akses_usrs')->insert([
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
