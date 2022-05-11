<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BagSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "name"  => "bagian 1"
            ],
            [
                "name"  => "bagian 2"
            ],
        ];

        foreach ($data as $d) {
            $this->db->table('bagian')->insert($d);
        }
    }
}
