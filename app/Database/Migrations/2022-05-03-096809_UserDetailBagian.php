<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetailBagian extends Migration
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
            'bag_name' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => false,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('bag_name','bagian','name','CASCADE','CASCADE');
        $this->forge->createTable('user_detail_bag');
    }

    public function down()
    {
        $this->forge->dropTable('user_detail_bag');
    }
}
