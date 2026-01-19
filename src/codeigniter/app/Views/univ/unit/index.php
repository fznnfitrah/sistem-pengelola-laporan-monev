<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<style>
    .card-unit { border: none; border-radius: 15px; transition: 0.3s; }
    .table thead th { background-color: #f8f9fa; color: #495057; font-weight: 600; }
    .btn-rounded { border-radius: 10px; padding: 8px 20px; }
    .badge-id { font-family: 'Courier New', Courier, monospace; letter-spacing: 1px; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Unit & Lembaga</h2>
            <p class="text-muted">Kelola daftar unit kerja non-akademik (Contoh: LPPM, Perpustakaan)</p>
        </div>
        <div>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success border-0 shadow-sm py-2 px-4 mb-0 animate__animated animate__fadeIn">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card card-unit shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="bi bi-building-gear me-2 text-success"></i>Daftar Unit</h5>
            <button class="btn btn-success btn-sm btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg me-1"></i> Tambah Unit
            </button>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="20%">Kode Unit</th>
                            <th>Nama Unit / Lembaga</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($mUnit as $u): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border badge-id"><?= $u['id'] ?></span></td>
                            <td class="fw-semibold text-secondary"><?= $u['nama_unit'] ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning border-0" onclick="btnEdit('<?= $u['id'] ?>', '<?= $u['nama_unit'] ?>')" data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= base_url('univ/unit/hapus/'.$u['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus unit <?= $u['nama_unit'] ?>?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/unit/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold text-success">Tambah Unit Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KODE UNIT (ID)</label>
                        <input type="text" name="id" class="form-control border-2" placeholder="Contoh: LPPM, PERPUS" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA UNIT</label>
                        <input type="text" name="nama_unit" class="form-control border-2" placeholder="Masukkan nama lengkap unit" required style="border-radius: 12px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success btn-rounded px-4">Simpan Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/unit/edit') ?>" method="post">
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-4 text-warning">Edit Data Unit</h5>
                    <input type="hidden" name="id_lama" id="e_id_lama">
                    <div class="mb-3">
                        <label class="small fw-bold">KODE UNIT</label>
                        <input type="text" name="id" id="e_id" class="form-control border-2" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">NAMA UNIT</label>
                        <input type="text" name="nama_unit" id="e_nama" class="form-control border-2" required style="border-radius: 12px;">
                    </div>
                    <button type="submit" class="btn btn-warning w-100 btn-rounded text-white mt-2">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function btnEdit(id, nama) {
        document.getElementById('e_id_lama').value = id;
        document.getElementById('e_id').value = id;
        document.getElementById('e_nama').value = nama;
    }
</script>
<?= $this->endSection() ?>