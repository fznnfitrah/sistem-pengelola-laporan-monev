<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\PeriodeModel;

class Periode extends BaseController
{
    protected $periodeModel;

    public function __construct()
    {
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Setting Periode Laporan',
            'username' => session()->get('username'),
            'periode'  => $this->periodeModel->orderBy('tahun_akademik', 'DESC')->findAll()
        ];
        return view('univ/periode/index', $data);
    }

    public function simpan()
    {
        // Ambil ID dari session sesuai key di Auth.php
        $userId = session()->get('current_user_id'); 

        if (!$userId) {
            return redirect()->back()->with('error', 'Sesi tidak ditemukan, silakan login ulang.');
        }

        $this->periodeModel->insert([
            'semester'          => $this->request->getPost('semester'),
            'tahun_akademik'    => $this->request->getPost('tahun_akademik'),
            'create_by_fk_user' => $userId, // Sekarang data ini tidak akan NULL lagi
            'status_aktif'      => 0
        ]);
        
        return redirect()->back()->with('success', 'Periode baru berhasil ditambah!');
    }

    public function setAktif($id)
    {
        // Set semua periode jadi non-aktif dulu
        $this->periodeModel->where('id >', 0)->set(['status_aktif' => 0])->update();
        
        // Set periode terpilih jadi aktif (1)
        $this->periodeModel->update($id, ['status_aktif' => 1]);
        
        return redirect()->back()->with('success', 'Periode aktif berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $this->periodeModel->delete($id);
        return redirect()->back()->with('success', 'Periode berhasil dihapus!');
    }
}