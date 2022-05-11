<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersDetailBagSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "user_id"  => "k1",
                "bag_name" => "bagian 1"
            ],
            [
                "user_id"  => "k2",
                "bag_name" => "bagian 2"
            ],
            [
                "user_id" => "ks1",
                "bag_name" => "bagian 1"
            ],
            [
                "user_id" => "ks2",
                "bag_name" => "bagian 1"
            ],
            [
                "user_id" => "ks3",
                "bag_name" => "bagian 2"
            ],
            [
                "user_id" => "ks4",
                "bag_name" => "bagian 2"
            ],
            [
                "user_id" => "st1",
                "bag_name" => "bagian 1"
            ],
            [
                "user_id" => "st2",
                "bag_name" => "bagian 1"
            ],
            [
                "user_id" => "st3",
                "bag_name" => "bagian 2"
            ],
            [
                "user_id" => "st4",
                "bag_name" => "bagian 2"
            ],
        ];

        foreach ($data as $d) {
            $this->db->table('user_detail_bag')->insert($d);
        }
    }
}
