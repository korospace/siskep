<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kedudukan extends Migration
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
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kedudukan');
    }

    public function down()
    {
        $this->forge->dropTable('kedudukan');
    }
}
