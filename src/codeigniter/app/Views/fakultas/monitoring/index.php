<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-success mb-0">Monitoring Laporan Prodi</h4>
                <p class="text-muted small mb-0">Memantau progres pengunggahan dokumen Program Studi di lingkup Fakultas.</p>
            </div>
            
            <form action="" method="get" class="d-flex gap-2">
                <select name="periode" class="form-select border-2" style="width: 300px; border-radius: 10px;">
                    <?php foreach ($semua_periode as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $selectedPeriode) ? 'selected' : '' ?>>
                            <?= esc($p['tahun_akademik']) ?> - <?= esc($p['semester']) ?> 
                            <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 10px;">Filter</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4" width="25%">Nama Program Studi</th>
                            <?php foreach($tagihan as $t): ?>
                                <th style="font-size: 0.7rem;"><?= esc($t['nama_monev']) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prodi as $pr): ?>
                        <tr>
                            <td class="text-start ps-4 fw-bold text-dark"><?= esc($pr['nama_prodi']) ?></td>
                            <?php foreach($tagihan as $t): 
                                // Mencocokkan data prodi & item monev
                                $key = 'PRO_' . trim($pr['id']) . '_' . $t['id'];
                                $ada = isset($statusLaporan[$key]);
                            ?>
                                <td>
                                    <?php if($ada): ?>
                                        <a href="<?= esc($statusLaporan[$key]['link_bukti']) ?>" target="_blank" class="badge bg-success text-decoration-none shadow-sm px-2 py-2" style="font-size: 0.75rem;">
                                            Sudah <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.65rem;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-2 py-2" style="font-size: 0.75rem;">Belum</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($prodi)): ?>
                            <tr><td colspan="<?= count($tagihan) + 1 ?>" class="py-4 text-muted fst-italic">Tidak ada data prodi di fakultas ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>