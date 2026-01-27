<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white p-3" style="border-radius: 15px;">
                <h6 class="small fw-bold">TOTAL PRODI TERPANTAU</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['total_prodi'] ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-warning text-dark p-3" style="border-radius: 15px;">
                <h6 class="small fw-bold">MASA BERLAKU < 6 BULAN</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['akan_habis'] ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger text-white p-3" style="border-radius: 15px;">
                <h6 class="small fw-bold">SUDAH KADALUARSA</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['kadaluarsa'] ?></h2>
            </div>
        </div>
    </div>

    <?php foreach ($groupedData as $fakultas => $prodis) : ?>
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold text-success mb-0"><i class="bi bi-building-check me-2"></i><?= esc($fakultas) ?></h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th class="text-start">Program Studi</th>
                                <th>Peringkat / Skor</th>
                                <th>Masa Berlaku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($prodis as $p) : 
                                $tgl_k = strtotime($p['tgl_kadaluarsa']);
                                $isExpired = $tgl_k < time();
                                $isWarning = $tgl_k < strtotime("+6 months") && !$isExpired;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($p['nama_prodi']) ?> (<?= esc($p['jenjang']) ?>)</div>
                                        <small class="text-muted">SK: <?= esc($p['no_sk_akreditasi']) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary fs-6"><?= esc($p['peringkat']) ?></span><br>
                                        <small class="fw-bold">Skor: <?= esc($p['nilai']) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="small fw-bold <?= $isExpired ? 'text-danger' : ($isWarning ? 'text-warning' : 'text-success') ?>">
                                            <?= date('d M Y', $tgl_k) ?>
                                        </div>
                                        <?php if ($isExpired) : ?>
                                            <span class="badge bg-danger">Kadaluarsa</span>
                                        <?php elseif ($isWarning) : ?>
                                            <span class="badge bg-warning text-dark">Hampir Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $p['id'] ?>">
                                            <i class="bi bi-search"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php foreach ($allData as $p) : ?>
<div class="modal fade" id="modalDetail<?= $p['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-success"><i class="bi bi-patch-check-fill me-2"></i>Detail Akreditasi Prodi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6 border-end">
                        <label class="small text-muted mb-0">Program Studi</label>
                        <h5 class="fw-bold text-dark"><?= esc($p['nama_prodi']) ?></h5>
                        <p class="badge bg-light text-dark border">Jenjang: <?= esc($p['jenjang']) ?></p>
                        
                        <div class="mt-3">
                            <label class="small text-muted mb-0">Lembaga Akreditasi</label>
                            <p class="fw-bold text-primary mb-0"><?= esc($p['nama_lembaga']) ?></p>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="small text-muted mb-0">Peringkat</label>
                                <div class="h4 fw-bold text-success"><?= esc($p['peringkat'] ?: '-') ?></div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted mb-0">Nilai Angka</label>
                                <div class="h4 fw-bold text-dark"><?= esc($p['nilai']) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 mb-3">
                            <label class="small text-muted mb-0">Nomor SK</label>
                            <div class="fw-bold"><?= esc($p['no_sk_akreditasi']) ?></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small text-muted">Tgl Terbit</label>
                                <div class="fw-bold"><?= date('d M Y', strtotime($p['tgl_sk_keluar'])) ?></div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Tgl Kadaluarsa</label>
                                <div class="fw-bold text-danger"><?= date('d M Y', strtotime($p['tgl_kadaluarsa'])) ?></div>
                            </div>
                        </div>
                        <hr>
                        <div class="small text-muted">Tahap: <strong><?= esc($p['tahap']) ?></strong></div>
                        <div class="small text-muted">Inputer: <strong><?= esc($p['penginput']) ?></strong></div>
                    </div>
                </div>
                <div class="mt-4 d-grid">
                    <a href="<?= esc($p['link_sertifikat']) ?>" target="_blank" class="btn btn-success py-2 fw-bold" style="border-radius: 10px;">
                        <i class="bi bi-cloud-arrow-down me-2"></i> Buka Sertifikat Dokumen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?= $this->endSection() ?>