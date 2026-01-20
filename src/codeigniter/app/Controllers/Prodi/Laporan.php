<?php

namespace App\Controllers\Prodi;

use App\Controllers\BaseController;
use App\Models\LaporanMonevModel;
use App\Models\MonevModel;
use App\Models\PeriodeModel;

class Laporan extends BaseController
{
    protected $monevModel;
    protected $laporanMonevModel;
    protected $periodeModel;
    public function __construct()
    {
        $this->monevModel = new MonevModel();
        $this->laporanMonevModel = new LaporanMonevModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function history()
    {
        $data = [
            'title' => 'History Laporan Monev',
            'laporan' => $this->laporanMonevModel->getLaporanByProdi(session()->get('prodi_id'))
        ];

        return view('prodi/laporan/history_lmonev_view', $data);
    }
}
