<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetailBagian extends Migration
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
            'id_bagian' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
        ]);

        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('id_bagian','bagian','id','CASCADE','CASCADE');
        $this->forge->createTable('user_detail_bag');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail_bag');
    }
}
