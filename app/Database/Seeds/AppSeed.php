<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeed extends Seeder
{
    public function run()
    {
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
                "type" => "nonasn"
            ],
        ];

        foreach ($dataUserType as $d) {
            $this->db->table('user_type')->insert($d);
        }

        /**
         * Table Bagian
         */
        $dataBagian = [
            [
                "id"    => "B01",
                "name"  => "bagian 1"
            ],
            [
                "id"    => "B02",
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
                "id"        => "SB01",
                "id_bagian" => "B01",
                "name"      => "subagian 1"
            ],
            [
                "id"        => "SB02",
                "id_bagian" => "B01",
                "name"      => "subagian 2"
            ],
            [
                "id"        => "SB03",
                "id_bagian" => "B01",
                "name"      => "subagian 3"
            ],
            [
                "id"        => "SB04",
                "id_bagian" => "B02",
                "name"      => "subagian 2.1"
            ],
            [
                "id"        => "SB05",
                "id_bagian" => "B02",
                "name"      => "subagian 2.2"
            ],
            [
                "id"        => "SB06",
                "id_bagian" => "B02",
                "name"      => "subagian 2.3"
            ],
        ];

        foreach ($dataSubagian as $d) {
            $this->db->table('subagian')->insert($d);
        }

        /**
         * Table Kedudukan
         */
        $dataKedudukan = [
            [
                "id"    => "K01",
                "name"  => "tenaga administrasi"
            ],
            [
                "id"    => "K02",
                "name"  => "tenaga akuntansi"
            ],
        ];

        foreach ($dataKedudukan as $d) {
            $this->db->table('kedudukan')->insert($d);
        }

        /**
         * Table users
         */
        $dataUsers = [
            [
                "id"        => uniqid(),
                "username"  => "superadmin",
                "password"  => password_hash(trim("superadmin"), PASSWORD_DEFAULT),
                "id_previlege" => 1,
                "created_At"   => time(),
            ],
            [
                "id"        => uniqid(),
                "username"  => "inistaf1",
                "password"  => password_hash(trim("inistaf1"), PASSWORD_DEFAULT),
                "id_previlege" => 4,
                "created_At"   => time(),
            ],
        ];

        foreach ($dataUsers as $d) {
            $this->db->table('users')->insert($d);
        }

        /**
         * Table information
         */
        $dataInformation = [
            "logo"       => "logo-kemendagri.webp",
            "pengumuman" => "<p><em style=\"color: rgb(82, 82, 91);\">(kosongkan jika tidak ingin ditampilkan)</em></p>",
            "visi"       => "<blockquote class=\"ql-align-center\"><strong style=\"color: rgb(255, 255, 0);\"><em><s><u>Mewujudkan Pemerintahan Desa yang Mampu Memberikan Pelayanan Prima Kepada Masyarakat</u></s></em></strong></blockquote>",
            "misi"       => "<ol><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan penyelenggaraan Pemerintahan Desa guna meningkatkan kualitas pelayanan pemerintah kepada masyarakat yang ditunjukkan dengan pemenuhan SPM Desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan peran perencanaan partisipatif dengan perlibatan aktif kelembagaan masyarakat desa dalam upaya pengentasan kemiskinan pada wilayah desa dan kawasan perdesaan;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Memantapkan tata kelola aset dan keuangan desa berdasarkan prinsip transparansi, akuntabilitas, dan kemanfaatan;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kualitas kehidupan sosial budaya dan kerjasama masyarakat desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kualitas evaluasi penyelenggaraan pemerintahan desa dan penyusunan peringkat tingkat perkembangan desa;</span></li><li><span style=\"color: rgb(0, 0, 0);\">Meningkatkan kapasitas aparat dan lembaga masyarakat dalam pelaksanaan pembangunan desa lingkup regional.</span></li></ol>",
        ];

        $this->db->table('information')->insert($dataInformation);
    }
}
