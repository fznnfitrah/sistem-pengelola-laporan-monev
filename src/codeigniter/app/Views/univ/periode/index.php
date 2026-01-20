<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Setting Periode</h2>
            <p class="text-muted">Tentukan periode semester aktif untuk pengisian laporan monev.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-calendar-plus me-1"></i> Tambah Periode
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tahun Akademik</th>
                            <th>Semester</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($periode as $p): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= $p['tahun_akademik'] ?></td>
                            <td><?= $p['semester'] ?></td>
                            <td class="text-center">
                                <?php if($p['status_aktif'] == 1): ?>
                                    <span class="badge bg-success px-3 py-2">Aktif (Default)</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($p['status_aktif'] == 0): ?>
                                    <a href="<?= base_url('univ/periode/setAktif/'.$p['id']) ?>" class="btn btn-sm btn-primary btn-rounded">Aktifkan</a>
                                <?php endif; ?>
                                <a href="<?= base_url('univ/periode/hapus/'.$p['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus periode ini?')">
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
            <form action="<?= base_url('univ/periode/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah Periode Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">TAHUN AKADEMIK</label>
                        <input type="text" name="tahun_akademik" class="form-control" placeholder="Contoh: 2025/2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">SEMESTER</label>
                        <select name="semester" class="form-select" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success btn-rounded w-100">Simpan Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>