<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'unique'     => true,
                'null'       => false,
            ],
            'nik' => [
                'type'       => 'varchar',
                'constraint' => 20,      
                'unique'     => true,
                'null'       => true,
            ],
            'npwp' => [
                'type'       => 'varchar',
                'constraint' => 40,      
                'unique'     => true,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => true,
            ],
            'notelp' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'unique'     => true,
                'null'       => true,
            ],
            'no_sk' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => true,
            ],
            'id_bagian' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => true,
            ],
            'id_subagian' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => true,
            ],
            'id_kedudukan' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => true,
            ],
            'masa_kerja' => [
                'type'       => "integer",                    
                'constraint' => 11,
                'null'       => true,
            ],
            'income' => [
                'type'       => "integer",                    
                'constraint' => 11,
                'null'       => true,
            ],
            'nama_lengkap' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => true,
            ],
            'alamat' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
            ],
            'tgl_lahir' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => true,
            ],
            'kelamin' => [
                'type'       => "ENUM",                    
                'constraint' => ['laki-laki', 'perempuan'],
                'null'       => true,
            ],
            'agama' => [
                'type'       => "ENUM",                    
                'constraint' => ['islam', 'protestan', 'katolik', 'budha', 'hindu', 'khonghucu'],
                'null'       => true,
            ],
            'pendidikan' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => true,
            ],
            'status' => [
                'type'       => "ENUM",                    
                'constraint' => ['active', 'nonactive'],
                'null'       => true,
            ],
        ]);

        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('no_sk','SK','no_sk','SET NULL','SET NULL');
        $this->forge->addForeignKey('id_bagian','bagian','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_subagian','subagian','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_kedudukan','kedudukan','id','CASCADE','CASCADE');
        $this->forge->createTable('user_detail');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail');
    }
}
