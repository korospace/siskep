<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeed extends Seeder
{
    public function run()
    {
        /**
         * Table Bagian
         */
        $dataBagian = [
            [
                "name"  => "bagian 1"
            ],
            [
                "name"  => "bagian 2"
            ],
        ];

        foreach ($dataBagian as $d) {
            $this->db->table('bagian')->insert($d);
        }

        /**
         * Table Subagian
         */
        $dataSubagian = [
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

        foreach ($dataSubagian as $d) {
            $this->db->table('subagian')->insert($d);
        }

        /**
         * Table user_type
         */
        $dataUserType = [
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

        foreach ($dataUserType as $d) {
            $this->db->table('user_type')->insert($d);
        }

        /**
         * Table users
         */
        $dataUsers = [
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

        foreach ($dataUsers as $d) {
            $this->db->table('users')->insert($d);
        }

        /**
         * Table user_detail
         */
        $i    = 0;
        $dataUserDetail = [
            [
                "user_id" => "k1",
                "nik"     => "1111",
                "email"   => "k1@gmail.com",
                "nama_lengkap" => "kabag 1",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "k2",
                "nik"     => "4444",
                "email"   => "k2@gmail.com",
                "nama_lengkap" => "kabag 2",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "ks1",
                "nik"     => "5555",
                "email"   => "ks1@gmail.com",
                "nama_lengkap" => "kasubag 1 bag 1",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "ks2",
                "nik"     => "6666",
                "email"   => "ks2@gmail.com",
                "nama_lengkap" => "kasubag 2 bag 1",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "ks3",
                "nik"     => "7777",
                "email"   => "ks3@gmail.com",
                "nama_lengkap" => "kasubag 1 bag 2",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "ks4",
                "nik"     => "8888",
                "email"   => "ks4@gmail.com",
                "nama_lengkap" => "kasubag 2 bag 2",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "st1",
                "nik"     => "9999",
                "email"   => "st1@gmail.com",
                "nama_lengkap" => "staf 1 bag 1 subag 1",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "st2",
                "nik"     => "1212",
                "email"   => "st2@gmail.com",
                "nama_lengkap" => "staf 2 bag 1 subag 2",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "st3",
                "nik"     => "1313",
                "email"   => "st3@gmail.com",
                "nama_lengkap" => "staf 3 bag 2 subag 1",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
            [
                "user_id" => "st4",
                "nik"     => "1414",
                "email"   => "st4@gmail.com",
                "nama_lengkap" => "staf 4 bag 2 subag 2",
                "agama"        => "islam",
                "tgl_lahir"    => "03-10-2000",
                "pendidikan"   => "s1",
                "golongan"     => "asn",
                "alamat"       => "indonesia",
                "kelamin"      => "laki-laki",
                "notelp"       => "0851553524".++$i,
            ],
        ];

        foreach ($dataUserDetail as $d) {
            $this->db->table('user_detail')->insert($d);
        }

        /**
         * Table user_detail_bag
         */
        $dataUserDetailBag = [
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

        foreach ($dataUserDetailBag as $d) {
            $this->db->table('user_detail_bag')->insert($d);
        }

        /**
         * Table user_detail_subag
         */
        $dataUserDetailSubag = [
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

        foreach ($dataUserDetailSubag as $d) {
            $this->db->table('user_detail_subag')->insert($d);
        }

        /**
         * Table information
         */
        $dataInformation = [
            "logo" => "logo-kemendagri.webp",
            "title" => "-",
            "visi"  => "-",
            "misi"  => "-",
            "pengumuman" => "-"
        ];

        $this->db->table('information')->insert($dataInformation);
    }
}
