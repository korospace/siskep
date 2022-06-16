<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetailSubagian extends Migration
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
            'id_subagian' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
        ]);

        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_subagian','subagian','id','CASCADE','CASCADE');
        $this->forge->createTable('user_detail_subag');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail_subag');
    }
}
