<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,

            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'body' => [
                'type' => 'TEXT',

            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null'=>'true'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null'=>'true'
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('posts');
        
    }

    public function down()
    {
        $this->forge->dropTable('posts');
        
    }
}
