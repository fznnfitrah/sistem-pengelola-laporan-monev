<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Master Item Monev Per Periode</h2>
            <p class="text-muted">Atur dokumen wajib berdasarkan periode semester yang aktif.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-file-earmark-plus me-1"></i> Tambah Item
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Nama Item Monev</th>
                            <th>Keterangan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($monev as $m): ?>
                        <tr>
                            <td>
                                <span class="badge bg-light text-primary border">
                                    <?= $m['tahun_akademik'] ?> - <?= $m['semester'] ?>
                                </span>
                            </td>
                            <td class="fw-bold text-secondary"><?= $m['nama_monev'] ?></td>
                            <td><small class="text-muted"><?= $m['keterangan'] ?: '-' ?></small></td>
                            <td class="text-center">
                                <?= $m['status'] == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Non-Aktif</span>' ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning border-0" 
                                        onclick="btnEdit('<?= $m['id'] ?>', '<?= $m['nama_monev'] ?>', '<?= $m['status'] ?>', '<?= $m['keterangan'] ?>', '<?= $m['fk_setting_periode'] ?>')" 
                                        data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= base_url('univ/monev/hapus/'.$m['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus?')">
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
            <form action="<?= base_url('univ/monev/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah Item Monev</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">PILIH PERIODE</label>
                        <select name="fk_setting_periode" class="form-select" required>
                            <?php foreach($periode as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= $p['status_aktif'] == 1 ? 'selected' : '' ?>>
                                    <?= $p['tahun_akademik'] ?> - <?= $p['semester'] ?> <?= $p['status_aktif'] == 1 ? '(Aktif)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA DOKUMEN</label>
                        <input type="text" name="nama_monev" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KETERANGAN</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success btn-rounded w-100">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/monev/edit') ?>" method="post">
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-4">Edit Item Monev</h5>
                    <input type="hidden" name="id" id="e_id">
                    <div class="mb-3">
                        <label class="small fw-bold">PERIODE</label>
                        <select name="fk_setting_periode" id="e_fk_periode" class="form-select">
                            <?php foreach($periode as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['tahun_akademik'] ?> - <?= $p['semester'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">NAMA ITEM</label>
                        <input type="text" name="nama_monev" id="e_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">KETERANGAN</label>
                        <textarea name="keterangan" id="e_keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">STATUS</label>
                        <select name="status" id="e_status" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 btn-rounded text-white mt-2">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function btnEdit(id, nama, status, keterangan, fk_periode) {
        document.getElementById('e_id').value = id;
        document.getElementById('e_nama').value = nama;
        document.getElementById('e_status').value = status;
        document.getElementById('e_keterangan').value = keterangan;
        document.getElementById('e_fk_periode').value = fk_periode;
    }
</script>
<?= $this->endSection() ?>