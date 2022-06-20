<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tugas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
            ],
            'user_id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'title' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => false,
            ],
            'status' => [
                'type'       => "ENUM",                    
                'constraint' => ['tugas baru','pengecekan','diterima','revisi'],
                'null'       => false,
            ],
            'komentar' => [
                'type'       => 'longtext',
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'bigint',                    
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('tugas');
    }

    public function down()
    {
        $this->forge->dropTable('tugas');
    }
}
