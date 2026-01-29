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

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 bg-light" style="border-radius: 15px; border-left: 5px solid #198754 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Laporan Rekapitulasi Akreditasi</h6>
                        <p class="text-muted small mb-0">Klik tombol di samping untuk melihat rincian biaya, tahun penyusunan, dan data TS secara lengkap.</p>
                    </div>
                    <a href="<?= base_url('univ/monitoring/rekap') ?>" class="btn btn-success px-4 py-2 shadow-sm fw-bold" style="border-radius: 10px;">
                        <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Lihat Rekap Report Keseluruhan
                    </a>
                </div>
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
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th class="text-start">Program Studi</th>
                                <th>Peringkat / Skor</th>
                                <th>Masa Berlaku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($prodis as $p) : 
                                // --- LOGIKA TANGGAL ---
                                $tglRaw = $p['tgl_kadaluarsa'];
                                $hasDate = !empty($tglRaw) && $tglRaw != '0000-00-00';
                                
                                $displayDate = '<span class="text-muted fw-bold">-</span>';
                                $badgeStatus = '<span class="badge bg-secondary">'.esc($p['tahap']).'</span>';

                                if ($hasDate) {
                                    $tgl_k = strtotime($tglRaw);
                                    $isExpired = $tgl_k < time();
                                    $isWarning = $tgl_k < strtotime("+6 months") && !$isExpired;
                                    
                                    $formattedDate = date('d M Y', $tgl_k);
                                    
                                    if ($isExpired) {
                                        $displayDate = '<span class="text-danger fw-bold">'.$formattedDate.'</span>';
                                        $badgeStatus = '<span class="badge bg-danger">Kadaluarsa</span>';
                                    } elseif ($isWarning) {
                                        $displayDate = '<span class="text-warning fw-bold">'.$formattedDate.'</span>';
                                        $badgeStatus = '<span class="badge bg-warning text-dark">Hampir Habis</span>';
                                    } else {
                                        $displayDate = '<span class="text-success fw-bold">'.$formattedDate.'</span>';
                                        $badgeStatus = '<span class="badge bg-success">Berlaku</span>';
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark"><?= esc($p['nama_prodi']) ?> (<?= esc($p['jenjang']) ?>)</div>
                                        <small class="text-muted">SK: <?= esc($p['no_sk_akreditasi'] ?: '-') ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6"><?= esc($p['peringkat'] ?: '-') ?></span><br>
                                        <small class="fw-bold">Skor: <?= esc($p['nilai']) ?></small>
                                    </td>
                                    <td>
                                        <div class="small mb-1"><?= $displayDate ?></div>
                                        <?= $badgeStatus ?>
                                    </td>
                                    <td>
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

<?php foreach ($rekap as $p) : 
    $tglTerbitRaw = $p['tgl_sk_keluar'];
    $tglExpRaw = $p['tgl_kadaluarsa'];
    
    $showTerbit = (!empty($tglTerbitRaw) && $tglTerbitRaw != '0000-00-00') ? date('d M Y', strtotime($tglTerbitRaw)) : '-';
    $showExp = (!empty($tglExpRaw) && $tglExpRaw != '0000-00-00') ? date('d M Y', strtotime($tglExpRaw)) : '-';
?>
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
                            <div class="fw-bold"><?= esc($p['no_sk_akreditasi'] ?: 'Belum Ada SK') ?></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small text-muted">Tgl Terbit</label>
                                <div class="fw-bold"><?= $showTerbit ?></div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Tgl Kadaluarsa</label>
                                <div class="fw-bold text-danger"><?= $showExp ?></div>
                            </div>
                        </div>
                        <hr>
                        <div class="small text-muted">Tahap: <strong><?= esc($p['tahap']) ?></strong></div>
                        <div class="small text-muted">Inputer: <strong><?= esc($p['penginput']) ?></strong></div>
                    </div>
                </div>
                
                <div class="mt-4 d-grid">
                    <?php if (!empty($p['link_sertifikat'])): ?>
                        <a href="<?= esc($p['link_sertifikat']) ?>" target="_blank" class="btn btn-success py-2 fw-bold" style="border-radius: 10px;">
                            <i class="bi bi-cloud-arrow-down me-2"></i> Buka Sertifikat Dokumen
                        </a>
                    <?php else: ?>
                         <button class="btn btn-secondary py-2 fw-bold" disabled style="border-radius: 10px;">
                            <i class="bi bi-slash-circle me-2"></i> Sertifikat Tidak Tersedia
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?= $this->endSection() ?>