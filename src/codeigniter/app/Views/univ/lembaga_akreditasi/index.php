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
            <h2 class="fw-bold text-dark mb-1">Master Lembaga Akreditasi</h2>
            <p class="text-muted small">Kelola daftar lembaga akreditasi Nasional maupun Internasional.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah" style="border-radius: 10px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lembaga
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th class="text-start ps-4" width="20%">Nama Lembaga</th>
                            <th width="10%">Jenis</th>
                            <th width="15%">Biaya (Rp)</th>
                            <th class="text-start" width="25%">Alamat</th>
                            <th width="10%">Link</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($lembaga as $l): ?>
                        <tr class="text-center">
                            <td><?= $no++ ?></td>
                            <td class="text-start ps-4 fw-bold text-dark"><?= esc($l['nama_lembaga']) ?></td>
                            <td>
                                <span class="badge bg-light text-primary border px-3 py-2" style="border-radius: 8px;">
                                    <?= esc($l['jenis_lembaga']) ?>
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                Rp <?= number_format($l['biaya'], 0, ',', '.') ?>
                            </td>
                            <td class="text-start small text-muted">
                                <?= esc($l['alamat']) ?: '-' ?>
                            </td>
                            <td>
                                <?php if($l['url']): ?>
                                    <a href="<?= esc($l['url']) ?>" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm">
                                        <i class="bi bi-box-arrow-up-right text-primary"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-warning border-0" 
                                    onclick='editLembaga(<?= json_encode($l) ?>)'
                                    data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= base_url('univ/lembaga_akreditasi/hapus/'.$l['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger border-0" 
                                   onclick="return confirm('Hapus lembaga ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($lembaga)): ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted fst-italic">Belum ada data lembaga.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/lembaga_akreditasi/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold text-success">Tambah Lembaga Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA LEMBAGA</label>
                        <input type="text" name="nama_lembaga" class="form-control border-2" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">JENIS LEMBAGA</label>
                        <select name="jenis_lembaga" class="form-select border-2" style="border-radius: 10px;">
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ESTIMASI BIAYA (Rp)</label>
                        <input type="number" name="biaya" class="form-control border-2" value="0" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">URL WEBSITE</label>
                        <input type="url" name="url" class="form-control border-2" placeholder="https://..." style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ALAMAT LEMBAGA</label>
                        <textarea name="alamat" class="form-control border-2" rows="3" style="border-radius: 10px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm" style="border-radius: 12px;">Simpan Lembaga</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/lembaga_akreditasi/edit') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold text-warning">Edit Data Lembaga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA LEMBAGA</label>
                        <input type="text" name="nama_lembaga" id="edit_nama" class="form-control border-2" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">JENIS LEMBAGA</label>
                        <select name="jenis_lembaga" id="edit_jenis" class="form-select border-2" style="border-radius: 10px;">
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ESTIMASI BIAYA (Rp)</label>
                        <input type="number" name="biaya" id="edit_biaya" class="form-control border-2" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">URL WEBSITE</label>
                        <input type="url" name="url" id="edit_url" class="form-control border-2" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ALAMAT LEMBAGA</label>
                        <textarea name="alamat" id="edit_alamat" class="form-control border-2" rows="3" style="border-radius: 10px;"></textarea>
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
    function editLembaga(data) {
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_nama').value = data.nama_lembaga;
        document.getElementById('edit_jenis').value = data.jenis_lembaga;
        document.getElementById('edit_biaya').value = data.biaya;
        document.getElementById('edit_url').value = data.url;
        document.getElementById('edit_alamat').value = data.alamat;
    }
</script>

<?= $this->endSection() ?>