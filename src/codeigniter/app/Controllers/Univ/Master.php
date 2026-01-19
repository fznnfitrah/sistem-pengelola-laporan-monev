<?php
namespace App\Controllers\Univ;
use App\Controllers\BaseController;
use App\Models\FakultasModel;
use App\Models\ProdiModel;

class Master extends BaseController {
    protected $fakultasModel;
    protected $prodiModel;

    public function __construct() {
        $this->fakultasModel = new FakultasModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index() {
        $data = [
            'title'    => 'Pengaturan Organisasi',
            'username' => session()->get('username'),
            'mfakultas' => $this->fakultasModel->findAll(),
            'prodi'    => $this->prodiModel->select('mProdi.*, mFakultas.nama_fakultas')
                                     ->join('mFakultas', 'mFakultas.id = mProdi.fk_fakultas')
                                     ->findAll()
        ];
        return view('univ/master/index', $data);
    }

    // --- LOGIKA FAKULTAS ---

    public function simpanFakultas() {
        $this->fakultasModel->insert([
            'id'            => strtoupper($this->request->getPost('id')),
            'nama_fakultas' => $this->request->getPost('nama_fakultas')
        ]);
        return redirect()->back()->with('success', 'Fakultas baru berhasil ditambahkan!');
    }

    public function editFakultas() {
        $id_lama = $this->request->getPost('id_lama');
        $data = [
            'id'            => strtoupper($this->request->getPost('id')),
            'nama_fakultas' => $this->request->getPost('nama_fakultas')
        ];
        $this->fakultasModel->update($id_lama, $data);
        return redirect()->back()->with('success', 'Data Fakultas berhasil diperbarui!');
    }

    public function hapusFakultas($id) {
        $this->fakultasModel->delete($id);
        return redirect()->back()->with('success', 'Fakultas berhasil dihapus!');
    }

    // --- LOGIKA PRODI ---

    public function simpanProdi() {
        $this->prodiModel->insert([
            'id'          => strtoupper($this->request->getPost('id')),
            'fk_fakultas' => $this->request->getPost('fk_fakultas'),
            'nama_prodi'  => $this->request->getPost('nama_prodi')
        ]);
        return redirect()->back()->with('success', 'Program Studi baru berhasil ditambahkan!');
    }

    public function editProdi() {
        $id_lama = $this->request->getPost('id_lama');
        $data = [
            'id'          => strtoupper($this->request->getPost('id')),
            'fk_fakultas' => $this->request->getPost('fk_fakultas'),
            'nama_prodi'  => $this->request->getPost('nama_prodi')
        ];
        $this->prodiModel->update($id_lama, $data);
        return redirect()->back()->with('success', 'Data Program Studi berhasil diperbarui!');
    }

    public function hapusProdi($id) {
        $this->prodiModel->delete($id);
        return redirect()->back()->with('success', 'Program Studi berhasil dihapus!');
    }
}