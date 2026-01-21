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

    // public function input()
    // {
    //     // 1. Cek Periode Aktif
    //     $periodeAktif = $this->periodeModel->getActivePeriode();
    //     if (!$periodeAktif) return view('prodi/laporan/tutup_akses_view'); // Reuse view tutup akses

    //     // 2. Deteksi Role & Identitas User
    //     $isProdi = !empty(session()->get('fk_prodi')); // Cek apakah dia orang Prodi?

    //     $identitasID = null;
    //     $jenisKinerja = '';

    //     if ($isProdi) {
    //         $jenisKinerja = 'prodi';
    //         $identitasID  = session()->get('fk_prodi'); // String kode prodi
    //     } else {
    //         $jenisKinerja = 'unit';
    //         $identitasID  = session()->get('fk_unit');  // String kode unit
    //     }

    //     // 3. Ambil Master Kinerja SESUAI ROLE (Prodi cuma lihat 'prodi', Unit lihat 'unit')
    //     $daftarIndikator = $this->mKinerja->getKinerjaByJenis($jenisKinerja);

    //     // 4. Ambil Data yang SUDAH DIISI (agar form terisi nilai lama saat dibuka)
    //     // Query menyesuaikan apakah dia prodi atau unit
    //     $columnFilter = $isProdi ? 'fk_prodi' : 'fk_unit';

    //     $dataSudahIsi = $this->transaksiKinerja
    //         ->where($columnFilter, $identitasID)
    //         ->where('fk_setting_periode', $periodeAktif['id'])
    //         ->findAll();

    //     // Mapping agar mudah dipanggil di view: [id_kinerja => data_row]
    //     $mappedData = [];
    //     foreach ($dataSudahIsi as $d) {
    //         $mappedData[$d['fk_kinerja']] = $d;
    //     }

    //     $data = [
    //         'title'        => 'Input Kinerja ' . ucfirst($jenisKinerja),
    //         'periode'      => $periodeAktif,
    //         'indikator'    => $daftarIndikator, // Daftar Pertanyaan
    //         'sudah_isi'    => $mappedData,      // Jawaban User
    //         'is_prodi'     => $isProdi          // Flag untuk view
    //     ];

    //     return view('prodi/kinerja/input_kinerja_view', $data);
    // }

    public function index()
    {
        // 1. Ambil Semua Periode (Untuk Dropdown Filter)
        $semuaPeriode = $this->periodeModel->orderBy('tahun_akademik', 'DESC')
            ->orderBy('semester', 'DESC')
            ->findAll();

        // 2. Tentukan Periode Mana yang Sedang Dilihat
        $periodeID = $this->request->getGet('periode'); // Ambil dari URL ?periode=X

        if ($periodeID) {
            $periodeTerpilih = $this->periodeModel->find($periodeID);
        } else {
            // Default ke Periode Aktif jika baru buka
            $periodeTerpilih = $this->periodeModel->getActivePeriode();
        }

        if (!$periodeTerpilih) return view('prodi/laporan/tutup_akses_view');

        // 3. Deteksi Role & Identitas User
        $isProdi = !empty(session()->get('fk_prodi'));

        $identitasID = null;
        $jenisKinerja = '';

        if ($isProdi) {
            $jenisKinerja = 'prodi';
            // PENTING: Ambil string kode (misal "infor1") sesuai session Anda
            $identitasID  = session()->get('fk_prodi');
        } else {
            $jenisKinerja = 'unit';
            $identitasID  = session()->get('fk_unit');
        }

        // 4. Ambil Master Kinerja
        $daftarIndikator = $this->mKinerja->getKinerjaByJenis($jenisKinerja);

        // 5. Ambil Data yang SUDAH DIISI pada PERIODE TERPILIH
        $columnFilter = $isProdi ? 'fk_prodi' : 'fk_unit';

        $dataSudahIsi = $this->transaksiKinerja
            ->where($columnFilter, $identitasID)
            ->where('fk_setting_periode', $periodeTerpilih['id']) // <-- Filter ID Periode
            ->findAll();

        $mappedData = [];
        foreach ($dataSudahIsi as $d) {
            $mappedData[$d['fk_kinerja']] = $d;
        }

        $data = [
            'title'           => 'Input Kinerja ' . ucfirst($jenisKinerja),
            'semua_periode'   => $semuaPeriode,    // Data dropdown
            'periode'         => $periodeTerpilih, // Periode terpilih
            'indikator'       => $daftarIndikator,
            'sudah_isi'       => $mappedData,
            'is_prodi'        => $isProdi
        ];

        return view('prodi/kinerja/input_kinerja_view', $data);
    }

    public function save()
    {
        $periodeID = $this->request->getPost('fk_setting_periode');

        // Ambil input array dari form (karena inputnya banyak sekaligus)
        // Format input di View nanti: name="data[ID_KINERJA][value]"
        $inputs = $this->request->getPost('data');

        $isProdi = !empty(session()->get('fk_prodi'));
        $fk_prodi = $isProdi ? session()->get('fk_prodi') : null;
        $fk_unit  = !$isProdi ? session()->get('fk_unit') : null;
        $userID   = session()->get('current_user_id');

        foreach ($inputs as $idKinerja => $val) {
            // Cek apakah data sudah ada? (Upsert Logic)
            $existing = $this->transaksiKinerja
                ->where('fk_kinerja', $idKinerja)
                ->where('fk_setting_periode', $periodeID)
                ->groupStart() // Grouping OR query agar aman
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
                'value'              => $val['value'],      // Angka
                'link_bukti'         => $val['link_bukti'], // Link
                'keterangan'         => $val['keterangan']  // Text
            ];

            if ($existing) {
                // UPDATE: Pakai ID transaksi yang lama
                $dataSimpan['id'] = $existing['id'];
                $this->transaksiKinerja->save($dataSimpan);
            } else {
                // INSERT BARU: Hanya simpan jika value tidak kosong (opsional)
                if (!empty($val['value']) || !empty($val['link_bukti'])) {
                    $this->transaksiKinerja->insert($dataSimpan);
                }
            }
        }

        return redirect()->to('prodi/kinerja/input')->with('message', 'Data Kinerja berhasil disimpan!');
    }
}
