<?php

namespace App\Controllers\Univ;

use App\Controllers\BaseController;
use App\Models\FakultasModel;
use App\Models\ProdiModel;
use App\Models\JenjangModel;

class Master extends BaseController
{
    protected $fakultasModel;
    protected $prodiModel;
    protected $jenjangModel;

    public function __construct()
    {
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
        $this->jenjangModel = new JenjangModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Pengaturan Organisasi',
            'username'   => session()->get('username'),
            'mfakultas'  => $this->fakultasModel->findAll(),
            'mjenjang'    => $this->jenjangModel->findAll(),
            'prodi'      => $this->prodiModel
                ->select('mProdi.*, mFakultas.nama_fakultas, mJenjang.jenjang') // Ambil nama_jenjang
                ->join('mFakultas', 'mFakultas.id = mProdi.fk_fakultas')
                ->join('mJenjang', 'mJenjang.id = mProdi.fk_jenjang', 'left') // Left join agar jika null tidak error
                ->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('univ/master/index', $data);
    }

    // --- LOGIKA FAKULTAS ---

    public function simpanFakultas()
    {
        // 1. Validasi
        if (!$this->validate([
            'id' => [
                'rules'  => 'required|is_unique[mFakultas.id]',
                'errors' => [
                    'required'  => 'Kode Fakultas wajib diisi.',
                    'is_unique' => 'Gagal! Kode Fakultas tersebut sudah terdaftar.'
                ]
            ],
            'nama_fakultas' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama Fakultas wajib diisi.']
            ]
        ])) {
            // Mengirim 'errors' sebagai array agar mudah dibaca di view
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->fakultasModel->insert([
                'id'            => strtoupper($this->request->getPost('id')),
                'nama_fakultas' => $this->request->getPost('nama_fakultas')
            ]);
            return redirect()->back()->with('success', 'Fakultas baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => 'Terjadi kesalahan sistem: Data mungkin duplikat (Error 1062).']);
        }
    }

    public function editFakultas()
    {
        $id_lama = $this->request->getPost('id_lama');
        $id_baru = strtoupper($this->request->getPost('id'));

        // Cek manual jika ID berubah
        if ($id_lama != $id_baru) {
            $cek = $this->fakultasModel->find($id_baru);
            if ($cek) {
                return redirect()->back()->withInput()->with('errors', ['id' => 'Gagal Update! ID Fakultas sudah digunakan oleh data lain.']);
            }
        }

        try {
            $data = [
                'id'            => $id_baru,
                'nama_fakultas' => $this->request->getPost('nama_fakultas')
            ];
            $this->fakultasModel->update($id_lama, $data);
            return redirect()->back()->with('success', 'Data Fakultas berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal update database.']);
        }
    }

    public function hapusFakultas($id)
    {
        try {
            $this->fakultasModel->delete($id);
            return redirect()->back()->with('success', 'Fakultas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', ['fk' => 'Gagal menghapus! Fakultas ini mungkin masih memiliki Prodi terkait.']);
        }
    }

    // --- LOGIKA PRODI ---

    public function simpanProdi()
    {
        // 1. Validasi
        if (!$this->validate([
            'id' => [
                'rules'  => 'required|is_unique[mProdi.id]',
                'errors' => [
                    'required'  => 'Kode Prodi wajib diisi.',
                    'is_unique' => 'Gagal! Kode Prodi tersebut sudah terdaftar.'
                ]
            ],
            'nama_prodi' => ['rules' => 'required', 'errors' => ['required' => 'Nama Prodi wajib diisi.']],
            'fk_fakultas' => ['rules' => 'required', 'errors' => ['required' => 'Fakultas wajib dipilih.']]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->prodiModel->insert([
                'id'          => strtoupper($this->request->getPost('id')),
                'fk_fakultas' => $this->request->getPost('fk_fakultas'),
                'nama_prodi'  => $this->request->getPost('nama_prodi'),

                'fk_jenjang'       => $this->request->getPost('fk_jenjang'),
                'no_sk_pendirian'  => $this->request->getPost('no_sk_pendirian'),
                'tgl_sk_pendirian' => $this->request->getPost('tgl_sk_pendirian'),
            ]);
            return redirect()->back()->with('success', 'Program Studi baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => 'Terjadi kesalahan saat menyimpan data Prodi.']);
        }
    }

    public function editProdi()
    {
        $id_lama = $this->request->getPost('id_lama');

        // Logika update sederhana
        try {
            $data = [
                'id'          => strtoupper($this->request->getPost('id')),
                'fk_fakultas' => $this->request->getPost('fk_fakultas'),
                'nama_prodi'  => $this->request->getPost('nama_prodi'),

                'fk_jenjang'       => $this->request->getPost('fk_jenjang'),
                'no_sk_pendirian'  => $this->request->getPost('no_sk_pendirian'),
                'tgl_sk_pendirian' => $this->request->getPost('tgl_sk_pendirian'),
            ];
            // Catatan: Jika mengubah ID menjadi ID yang sudah ada, akan error di sini.
            // Sebaiknya tambahkan validasi unik manual seperti di editFakultas jika perlu.
            $this->prodiModel->update($id_lama, $data);
            return redirect()->back()->with('success', 'Data Program Studi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => 'Gagal Update: ID mungkin duplikat.']);
        }
    }

    public function hapusProdi($id)
    {
        $this->prodiModel->delete($id);
        return redirect()->back()->with('success', 'Program Studi berhasil dihapus!');
    }
}
