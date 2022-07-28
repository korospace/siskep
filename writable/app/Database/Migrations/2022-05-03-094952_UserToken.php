<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserToken extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'varchar',
                'constraint' => 255,      
                'null'       => false,
            ],
            'token' => [
                'type'       => 'text',
                'null'       => false,
            ],
        ]);

        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        // $this->forge->createTable('user_token');
    }

    public function down()
    {
        // $this->forge->dropTable('user_token');
    }
}
