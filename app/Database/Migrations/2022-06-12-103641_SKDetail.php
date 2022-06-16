<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SKDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'no_sk' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
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
            'id_bagian' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'id_subagian' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
        ]);

        $this->forge->addForeignKey('no_sk','SK','no_sk','CASCADE','CASCADE');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_kedudukan','kedudukan','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_bagian','bagian','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_subagian','subagian','id','CASCADE','CASCADE');
        $this->forge->createTable('SK_detail');
    }

    public function down()
    {
        $this->forge->dropTable('SK_detail');
    }
}
