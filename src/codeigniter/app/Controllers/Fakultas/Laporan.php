<?php

namespace App\Controllers\Fakultas;

use App\Controllers\BaseController;
use App\Models\LaporanMonevModel;
use App\Models\MonevModel;
use App\Models\PeriodeModel;

class Laporan extends BaseController
{
    protected $laporanModel;
    protected $monevModel;
    protected $periodeModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanMonevModel();
        $this->monevModel = new MonevModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function input()
    {
        // 1. Ambil Periode Terpilih dari dropdown atau default yang aktif
        $periodeId = $this->request->getGet('periode');
        if (!$periodeId) {
            $aktif = $this->periodeModel->where('status_aktif', 1)->first();
            $periodeId = $aktif['id'] ?? null;
        }

        // 2. Ambil Tagihan Dokumen untuk periode tersebut
        $items = $this->monevModel->where('fk_setting_periode', $periodeId)->findAll();

        // 3. Ambil Laporan yang dikirim KHUSUS oleh Fakultas ini (Prodi harus NULL)
        $myFakultas = session()->get('fk_fakultas');
        $myLaporan = $this->laporanModel->where([
            'fk_fakultas'        => $myFakultas,
            'fk_setting_periode' => $periodeId,
            'fk_prodi'           => null, // PENTING: Filter agar laporan prodi tidak muncul di sini
            'fk_unit'            => null  // Tambahkan ini juga agar laporan unit tidak nyasar
        ])->findAll();

        // Map laporan ke ID Monev agar mudah dicek di View
        $sudahIsi = [];
        foreach ($myLaporan as $lp) {
            $sudahIsi[$lp['fk_monev']] = $lp;
        }

        $data = [
            'title'     => 'Input Laporan Monev',
            'periode'   => $this->periodeModel->findAll(),
            'selectedPeriode' => $periodeId,
            'items'     => $items,
            'laporan'   => $sudahIsi
        ];

        return view('fakultas/laporan/input_view', $data);
    }

    public function simpan()
    {
        // Ambil ID User dari session sesuai Auth.php kamu
        $userId = session()->get('current_user_id');

        $this->laporanModel->insert([
            'fk_fakultas'        => session()->get('fk_fakultas'),
            'fk_setting_periode' => $this->request->getPost('fk_setting_periode'),
            'fk_monev'           => $this->request->getPost('fk_monev'),
            'link_bukti'         => $this->request->getPost('link_bukti'),
            'keterangan'         => $this->request->getPost('keterangan'),
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil disimpan!');
    }

    public function history()
    {
        $kodeFakultas = session()->get('fk_fakultas');
        $data = [
            'title'   => 'History Laporan Monev',
            'history' => $this->laporanModel->getLaporanByFakultas($kodeFakultas)
        ];
        return view('fakultas/laporan/history_view', $data);
    }
}