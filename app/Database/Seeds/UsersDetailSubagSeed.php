<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersDetailSubagSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "user_id" => "ks1",
                "subag_name" => "subagian 1"
            ],
            [
                "user_id" => "ks2",
                "subag_name" => "subagian 2"
            ],
            [
                "user_id" => "ks3",
                "subag_name" => "subagian 2.1"
            ],
            [
                "user_id" => "ks4",
                "subag_name" => "subagian 2.2"
            ],
            [
                "user_id" => "st1",
                "subag_name" => "subagian 1"
            ],
            [
                "user_id" => "st2",
                "subag_name" => "subagian 2"
            ],
            [
                "user_id" => "st3",
                "subag_name" => "subagian 2.1"
            ],
            [
                "user_id" => "st4",
                "subag_name" => "subagian 2.2"
            ],
        ];

        foreach ($data as $d) {
            $this->db->table('user_detail_subag')->insert($d);
        }
    }
}
