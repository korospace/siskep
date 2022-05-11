<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SubagSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "bagian" => "bagian 1",
                "name"   => "subagian 1"
            ],
            [
                "bagian" => "bagian 1",
                "name"   => "subagian 2"
            ],
            [
                "bagian" => "bagian 1",
                "name"   => "subagian 3"
            ],
            [
                "bagian" => "bagian 2",
                "name"   => "subagian 2.1"
            ],
            [
                "bagian" => "bagian 2",
                "name"   => "subagian 2.2"
            ],
            [
                "bagian" => "bagian 2",
                "name"   => "subagian 2.3"
            ],
        ];

        foreach ($data as $d) {
            $this->db->table('subagian')->insert($d);
        }
    }
}
