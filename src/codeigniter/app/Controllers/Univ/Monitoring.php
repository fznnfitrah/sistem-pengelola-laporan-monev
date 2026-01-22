<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\LaporanMonevModel;
use App\Models\PeriodeModel;
use App\Models\MonevModel;

class Monitoring extends BaseController
{
    public function index()
    {
        $periodeModel = new \App\Models\PeriodeModel();
        $monevModel = new \App\Models\MonevModel();
        $laporanModel = new \App\Models\LaporanMonevModel();

        $periodeAktif = $periodeModel->where('status_aktif', 1)->first();
        $periodeId = $this->request->getGet('periode') ?: ($periodeAktif['id'] ?? null);

        $tagihanMonev = $monevModel->where('fk_setting_periode', $periodeId)->findAll();

        $db = \Config\Database::connect();
        $listFakultas = $db->table('mFakultas')->get()->getResultArray();
        $listUnit     = $db->table('mUnit')->get()->getResultArray(); // Ambil data Unit
        
        $laporanMasuk = $laporanModel->where('fk_setting_periode', $periodeId)->findAll();
        
        $statusLaporan = [];
        foreach ($laporanMasuk as $lp) {
            if ($lp['fk_prodi'] != null) {
                $key = 'PRO_' . trim($lp['fk_prodi']) . '_' . $lp['fk_monev'];
            } elseif ($lp['fk_unit'] != null) {
                $key = 'UNIT_' . trim($lp['fk_unit']) . '_' . $lp['fk_monev']; // Key untuk Unit
            } else {
                $key = 'FAK_' . trim($lp['fk_fakultas']) . '_' . $lp['fk_monev'];
            }
            $statusLaporan[$key] = $lp;
        }

        $data = [
            'title'           => 'Monitoring Progres Laporan',
            'periode'         => $periodeModel->findAll(),
            'selectedPeriode' => $periodeId,
            'tagihan'         => $tagihanMonev,
            'fakultas'        => $listFakultas,
            'unit'            => $listUnit,
            'statusLaporan'   => $statusLaporan,
            'db'              => $db 
        ];

        return view('univ/monitoring/index', $data);
    }
}