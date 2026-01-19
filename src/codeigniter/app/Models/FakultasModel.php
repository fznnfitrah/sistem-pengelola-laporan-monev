<?php
namespace App\Models;
use CodeIgniter\Model;

class FakultasModel extends Model {
    protected $table = 'mFakultas'; // Sesuai database kamu
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; // Karena varchar(20)
    protected $allowedFields = ['id', 'nama_fakultas'];
}