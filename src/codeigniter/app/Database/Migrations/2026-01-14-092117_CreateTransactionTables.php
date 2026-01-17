<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTables extends Migration
{
    public function up()
    {
        // 1. Tabel kinerja_prodi_unit
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'comment'        => 'Primary Key Transaksi',
            ],
            'fk_mkinerja' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'FK ke mKinerja',
            ],
            'fk_setting_periode' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'FK ke setting_periode',
            ],
            'fk_mprodi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK ke mProdi (Boleh NULL jika milik Unit)',
            ],
            'fk_munit' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'comment'    => 'FK ke mUnit (Boleh NULL jika milik Prodi)',
            ],
            'value' => [
                'type'       => 'DOUBLE',
                'default'    => 0,
                'comment'    => 'Nilai realisasi kinerja',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Waktu input data',
            ],
        ]);
                    
        $this->forge->addKey('id', true);
        
        // Foreign Keys
        $this->forge->addForeignKey('fk_mkinerja', 'mKinerja', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_setting_periode', 'setting_periode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_mprodi', 'mProdi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_munit', 'mUnit', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('kinerja_prodi_unit');

        // 2. Tabel laporan_monev
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 
                'constraint' => 11, 
                'unsigned' => true, 
                'auto_increment' => true
            ],
            'fk_prodi' => [
                'type' => 'INT', 
                'constraint' => 11, 
                'unsigned' => true
            ],
            'fk_setting_periode' => [
                'type' => 'INT', 
                'constraint' => 11, 
                'unsigned' => true
            ],
            'fk_unit' => [
                'type' => 'INT', 
                'constraint' => 11, 
                'unsigned' => true
            ],
            'fk_mmonev' => [
                'type' => 'INT', 
                'constraint' => 11, 
                'unsigned' => true
            ],
            'create_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
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
