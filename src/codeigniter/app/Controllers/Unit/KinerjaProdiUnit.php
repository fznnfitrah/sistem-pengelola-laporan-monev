<?php

namespace App\Controllers\Unit;

use App\Controllers\BaseController;
use App\Models\KinerjaModel;
use App\Models\KinerjaProdiUnitModel;
use App\Models\PeriodeModel;

class KinerjaProdiUnit extends BaseController
{
    protected $mKinerja;
    protected $transaksiKinerja;
    protected $periodeModel;

    public function __construct()
    {
        $this->mKinerja = new KinerjaModel();
        $this->transaksiKinerja = new KinerjaProdiUnitModel();
        $this->periodeModel = new PeriodeModel();
    }

    public function index()
    {
        $semuaPeriode = $this->periodeModel->orderBy('tahun_akademik', 'DESC')
            ->orderBy('semester', 'DESC')
            ->findAll();

        $periodeID = $this->request->getGet('periode');
        $editMode = $this->request->getGet('mode') == 'edit'; // Mode Edit

        if ($periodeID) {
            $periodeTerpilih = $this->periodeModel->find($periodeID);
        } else {
            $periodeTerpilih = $this->periodeModel->getActivePeriode();
        }

        if (!$periodeTerpilih) return view('unit/laporan/tutup_akses_view');

        $isUnit = !empty(session()->get('fk_unit'));
        $identitasID = session()->get('fk_unit');
        $jenisKinerja = 'unit'; // Khusus role Unit

        // Ambil Indikator yang statusnya Aktif
        $daftarIndikator = $this->mKinerja->getKinerjaByJenis($jenisKinerja);

        $dataSudahIsi = $this->transaksiKinerja
            ->where('fk_unit', $identitasID)
            ->where('fk_setting_periode', $periodeTerpilih['id'])
            ->findAll();

        $mappedData = [];
        foreach ($dataSudahIsi as $d) {
            $mappedData[$d['fk_kinerja']] = $d;
        }

        $data = [
            'title'           => 'Input Kinerja Unit',
            'semua_periode'   => $semuaPeriode,
            'periode'         => $periodeTerpilih,
            'indikator'       => $daftarIndikator,
            'sudah_isi'       => $mappedData,
            'is_unit'         => $isUnit,
            'editMode'        => $editMode,
            'hasData'         => !empty($mappedData)
        ];

        return view('unit/kinerja/input_kinerja_view', $data);
    }

    public function save()
    {
        $periodeID = $this->request->getPost('fk_setting_periode');
        $inputs = $this->request->getPost('data');
        $fk_unit = session()->get('fk_unit');
        $userID = session()->get('current_user_id');

        if ($inputs) {
            foreach ($inputs as $idKinerja => $val) {
                $existing = $this->transaksiKinerja
                    ->where('fk_kinerja', $idKinerja)
                    ->where('fk_setting_periode', $periodeID)
                    ->where('fk_unit', $fk_unit)
                    ->first();

                $dataSimpan = [
                    'fk_kinerja'         => $idKinerja,
                    'fk_setting_periode' => $periodeID,
                    'fk_prodi'           => null,
                    'fk_unit'            => $fk_unit,
                    'fk_user'            => $userID,
                    'value'              => (int) $val['value'],
                    'link_bukti'         => $val['link_bukti'],
                    'keterangan'         => $val['keterangan']
                ];

                if ($existing) {
                    $this->transaksiKinerja->update($existing['id'], $dataSimpan);
                } else {
                    if (!empty($val['value']) || !empty($val['link_bukti'])) {
                        $this->transaksiKinerja->insert($dataSimpan);
                    }
                }
            }
        }

        return redirect()->to("unit/kinerja/input?periode=$periodeID")->with('message', 'Data Kinerja Unit berhasil disimpan!');
    }
}