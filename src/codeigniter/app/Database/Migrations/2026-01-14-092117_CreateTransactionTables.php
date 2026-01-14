<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTables extends Migration
{
    public function up()
    {
        // 1. Tabel kinerja_prodi_unit
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fk_prodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_mKinerja' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_setting_periode' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_mUnit' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'create_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_prodi', 'mProdi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_mKinerja', 'mKinerja', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_setting_periode', 'setting_periode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_mUnit', 'mUnit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kinerja_prodi_unit');

        // 2. Tabel laporan_monev
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fk_prodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_setting_periode' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_unit' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_mmonev' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'create_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_prodi', 'mProdi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_setting_periode', 'setting_periode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_unit', 'mUnit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_mmonev', 'mMonev', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('laporan_monev');

        // 3. Tabel menu_hak_akses
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'fk_prodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_roles' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_jenis_menu' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_prodi', 'mProdi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_roles', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_jenis_menu', 'mMenu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_hak_akses');
    }

    public function down()
    {
        $this->forge->dropTable('menu_hak_akses');
        $this->forge->dropTable('laporan_monev');
        $this->forge->dropTable('kinerja_prodi_unit');
    }
}
