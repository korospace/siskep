<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetailSubagian extends Migration
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
            'id_subagian' => [
                'type'       => 'int',
                'constraint' => 11,  
                'null'       => false,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_subagian','subagian','id','CASCADE','CASCADE');
        $this->forge->createTable('user_detail_subag');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail_subag');
    }
}
