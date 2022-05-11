<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeed extends Seeder
{
    public function run()
    {
        $data = [
            [
                "id"        => uniqid(),
                "username"  => "superadmin",
                "password"  => password_hash(trim("superadmin"), PASSWORD_DEFAULT),
                "id_previlege" => 1
            ],
            [
                "id"        => "k1",
                "username"  => "inikabag1",
                "password"  => password_hash(trim("inikabag1"), PASSWORD_DEFAULT),
                "id_previlege" => 2
            ],
            [
                "id"        => "k2",
                "username"  => "inikabag2",
                "password"  => password_hash(trim("inikabag2"), PASSWORD_DEFAULT),
                "id_previlege" => 2
            ],
            [
                "id"        => "ks1",
                "username"  => "kasubag1",
                "password"  => password_hash(trim("kasubag1"), PASSWORD_DEFAULT),
                "id_previlege" => 3
            ],
            [
                "id"        => "ks2",
                "username"  => "kasubag2",
                "password"  => password_hash(trim("kasubag2"), PASSWORD_DEFAULT),
                "id_previlege" => 3
            ],
            [
                "id"        => "ks3",
                "username"  => "kasubag3",
                "password"  => password_hash(trim("kasubag3"), PASSWORD_DEFAULT),
                "id_previlege" => 3
            ],
            [
                "id"        => "ks4",
                "username"  => "kasubag4",
                "password"  => password_hash(trim("kasubag4"), PASSWORD_DEFAULT),
                "id_previlege" => 3
            ],
            [
                "id"        => "st1",
                "username"  => "inistaf1",
                "password"  => password_hash(trim("inistaf1"), PASSWORD_DEFAULT),
                "id_previlege" => 4
            ],
            [
                "id"        => "st2",
                "username"  => "inistaf2",
                "password"  => password_hash(trim("inistaf2"), PASSWORD_DEFAULT),
                "id_previlege" => 4
            ],
            [
                "id"        => "st3",
                "username"  => "inistaf3",
                "password"  => password_hash(trim("inistaf3"), PASSWORD_DEFAULT),
                "id_previlege" => 4
            ],
            [
                "id"        => "st4",
                "username"  => "inistaf4",
                "password"  => password_hash(trim("inistaf4"), PASSWORD_DEFAULT),
                "id_previlege" => 4
            ],
        ];

        foreach ($data as $d) {
            $this->db->table('users')->insert($d);
        }
    }
}
