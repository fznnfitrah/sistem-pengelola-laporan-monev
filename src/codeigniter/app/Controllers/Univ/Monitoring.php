<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\LaporanMonevModel;
use App\Models\PeriodeModel;
use App\Models\MonevModel;
use App\Models\ProdiModel;

class Monitoring extends BaseController
{
    // Deklarasi properti agar rapi
    protected $periodeModel;
    protected $monevModel;
    protected $laporanModel;
    protected $prodiModel;
    protected $db;

    public function __construct()
    {
        $this->periodeModel = new PeriodeModel();
        $this->prodiModel   = new ProdiModel();
        $this->monevModel   = new MonevModel();
        $this->laporanModel = new LaporanMonevModel();
        $this->db           = \Config\Database::connect();
    }

    public function index()
    {
        $periodeAktif = $this->periodeModel->where('status_aktif', 1)->first();
        $periodeId    = $this->request->getGet('periode') ?: ($periodeAktif['id'] ?? null);

        $listFakultas = $this->db->table('mFakultas')->orderBy('nama_fakultas', 'ASC')->get()->getResultArray();
        $listUnit     = $this->db->table('mUnit')->orderBy('nama_unit', 'ASC')->get()->getResultArray();

        $rawProdi = $this->prodiModel->getProdiLengkap();

        $groupedProdi = [];
        foreach ($rawProdi as $p) {
            $fakId = $p['fk_fakultas'];
            $groupedProdi[$fakId][] = $p;
        }

        // E. Ambil Status Laporan (Sudah/Belum)
        $tagihanMonev = $this->monevModel->where('fk_setting_periode', $periodeId)->findAll();
        $laporanMasuk = $this->laporanModel->where('fk_setting_periode', $periodeId)->findAll();
        
        $statusLaporan = [];
        foreach ($laporanMasuk as $lp) {
            if ($lp['fk_prodi'] != null) {
                $key = 'PRO_' . trim($lp['fk_prodi']) . '_' . $lp['fk_monev'];
            } elseif ($lp['fk_unit'] != null) {
                $key = 'UNIT_' . trim($lp['fk_unit']) . '_' . $lp['fk_monev'];
            } else {
                $key = 'FAK_' . trim($lp['fk_fakultas']) . '_' . $lp['fk_monev'];
            }
            $statusLaporan[$key] = $lp;
        }

        // F. Kirim Data ke View
        $data = [
            'title'           => 'Monitoring Progres Laporan',
            'periode'         => $this->periodeModel->orderBy('tahun_akademik', 'DESC')->findAll(),
            'selectedPeriode' => $periodeId,
            'tagihan'         => $tagihanMonev,
            
            'fakultas'        => $listFakultas,
            'unit'            => $listUnit,
            
            'groupedProdi'    => $groupedProdi, 
            
            'statusLaporan'   => $statusLaporan,
            
        ];

        return view('univ/monitoring/index', $data);
    }
}