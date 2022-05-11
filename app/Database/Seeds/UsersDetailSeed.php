<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersDetailSeed extends Seeder
{
    public function run()
    {
        $i    = 0;
        $data = [
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

        foreach ($data as $d) {
            $this->db->table('user_detail')->insert($d);
        }
    }
}
