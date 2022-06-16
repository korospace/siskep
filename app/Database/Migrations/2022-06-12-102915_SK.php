<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SK extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,      
                'auto_increment' => true,
            ],
            'no_sk' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'unique'     => true,
                'null'       => false,
            ],
            'title' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => false,
            ],
            'tgl_sk' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => false,
            ],
            'file_sk' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('SK');
    }

    public function down()
    {
        $this->forge->dropTable('SK');
    }
}
