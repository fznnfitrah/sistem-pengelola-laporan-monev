<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-success mb-0">Monitoring Laporan Monev</h4>
                <p class="text-muted small mb-0">Gunakan tombol "Sudah" untuk mengunjungi link dokumen yang diunggah.</p>
            </div>
            
            <form action="" method="get" class="d-flex gap-2">
                <select name="periode" class="form-select border-2" style="width: 250px; border-radius: 10px;">
                    <?php foreach($periode as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $selectedPeriode) ? 'selected' : '' ?>>
                            <?= $p['tahun_akademik'] ?> - <?= $p['semester'] ?> 
                            <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 10px;">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
            </form>
        </div>
    </div>

    <h5 class="fw-bold text-success mb-3"><i class="bi bi-building me-2"></i>Monitoring Level Fakultas</h5>
    <div class="card border-0 shadow-sm mb-5" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4">Nama Fakultas</th>
                            <?php foreach($tagihan as $t): ?>
                                <th style="font-size: 0.7rem;"><?= $t['nama_monev'] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($fakultas as $f): ?>
                        <tr>
                            <td class="text-start ps-4 fw-bold text-dark"><?= $f['nama_fakultas'] ?></td>
                            <?php foreach($tagihan as $t): 
                                $key = 'FAK_' . trim($f['id']) . '_' . $t['id'];
                                $ada = isset($statusLaporan[$key]);
                            ?>
                                <td>
                                    <?php if($ada): ?>
                                        <a href="<?= $statusLaporan[$key]['link_bukti'] ?>" target="_blank" class="badge bg-success text-decoration-none shadow-sm px-2 py-2" style="font-size: 0.75rem;">
                                            Sudah <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.65rem;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-2 py-2" style="font-size: 0.75rem;">Belum</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-mortarboard me-2"></i>Monitoring Level Program Studi</h5>
    <?php foreach($fakultas as $f): 
        $prodis = $db->table('mProdi')->where('fk_fakultas', $f['id'])->get()->getResultArray();
    ?>
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="mb-0 fw-bold text-secondary">Fakultas: <?= $f['nama_fakultas'] ?></h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4" width="25%">Program Studi</th>
                            <?php foreach($tagihan as $t): ?>
                                <th style="font-size: 0.65rem;"><?= $t['nama_monev'] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prodis as $pr): ?>
                        <tr>
                            <td class="text-start ps-4 small text-dark"><?= $pr['nama_prodi'] ?></td>
                            <?php foreach($tagihan as $t): 
                                $key = 'PRO_' . trim($pr['id']) . '_' . $t['id'];
                                $ada = isset($statusLaporan[$key]);
                            ?>
                                <td>
                                    <?php if($ada): ?>
                                        <a href="<?= $statusLaporan[$key]['link_bukti'] ?>" target="_blank" class="badge bg-success text-decoration-none shadow-sm px-2 py-2" style="font-size: 0.75rem;">
                                            Sudah <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.65rem;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-2 py-2" style="font-size: 0.75rem;">Belum</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <h5 class="fw-bold text-warning mb-3"><i class="bi bi-building-gear me-2"></i>Monitoring Level Unit & Lembaga</h5>
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4" width="25%">Nama Unit / Lembaga</th>
                            <?php foreach($tagihan as $t): ?>
                                <th style="font-size: 0.65rem;"><?= $t['nama_monev'] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($unit as $u): ?>
                        <tr>
                            <td class="text-start ps-4 small text-dark fw-bold"><?= $u['nama_unit'] ?></td>
                            <?php foreach($tagihan as $t): 
                                $key = 'UNIT_' . trim($u['id']) . '_' . $t['id'];
                                $ada = isset($statusLaporan[$key]);
                            ?>
                                <td>
                                    <?php if($ada): ?>
                                        <a href="<?= $statusLaporan[$key]['link_bukti'] ?>" target="_blank" class="badge bg-success text-decoration-none shadow-sm px-2 py-2" style="font-size: 0.75rem;">
                                            Sudah <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.65rem;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-2 py-2" style="font-size: 0.75rem;">Belum</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($unit)): ?>
                            <tr><td colspan="<?= count($tagihan) + 1 ?>" class="text-center py-4 text-muted">Belum ada data unit/lembaga.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>