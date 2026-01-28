<?php

namespace App\Controllers\Fakultas;

use App\Controllers\BaseController;
use App\Models\LaporanMonevModel;
use App\Models\PeriodeModel;
use App\Models\MonevModel;

class Monitoring extends BaseController
{
    public function index()
    {
        $periodeModel = new PeriodeModel();
        $monevModel = new MonevModel();
        $laporanModel = new LaporanMonevModel();
        $db = \Config\Database::connect();

        // 1. Ambil ID Fakultas dari Session user yang login
        $idFakultas = session()->get('fk_fakultas');

        // 2. Tentukan Periode (Default ke periode aktif jika tidak ada filter)
        $periodeAktif = $periodeModel->where('status_aktif', 1)->first();
        $periodeId = $this->request->getGet('periode') ?: ($periodeAktif['id'] ?? null);

        // 3. Ambil Item Monev (Header Tabel) untuk periode terpilih
        $tagihanMonev = $monevModel->where('fk_setting_periode', $periodeId)->findAll();

        // 4. Ambil Daftar Prodi yang terdaftar di Fakultas ini
        $listProdi = $db->table('mProdi')->where('fk_fakultas', $idFakultas)->get()->getResultArray();
        
        // Ambil semua ID prodi untuk filter laporan
        $prodiIds = array_column($listProdi, 'id');

        // 5. Ambil data laporan masuk
        $statusLaporan = [];
        if (!empty($prodiIds)) {
            $laporanMasuk = $laporanModel->where('fk_setting_periode', $periodeId)
                                         ->whereIn('fk_prodi', $prodiIds) // Filter berdasarkan prodi fakultas ini
                                         ->findAll();
            
            // Mapping data agar mudah dipanggil di View
            foreach ($laporanMasuk as $lp) {
                $key = 'PRO_' . trim($lp['fk_prodi']) . '_' . $lp['fk_monev'];
                $statusLaporan[$key] = $lp;
            }
        }

        $data = [
            'title'           => 'Monitoring Progres Prodi',
            'semua_periode'   => $periodeModel->findAll(), // Untuk dropdown filter
            'selectedPeriode' => $periodeId,
            'tagihan'         => $tagihanMonev,
            'prodi'           => $listProdi,
            'statusLaporan'   => $statusLaporan
        ];

        return view('fakultas/monitoring/index', $data);
    }
}