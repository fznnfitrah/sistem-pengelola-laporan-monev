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

        // 1. Ambil ID Fakultas dari Session
        $idFakultas = session()->get('fk_fakultas');

        // 2. Filter Periode
        $periodeAktif = $periodeModel->where('status_aktif', 1)->first();
        $periodeId = $this->request->getGet('periode') ?: ($periodeAktif['id'] ?? null);

        // 3. Ambil Item Monev periode terpilih
        $tagihanMonev = $monevModel->where('fk_setting_periode', $periodeId)->findAll();

        // 4. Ambil Daftar Prodi khusus Fakultas ini
        $listProdi = $db->table('mProdi')->where('fk_fakultas', $idFakultas)->get()->getResultArray();

        // 5. Ambil semua laporan prodi pada periode ini
        $laporanMasuk = $laporanModel->where('fk_setting_periode', $periodeId)
                                     ->where('fk_fakultas', $idFakultas)
                                     ->where('fk_prodi !=', null)
                                     ->findAll();
        
        $statusLaporan = [];
        foreach ($laporanMasuk as $lp) {
            $key = 'PRO_' . trim($lp['fk_prodi']) . '_' . $lp['fk_monev'];
            $statusLaporan[$key] = $lp;
        }

        $data = [
            'title'           => 'Monitoring Progres Prodi',
            'periode'         => $periodeModel->findAll(),
            'selectedPeriode' => $periodeId,
            'tagihan'         => $tagihanMonev,
            'prodi'           => $listProdi,
            'statusLaporan'   => $statusLaporan
        ];

        return view('fakultas/monitoring/index', $data);
    }
}