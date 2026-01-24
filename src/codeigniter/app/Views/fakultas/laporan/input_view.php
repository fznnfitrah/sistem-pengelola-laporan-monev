<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-success mb-0">Tagihan Laporan Monev</h5>
            <form action="" method="get" class="d-flex gap-2">
                <select name="periode" class="form-select border-2" style="width: 300px; border-radius: 10px;">
                    <?php foreach($periode as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $selectedPeriode) ? 'selected' : '' ?>>
                            <?= $p['tahun_akademik'] ?> - <?= $p['semester'] ?> <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 10px;">Pilih</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="ps-4">No</th>
                        <th width="35%">Item Monev</th>
                        <th>Form Pengisian / Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($items)): ?>
                        <tr><td colspan="3" class="text-center py-5">Belum ada item tagihan untuk periode ini.</td></tr>
                    <?php endif; ?>

                    <?php $no = 1; foreach($items as $row): ?>
                        <tr>
                            <td class="ps-4"><?= $no++ ?></td>
                            <td>
                                <p class="fw-bold mb-1 text-dark"><?= $row['nama_monev'] ?></p>
                                <small class="text-muted italic"><?= $row['keterangan'] ?></small>
                            </td>
                            <td>
                                <?php if(isset($laporan[$row['id']])): ?>
                                    <div class="p-3 bg-light rounded-3 border-start border-success border-4 shadow-sm mb-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="badge bg-success mb-2"><i class="bi bi-check-circle me-1"></i> Sudah Dikirim</span><br>
                                                <a href="<?= $laporan[$row['id']]['link_bukti'] ?>" target="_blank" class="small text-decoration-none text-success fw-bold">
                                                    <i class="bi bi-link-45deg"></i> Lihat Link Saat Ini
                                                </a>
                                            </div>
                                            <button class="btn btn-sm btn-outline-success border-0" type="button" data-bs-toggle="collapse" data-bs-target="#editForm<?= $row['id'] ?>">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                        </div>
                                        <p class="small text-muted mb-0 mt-1 italic">"<?= $laporan[$row['id']]['keterangan'] ?>"</p>
                                    </div>

                                    <div class="collapse mt-2" id="editForm<?= $row['id'] ?>">
                                        <form action="<?= base_url('fakultas/laporan/simpan') ?>" method="post" class="row g-2 p-2 border rounded">
                                            <input type="hidden" name="fk_setting_periode" value="<?= $selectedPeriode ?>">
                                            <input type="hidden" name="fk_monev" value="<?= $row['id'] ?>">
                                            <div class="col-md-5">
                                                <input type="url" name="link_bukti" class="form-control form-control-sm" value="<?= $laporan[$row['id']]['link_bukti'] ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="keterangan" class="form-control form-control-sm" value="<?= $laporan[$row['id']]['keterangan'] ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-arrow-repeat me-1"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <form action="<?= base_url('fakultas/laporan/simpan') ?>" method="post" class="row g-2">
                                        <input type="hidden" name="fk_setting_periode" value="<?= $selectedPeriode ?>">
                                        <input type="hidden" name="fk_monev" value="<?= $row['id'] ?>">
                                        <div class="col-md-5">
                                            <input type="url" name="link_bukti" class="form-control form-control-sm" placeholder="Inputkan link yang benar..." required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Catatan singkat...">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-send me-1"></i> Simpan</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>