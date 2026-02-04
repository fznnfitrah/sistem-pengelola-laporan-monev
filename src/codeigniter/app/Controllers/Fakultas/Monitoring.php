<?php

namespace App\Controllers\Fakultas;

use App\Controllers\BaseController;
use App\Models\LaporanMonevModel;
use App\Models\PeriodeModel;
use App\Models\MonevModel;
use App\Models\ProdiModel;

class Monitoring extends BaseController
{
    public function index()
    {
        $periodeModel = new PeriodeModel();
        $monevModel = new MonevModel();
        $laporanModel = new LaporanMonevModel();
        $prodiModel = new ProdiModel();
        $db = \Config\Database::connect();

        $idFakultas = session()->get('fk_fakultas');

        $periodeAktif = $periodeModel->where('status_aktif', 1)->first();
        $periodeId = $this->request->getGet('periode') ?: ($periodeAktif['id'] ?? null);

        $tagihanMonev = $monevModel->where('fk_setting_periode', $periodeId)->findAll();

        $listProdi = $prodiModel->getProdiByFakultas($idFakultas);

        $prodiIds = array_column($listProdi, 'id');

        $statusLaporan = [];
        if (!empty($prodiIds)) {
            $laporanMasuk = $laporanModel->where('fk_setting_periode', $periodeId)
                ->whereIn('fk_prodi', $prodiIds)
                ->findAll();

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
