<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TugasFile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'varchar',
                'constraint' => 255,  
            ],
            'id_tugas' => [
                'type'       => 'varchar',
                'constraint' => 255,    
                'null'       => false,
            ],
            'file_tugas' => [
                'type' => 'text',
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_tugas','tugas','id','CASCADE','CASCADE');
        $this->forge->createTable('tugas_file');
    }

    public function down()
    {
        $this->forge->dropTable('tugas_file');
    }
}
