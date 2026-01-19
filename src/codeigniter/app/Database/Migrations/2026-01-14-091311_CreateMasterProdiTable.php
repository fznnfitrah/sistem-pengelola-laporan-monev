<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterProdiTable extends Migration
{
// File: ..._create_m_prodi_table.php

    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fk_fakultas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_prodi' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_fakultas', 'mFakultas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mProdi');
    }

    public function down()
    {
        $this->forge->dropTable('mProdi');
    }
}
