<?php

namespace App\Controllers\Unit;

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
        $kodeUnit = session()->get('fk_unit');

        if (empty($kodeUnit)) {
            return redirect()->to('/login');
        }

        $data = [
            'title'   => 'Riwayat Laporan Monev',
            'laporan' => $this->laporanMonevModel->getLaporanByUnit($kodeUnit)
        ];

        return view('unit/laporan/history_lmonev_view', $data);
    }

    public function input()
    {
        // 1. Ambil Semua Periode 
        $semuaPeriode = $this->periodeModel->orderBy('tahun_akademik', 'DESC')
            ->orderBy('semester', 'DESC')
            ->findAll();

        // 2. Tentukan Periode Mana yang Sedang Dilihat
        $periodeID = $this->request->getGet('periode');

        $periodeTerpilih = null;

        if ($periodeID) {
            $periodeTerpilih = $this->periodeModel->find($periodeID);
        } else {
            $periodeTerpilih = $this->periodeModel->getActivePeriode();
        }

        // 3. Jika tidak ada periode sama sekali, tampilkan halaman tutup akses
        if (!$periodeTerpilih) {
            return view('unit/laporan/tutup_akses_view', ['title' => 'Belum Ada Periode']);
        }

        $unitID = session()->get('fk_unit');

        // 4. Ambil Daftar Monev sesuai PERIODE YANG DIPILIH
        $daftarMonev = $this->monevModel->where('fk_setting_periode', $periodeTerpilih['id'])
            ->where('status', 1)
            ->findAll();

        // 5. Ambil Laporan yang SUDAH dikirim di PERIODE YANG DIPILIH
        $laporanSudahMasuk = $this->laporanMonevModel->where('fk_unit', $unitID)
            ->where('fk_setting_periode', $periodeTerpilih['id'])
            ->findAll();

        $laporanMapped = [];
        foreach ($laporanSudahMasuk as $lap) {
            $laporanMapped[$lap['fk_monev']] = $lap;
        }

        $data = [
            'title'           => 'Input Laporan Monev',
            'semua_periode'   => $semuaPeriode,
            'periode_pilih'   => $periodeTerpilih,
            'daftar_monev'    => $daftarMonev,
            'laporan_unit'   => $laporanMapped,
            'validation'      => \Config\Services::validation()
        ];

        return view('unit/laporan/input_lmonev_view', $data);
    }

    public function save()
    {
        $unitID = session()->get('fk_unit');

        $periodeAktif = $this->periodeModel->getActivePeriode();

        if (!$this->validate([
            'fk_monev'   => 'required',
            'link_bukti' => 'required|valid_url',
            'keterangan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $periodeID = $this->request->getPost('fk_setting_periode');

        $this->laporanMonevModel->save([
            'fk_prodi'           => null,
            'fk_unit'            => $unitID,
            'fk_setting_periode' => $periodeID, // Gunakan ID dari form
            'fk_monev'           => $this->request->getPost('fk_monev'),
            'link_bukti'         => $this->request->getPost('link_bukti'),
            'keterangan'         => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to("unit/laporan/input?periode=$periodeID")
            ->with('message', 'Laporan berhasil dikirim!');
    }
}
