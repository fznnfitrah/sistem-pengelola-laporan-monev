<?php

namespace App\Controllers\Prodi;

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
        // 1. Ambil Semua Periode untuk Dropdown Filter
        $semuaPeriode = $this->periodeModel->orderBy('tahun_akademik', 'DESC')
            ->orderBy('semester', 'DESC')
            ->findAll();

        // 2. Tentukan Periode Mana yang Sedang Dilihat (Filter GET)
        $periodeID = $this->request->getGet('periode');

        if ($periodeID) {
            $periodeTerpilih = $this->periodeModel->find($periodeID);
        } else {
            // Default ke Periode Aktif
            $periodeTerpilih = $this->periodeModel->getActivePeriode();
        }

        // Jika tidak ada periode sama sekali, arahkan ke halaman tutup akses
        if (!$periodeTerpilih) {
            return view('prodi/laporan/tutup_akses_view', ['title' => 'Akses Tertutup']);
        }

        // 3. Deteksi Role User (Prodi atau Unit) dari Session
        $isProdi = !empty(session()->get('fk_prodi'));
        $identitasID = $isProdi ? session()->get('fk_prodi') : session()->get('fk_unit');
        $jenisKinerja = $isProdi ? 'prodi' : 'unit';

        // 4. Ambil Indikator Kinerja yang AKTIF (Status = 1)
        // Fungsi getKinerjaByJenis sudah kita update di Model sebelumnya
        $daftarIndikator = $this->mKinerja->getKinerjaByJenis($jenisKinerja);

        // 5. Ambil Data Capaian yang sudah diisi pada Periode Terpilih
        $columnFilter = $isProdi ? 'fk_prodi' : 'fk_unit';
        $dataSudahIsi = $this->transaksiKinerja
            ->where($columnFilter, $identitasID)
            ->where('fk_setting_periode', $periodeTerpilih['id'])
            ->findAll();

        // Mapping data agar mudah dipanggil berdasarkan ID Kinerja di View
        $mappedData = [];
        foreach ($dataSudahIsi as $d) {
            $mappedData[$d['fk_kinerja']] = $d;
        }

        // Ambil status "edit_mode" dari URL, defaultnya false (terkunci)
        $editMode = $this->request->getGet('mode') == 'edit';

        $data = [
            'title'           => 'Input Capaian Kinerja ' . ucfirst($jenisKinerja),
            'semua_periode'   => $semuaPeriode,
            'periode'         => $periodeTerpilih,
            'indikator'       => $daftarIndikator,
            'sudah_isi'       => $mappedData,
            'is_prodi'        => $isProdi,
            'editMode'        => $editMode, // Kirim status mode ke view
            'hasData'         => !empty($mappedData) // Cek apakah sudah pernah isi
        ];

        return view('prodi/kinerja/input_kinerja_view', $data);
    }

    public function save()
    {
        // Ambil ID Periode dari form agar data tersimpan di periode yang tepat
        $periodeID = $this->request->getPost('fk_setting_periode');
        $inputs    = $this->request->getPost('data'); // Mengambil array data kinerja

        $isProdi  = !empty(session()->get('fk_prodi'));
        $fk_prodi = $isProdi ? session()->get('fk_prodi') : null;
        $fk_unit  = !$isProdi ? session()->get('fk_unit') : null;
        $userID   = session()->get('current_user_id');

        // Loop setiap indikator yang diinputkan
        if ($inputs) {
            foreach ($inputs as $idKinerja => $val) {
                
                // Lewati jika nilai (value) kosong untuk menghindari baris sampah di DB
                if (empty($val['value']) && empty($val['link_bukti'])) continue;

                // Logika Upsert: Cek apakah data sudah ada sebelumnya di periode ini
                $existing = $this->transaksiKinerja
                    ->where('fk_kinerja', $idKinerja)
                    ->where('fk_setting_periode', $periodeID)
                    ->groupStart()
                        ->where('fk_prodi', $fk_prodi)
                        ->orWhere('fk_unit', $fk_unit)
                    ->groupEnd()
                    ->first();

                $dataSimpan = [
                    'fk_kinerja'         => $idKinerja,
                    'fk_setting_periode' => $periodeID,
                    'fk_prodi'           => $fk_prodi,
                    'fk_unit'            => $fk_unit,
                    'fk_user'            => $userID,
                    'value'              => (int) $val['value'],
                    'link_bukti'         => $val['link_bukti'],
                    'keterangan'         => $val['keterangan']
                ];

                if ($existing) {
                    // Update data yang sudah ada
                    $this->transaksiKinerja->update($existing['id'], $dataSimpan);
                } else {
                    // Insert data baru
                    $this->transaksiKinerja->insert($dataSimpan);
                }
            }
        }

        return redirect()->to("prodi/kinerja/input?periode=$periodeID")
            ->with('message', 'Capaian Kinerja berhasil disimpan!');
    }
}