<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterTables extends Migration
{
// File: ..._create_master_tables.php

    public function up()
    {
        // 1. Tabel roles
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_roles' => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');

        // 2. Tabel mUnit
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_unit' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mUnit');

        // 3. Tabel mFakultas
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_fakultas' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mFakultas');

        // 4. Tabel mKinerja
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'total_dosen' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'guru_besar' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'profesor' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mKinerja');

        // 5. Tabel mMonev
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_monev' => ['type' => 'VARCHAR', 'constraint' => 100],
            'status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1], // Boolean
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mMonev');

        // 6. Tabel mMenu
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'jenis_menu' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mMenu');
    }

    public function down()
    {
        // Urutan drop dibalik dari urutan create
        $this->forge->dropTable('mMenu');
        $this->forge->dropTable('mMonev');
        $this->forge->dropTable('mKinerja');
        $this->forge->dropTable('mFakultas');
        $this->forge->dropTable('mUnit');
        $this->forge->dropTable('roles');
    }
}
