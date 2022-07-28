<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'int',
                'constraint' => 11,      
                'auto_increment' => true,
            ],
            'type' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'unique'     => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user_type');
    }

    public function down()
    {
        $this->forge->dropTable('user_type');
    }
}
