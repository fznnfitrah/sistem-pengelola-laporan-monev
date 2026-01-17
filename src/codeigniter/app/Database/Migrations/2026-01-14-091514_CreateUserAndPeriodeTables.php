<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserAndPeriodeTables extends Migration
{
    public function up()
    {
        // 1. Tabel user
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 100],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'fk_roles' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'fk_fakultas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'fk_prodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 50],
            'create_at' => ['type' => 'DATETIME', 'null' => true],
            'delete_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('fk_roles', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_fakultas', 'mFakultas', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('fk_prodi', 'mProdi', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('user');

        // 2. Tabel setting_periode
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'create_by_fk_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'semester' => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun_akademik' => ['type' => 'VARCHAR', 'constraint' => 20],
            'status_aktif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'create_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('create_by_fk_user', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('setting_periode');
    }

    public function down()
    {
        $this->forge->dropTable('setting_periode');
        $this->forge->dropTable('user');
    }
}
