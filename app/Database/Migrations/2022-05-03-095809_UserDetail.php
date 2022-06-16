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
                'null'       => false,
            ],
            'npwp' => [
                'type'       => 'varchar',
                'constraint' => 40,      
                'unique'     => true,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'notelp' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'unique'     => true,
                'null'       => false,
            ],
            'id_kedudukan' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'masa_kerja' => [
                'type'       => "integer",                    
                'constraint' => 11,
                'null'       => false,
            ],
            'income' => [
                'type'       => "integer",                    
                'constraint' => 11,
                'null'       => false,
            ],
            'nama_lengkap' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'alamat' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => false,
            ],
            'tgl_lahir' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => false,
            ],
            'kelamin' => [
                'type'       => "ENUM",                    
                'constraint' => ['laki-laki', 'perempuan'],
                'null'       => false,
            ],
            'agama' => [
                'type'       => "ENUM",                    
                'constraint' => ['islam', 'protestan', 'katolik', 'budha', 'hindu', 'khonghucu'],
                'null'       => false,
            ],
            'pendidikan' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => false,
            ],
            'status' => [
                'type'       => "ENUM",                    
                'constraint' => ['active', 'nonactive'],
                'null'       => false,
            ],
        ]);

        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_kedudukan','kedudukan','id','CASCADE','CASCADE');
        $this->forge->createTable('user_detail');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail');
    }
}
