<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bagian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'name' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'unique'     => true,
                'null'       => false,
            ],
            'description' => [
                'type'       => 'longtext',
                'null'       => false,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('bagian');
    }

    public function down()
    {
        $this->forge->dropTable('bagian');
    }
}
