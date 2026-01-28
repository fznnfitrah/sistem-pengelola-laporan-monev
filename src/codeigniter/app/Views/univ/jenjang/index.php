<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Master Jenjang</h2>
            <p class="text-muted small">Kelola data jenjang pendidikan program studi (S1, S2, S3, Profesi).</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah" style="border-radius: 10px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jenjang
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="10%">No</th>
                            <th width="30%">Nama Jenjang</th>
                            <th>Keterangan</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($jenjang as $j): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td class="fw-bold text-dark"><?= esc($j['jenjang']) ?></td>
                            <td><?= esc($j['keterangan']) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-warning border-0" 
                                    onclick="editJenjang('<?= $j['id'] ?>', '<?= esc($j['jenjang']) ?>', '<?= esc($j['keterangan']) ?>')"
                                    data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= base_url('univ/jenjang/hapus/'.$j['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus data jenjang ini?')">
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
            <form action="<?= base_url('univ/jenjang/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold text-success">Tambah Jenjang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA JENJANG</label>
                        <input type="text" name="jenjang" class="form-control border-2" placeholder="Contoh: S1" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">KETERANGAN</label>
                        <textarea name="keterangan" class="form-control border-2" rows="3" placeholder="Contoh: Sarjana" style="border-radius: 10px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm" style="border-radius: 12px;">Simpan Jenjang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/jenjang/edit') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4 text-warning">
                    <h5 class="fw-bold">Edit Data Jenjang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA JENJANG</label>
                        <input type="text" name="jenjang" id="edit_jenjang" class="form-control border-2" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">KETERANGAN</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control border-2" rows="3" style="border-radius: 10px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-warning text-white w-100 py-2 fw-bold shadow-sm" style="border-radius: 12px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editJenjang(id, jenjang, keterangan) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_jenjang').value = jenjang;
        document.getElementById('edit_keterangan').value = keterangan;
    }
</script>

<?= $this->endSection() ?>