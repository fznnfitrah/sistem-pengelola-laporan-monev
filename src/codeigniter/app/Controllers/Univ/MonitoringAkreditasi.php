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

            $kadaluarsa = strtotime($row['tgl_kadaluarsa']);
            $enamBulanLagi = strtotime("+6 months");

            if ($kadaluarsa < time()) {
                $stats['kadaluarsa']++;
            } elseif ($kadaluarsa < $enamBulanLagi) {
                $stats['akan_habis']++;
            }
        }

        return view('univ/monitoring/akreditasi_view', [
            'title'       => 'Monitoring Akreditasi Prodi',
            'groupedData' => $groupedData,
            'stats'       => $stats,
            'rekap'       => $allData,
            'allData'     => $allData 
        ]);
    }

    public function rekap()
    {
        $allData = $this->model->getRekapSemuaProdi();
        $rekapData = [];

        // Inisialisasi hitungan untuk tabel tabulasi
        $tabulasi = [
            'A' => 0, 'B' => 0, 'C' => 0, 
            'Unggul' => 0, 'Baik Sekali' => 0, 'Baik' => 0, 
            'Belum Terakreditasi' => 0
        ];

        foreach ($allData as $row) {
            $row['sisa_bulan'] = '-';
            $row['tgl_persiapan'] = '-';
            $row['akre_internasional'] = '-';

            // 1. Logika Akreditasi Internasional
            if ($row['jenis_lembaga'] == 'Internasional') {
                $row['akre_internasional'] = 'Ya';
            }

            // 2. Hitung Tanggal & Sisa Bulan
            if (!empty($row['tgl_kadaluarsa']) && $row['tgl_kadaluarsa'] != '0000-00-00') {
                $tglKadaluarsa = new \DateTime($row['tgl_kadaluarsa']);
                $sekarang = new \DateTime();
                $diff = $sekarang->diff($tglKadaluarsa);
                $totalBulan = ($diff->y * 12) + $diff->m;
                if ($tglKadaluarsa < $sekarang) $totalBulan *= -1;
                
                $row['sisa_bulan'] = $totalBulan;

                $tglPersiapan = clone $tglKadaluarsa;
                $tglPersiapan->modify('-6 months');
                $row['tgl_persiapan'] = $tglPersiapan->format('d-M-y');
            }

            // 3. Hitung Tabulasi Statistik
            $p = $row['peringkat'];
            if (empty($p) || $p == '-') {
                $tabulasi['Belum Terakreditasi']++;
            } elseif (isset($tabulasi[$p])) {
                $tabulasi[$p]++;
            }

            $rekapData[] = $row; // Masukkan ke array satu kali saja agar tidak duplikat
        }

        return view('univ/monitoring/rekap_akreditasi_view', [
            'title'      => 'Rekap Report Akreditasi',
            'rekap'      => $rekapData,
            'tabulasi'   => $tabulasi,
            'total'      => count($allData),
            'tgl_update' => date('d F Y') // Update harian otomatis
        ]);
    }
}