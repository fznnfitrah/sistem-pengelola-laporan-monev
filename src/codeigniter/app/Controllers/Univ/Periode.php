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
            // Mengurutkan Tahun Akademik terbaru (DESC) 
            // Lalu mengurutkan Semester secara DESC (Ganjil dulu baru Genap)
            'periode'  => $this->periodeModel->orderBy('tahun_akademik', 'DESC')
                                            ->orderBy('semester', 'DESC')
                                            ->findAll()
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
        $periode = $this->periodeModel->find($id);

        if (!$periode) {
            return redirect()->back()->with('error', 'Data periode tidak ditemukan.');
        }

        // 1. CEK STATUS AKTIF
        if ($periode['status_aktif'] == 1) {
            return redirect()->back()->with('error', 'Gagal! Periode AKTIF tidak boleh dihapus. Aktifkan periode lain terlebih dahulu.');
        }

        try {
            $db = \Config\Database::connect();
            $db->transBegin(); // Mulai transaksi database agar aman

            // 2. BERSIHKAN DATA TERKAIT (URUTAN PENTING)
            
            // Hapus Capaian Kinerja
            $db->table('kinerja_prodi_unit')->where('fk_setting_periode', $id)->delete();
            
            // Hapus Laporan Dokumen Monev
            $db->table('laporan_monev')->where('fk_setting_periode', $id)->delete();
            
            // Hapus Item Tagihan Monev
            $db->table('mMonev')->where('fk_setting_periode', $id)->delete();

            // 3. BARU HAPUS PERIODE UTAMA
            $this->periodeModel->delete($id);

            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Gagal menghapus data. Terjadi kesalahan pada database.');
            } else {
                $db->transCommit();
                return redirect()->back()->with('message', 'Periode dan seluruh data terkait (Laporan & Kinerja) berhasil dibersihkan.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}