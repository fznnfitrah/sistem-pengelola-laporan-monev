<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-start gap-3 flex-column flex-md-row">
            <div>
                <h4 class="fw-bold text-success mb-0">Monitoring Laporan Prodi</h4>
                <p class="text-muted small mb-0">Memantau progres pengunggahan dokumen Program Studi di lingkup Fakultas.</p>
            </div>

            <form action="" method="get" class="d-flex gap-2 flex-column flex-md-row" style="width: 100%; max-width: 500px;">
                <select name="periode" class="form-select border-2 flex-grow-1" style="border-radius: 10px;">
                    <?php foreach ($semua_periode as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $selectedPeriode) ? 'selected' : '' ?>>
                            <?= esc($p['tahun_akademik']) ?> - <?= esc($p['semester']) ?>
                            <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-3 px-md-4" style="border-radius: 10px; white-space: nowrap;">Filter</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.75rem;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-2 ps-md-4" style="font-size: 0.7rem; min-width: 150px;">Nama Program Studi</th>
                            <?php foreach ($tagihan as $t): ?>
                                <th style="font-size: 0.65rem; min-width: 120px; vertical-align: middle; padding: 0.5rem 0.2rem;">
                                    <div style="line-height: 1.2;">
                                        <?= esc($t['nama_monev']) ?>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prodi as $pr): ?>
                            <tr>
                                <td class="text-start ps-2 ps-md-4 text-dark">
                                    <div class="d-flex align-items-center gap-2 flex-column flex-md-row">
                                        <span class="fw-bold" style="font-size: 0.75rem;"><?= esc($pr['nama_prodi']) ?></span>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border" style="font-size: 0.6rem; white-space: nowrap;">
                                            <?= esc($pr['jenjang'] ?? '-') ?>
                                        </span>
                                    </div>
                                </td>
                                <?php foreach ($tagihan as $t):
                                    $key = 'PRO_' . trim($pr['id']) . '_' . $t['id'];
                                    $ada = isset($statusLaporan[$key]);
                                ?>
                                    <td style="padding: 0.3rem 0.1rem;">
                                        <?php if ($ada): ?>
                                            <a href="<?= esc($statusLaporan[$key]['link_bukti']) ?>" target="_blank" class="badge bg-success text-decoration-none shadow-sm px-1" style="font-size: 0.6rem; padding: 0.3rem 0.4rem !important;">
                                                ✓ <span class="d-none d-md-inline ms-1">Sudah</span> <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.5rem;"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-1" style="font-size: 0.6rem; padding: 0.3rem 0.4rem !important;">Belum</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($prodi)): ?>
                            <tr>
                                <td colspan="<?= count($tagihan) + 1 ?>" class="py-4 text-muted fst-italic" style="font-size: 0.75rem;">Tidak ada data prodi di fakultas ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>