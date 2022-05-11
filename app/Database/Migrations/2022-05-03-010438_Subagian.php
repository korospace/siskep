<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subagian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'int',
                'constraint' => 11,      
                'auto_increment' => true,
            ],
            'bagian' => [
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
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('bagian','bagian','name','CASCADE','CASCADE');
        $this->forge->createTable('subagian');
    }

    public function down()
    {
        $this->forge->dropTable('subagian');
    }
}
