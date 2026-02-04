<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\MonevModel;
use App\Models\PeriodeModel;

class Monev extends BaseController
{
    protected $monevModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->monevModel = new MonevModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        // Gabungkan tabel mMonev dengan setting_periode
        // Diurutkan berdasarkan periode terbaru agar item monev yang aktif muncul di atas
        $db = \Config\Database::connect();
        $builder = $db->table('mMonev');
        $builder->select('mMonev.*, setting_periode.tahun_akademik, setting_periode.semester');
        $builder->join('setting_periode', 'setting_periode.id = mMonev.fk_setting_periode');
        $builder->orderBy('setting_periode.tahun_akademik', 'DESC');
        $builder->orderBy('setting_periode.semester', 'ASC');
        $query = $builder->get();

        $data = [
            'title'    => 'Master Item Monev',
            'username' => session()->get('username'),
            'monev'    => $query->getResultArray(),
            // DISESUAIKAN: Nama variabel disamakan dengan View (periodes)
            'periodes' => $this->periodeModel->orderBy('tahun_akademik', 'DESC')->findAll() 
        ];

        return view('univ/monev/index', $data);
    }

    public function simpan()
    {
        $this->monevModel->insert([
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'nama_monev'         => $this->request->getPost('nama_monev'),
            'keterangan'         => $this->request->getPost('keterangan'),
            'status'             => 1 // Default aktif
        ]);

        return redirect()->back()->with('message', 'Item Monev berhasil ditambahkan!');
    }

    public function update() // Nama method disamakan dengan form action di modal
    {
        $id = $this->request->getPost('id');
        
        $this->monevModel->update($id, [
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'nama_monev'         => $this->request->getPost('nama_monev'),
            'keterangan'         => $this->request->getPost('keterangan'),
            'status'             => $this->request->getPost('status')
        ]);

        return redirect()->back()->with('message', 'Item Monev berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $this->monevModel->delete($id);
        return redirect()->back()->with('message', 'Item Monev berhasil dihapus!');
    }
}