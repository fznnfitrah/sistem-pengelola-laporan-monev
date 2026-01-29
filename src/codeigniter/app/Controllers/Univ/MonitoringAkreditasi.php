<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\AkreditasiModel;

class MonitoringAkreditasi extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AkreditasiModel();
    }

    public function index()
    {
        $allData = $this->model->getLatestAkreditasiAll();

        $groupedData = [];
        $stats = [
            'total_prodi' => count($allData),
            'kadaluarsa'  => 0,
            'akan_habis'  => 0
        ];

        foreach ($allData as $row) {
            $fakultasName = $row['nama_fakultas'];
            $groupedData[$fakultasName][] = $row;

            // PERBAIKAN DI SINI: Hilangkan spasi pada nama variabel
            $kadaluarsa = strtotime($row['tgl_kadaluarsa']);
            $enamBulanLagi = strtotime("+6 months");

            if ($kadaluarsa < time()) {
                $stats['kadaluarsa']++;
            } elseif ($kadaluarsa < $enamBulanLagi) {
                $stats['akan_habis']++;
            }
        }

        $data = [
            'title'       => 'Monitoring Akreditasi Prodi',
            'groupedData' => $groupedData,
            'stats'       => $stats,
            'allData'     => $allData // Untuk keperluan Modal Detail
        ];

        return view('univ/monitoring/akreditasi_view', $data);
    }
}
