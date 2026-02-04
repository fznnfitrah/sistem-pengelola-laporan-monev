<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
            <h5 class="fw-bold text-success mb-0">Tagihan Laporan Monev</h5>
            <form action="" method="get" class="d-flex gap-2 flex-column flex-md-row" style="width: 100%; max-width: 500px; margin-left: auto;">
                <select name="periode" class="form-select border-2 flex-grow-1" style="border-radius: 10px;">
                    <?php foreach($periode as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $selectedPeriode) ? 'selected' : '' ?>>
                            <?= $p['tahun_akademik'] ?> - <?= $p['semester'] ?> <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-3 px-md-4" style="border-radius: 10px; white-space: nowrap;">Pilih</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.8rem;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-2 ps-md-4" style="font-size: 0.75rem;">No</th>
                        <th class="ps-2 ps-md-4" style="font-size: 0.75rem;">Item Monev</th>
                        <th style="font-size: 0.75rem;">Form Pengisian / Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($items)): ?>
                        <tr><td colspan="3" class="text-center py-5">Belum ada item tagihan untuk periode ini.</td></tr>
                    <?php endif; ?>

                    <?php $no = 1; foreach($items as $row): ?>
                        <tr>
                            <td class="ps-2 ps-md-4"><?= $no++ ?></td>
                            <td class="ps-2 ps-md-4">
                                <p class="fw-bold mb-1 text-dark" style="font-size: 0.8rem;"><?= $row['nama_monev'] ?></p>
                                <small class="text-muted italic"><?= esc(substr($row['keterangan'], 0, 40)) ?></small>
                            </td>
                            <td>
                                <?php if(isset($laporan[$row['id']])): ?>
                                    <div class="p-2 p-md-3 bg-light rounded-3 border-start border-success border-4 shadow-sm mb-2" style="font-size: 0.75rem;">
                                        <div class="d-flex justify-content-between align-items-start gap-2 flex-column flex-md-row">
                                            <div>
                                                <span class="badge bg-success mb-2"><i class="bi bi-check-circle me-1"></i> Sudah Dikirim</span><br>
                                                <a href="<?= $laporan[$row['id']]['link_bukti'] ?>" target="_blank" class="small text-decoration-none text-success fw-bold">
                                                    <i class="bi bi-link-45deg"></i> Lihat Link
                                                </a>
                                            </div>
                                            <button class="btn btn-sm btn-outline-success border-0" type="button" data-bs-toggle="collapse" data-bs-target="#editForm<?= $row['id'] ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </div>
                                        <p class="small text-muted mb-0 mt-1 italic">"<?= esc(substr($laporan[$row['id']]['keterangan'], 0, 35)) ?>"</p>
                                    </div>

                                    <div class="collapse mt-2" id="editForm<?= $row['id'] ?>">
                                        <form action="<?= base_url('fakultas/laporan/simpan') ?>" method="post" class="row g-2 p-2 border rounded">
                                            <input type="hidden" name="fk_setting_periode" value="<?= $selectedPeriode ?>">
                                            <input type="hidden" name="fk_monev" value="<?= $row['id'] ?>">
                                            <div class="col-12 col-md-6">
                                                <input type="url" name="link_bukti" class="form-control form-control-sm" value="<?= $laporan[$row['id']]['link_bukti'] ?>" required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="text" name="keterangan" class="form-control form-control-sm" value="<?= $laporan[$row['id']]['keterangan'] ?>">
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-arrow-repeat me-1"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <form action="<?= base_url('fakultas/laporan/simpan') ?>" method="post" class="row g-2">
                                        <input type="hidden" name="fk_setting_periode" value="<?= $selectedPeriode ?>">
                                        <input type="hidden" name="fk_monev" value="<?= $row['id'] ?>">
                                        <div class="col-12 col-md-5">
                                            <input type="url" name="link_bukti" class="form-control form-control-sm" placeholder="Inputkan link..." required>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <input type="text" name="keterangan" class="form-control form-control-sm" placeholder="Catatan singkat...">
                                        </div>
                                        <div class="col-12 col-md-3">
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