<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserTypeSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "type" => "admin"
            ],
            [
                "type" => "kabag"
            ],
            [
                "type" => "kasubag"
            ],
            [
                "type" => "pegawai"
            ],
        ];

        foreach ($data as $d) {
            $this->db->table('user_type')->insert($d);
        }
    }
}
