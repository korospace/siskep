<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,      
                'auto_increment' => true,
            ],
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
                'null'       => false,
            ],
            'email' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'nama_lengkap' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'agama' => [
                'type'       => "ENUM",                    
                'constraint' => ['islam', 'protestan', 'katolik', 'budha', 'hindu', 'khonghucu'],
                'null'       => false,
            ],
            'tgl_lahir' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => false,
            ],
            'pendidikan' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => false,
            ],
            'golongan' => [
                'type'       => "ENUM",                    
                'constraint' => ['asn', 'non-asn'],
                'null'       => false,
            ],
            'masa_kerja' => [
                'type'       => "integer",                    
                'constraint' => 11,
                'null'       => false,
            ],
            'alamat' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => false,
            ],
            'kelamin' => [
                'type'       => "ENUM",                    
                'constraint' => ['laki-laki', 'perempuan'],
                'null'       => false,
            ],
            'notelp' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'unique'     => true,
                'null'       => false,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('user_detail');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail');
    }
}
