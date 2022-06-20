<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Information extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,      
                'auto_increment' => true,
            ],
            'logo' => [
                'type' => 'longtext',
                'null' => false,
            ],
            'visi' => [
                'type' => 'longtext',
                'null' => false,
            ],
            'misi' => [
                'type' => 'longtext',
                'null' => false,
            ],
            'pengumuman' => [
                'type' => 'longtext',
                'null' => false,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('information');
    }

    public function down()
    {
        $this->forge->dropTable('information');
    }
}
