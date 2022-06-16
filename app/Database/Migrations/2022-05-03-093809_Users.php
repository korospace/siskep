<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
            ],
            'username' => [
                'type'       => 'varchar',
                'constraint' => 20,      
                'null'       => false,
            ],
            'password' => [
                'type'       => 'text',
                'null'       => false,
            ],
            'id_previlege' => [
                'type'       => 'int',                    
                'constraint' => 11,
                'null'       => false,
            ],
            'created_at' => [
                'type'       => 'bigint',                    
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_previlege','user_type','id','CASCADE','CASCADE');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
