<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subagian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'id_bagian' => [
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
        $this->forge->addForeignKey('id_bagian','bagian','id','CASCADE','CASCADE');
        $this->forge->createTable('subagian');
    }

    public function down()
    {
        $this->forge->dropTable('subagian');
    }
}
