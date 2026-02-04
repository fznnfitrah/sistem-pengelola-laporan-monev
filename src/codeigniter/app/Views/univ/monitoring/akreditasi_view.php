<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="row mb-4 g-3">
        <div class="col-6 col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white p-3 h-100" onclick="showDetail('total_prodi', <?= htmlspecialchars(json_encode($allData)) ?>)" style="border-radius: 15px;">
                <h6 class="small fw-bold text-uppercase" style="font-size: 0.7rem;">Total Terpantau</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['total_prodi'] ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card shadow-sm border-0 bg-warning text-dark p-3 h-100" onclick="showDetail('akan_habis', <?= htmlspecialchars(json_encode($allData)) ?>)" style="border-radius: 15px;">
                <h6 class="small fw-bold text-uppercase" style="font-size: 0.7rem;">Masa Berlaku < 6 bln</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['akan_habis'] ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card shadow-sm border-0 bg-danger text-white p-3 h-100" onclick="showDetail('kadaluarsa', <?= htmlspecialchars(json_encode($allData)) ?>)" style="border-radius: 15px;">
                <h6 class="small fw-bold text-uppercase" style="font-size: 0.7rem;">Sudah Kadaluarsa</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['kadaluarsa'] ?></h2>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card shadow-sm border-0 bg-info text-white p-3 h-100" onclick="showDetail('persiapan', <?= htmlspecialchars(json_encode($allData)) ?>)" style="border-radius: 15px;">
                <h6 class="small fw-bold text-uppercase" style="font-size: 0.7rem;">Sedang Persiapan</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['persiapan'] ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white p-3 h-100" onclick="showDetail('pengajuan', <?= htmlspecialchars(json_encode($allData)) ?>)" style="border-radius: 15px;">
                <h6 class="small fw-bold text-uppercase" style="font-size: 0.7rem;">Tahap Pengajuan</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['pengajuan'] ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card shadow-sm border-0 bg-secondary text-white p-3 h-100" onclick="showDetail('asesmen', <?= htmlspecialchars(json_encode($allData)) ?>)" style="border-radius: 15px;">
                <h6 class="small fw-bold text-uppercase" style="font-size: 0.7rem;">Asesmen Lapangan</h6>
                <h2 class="mb-0 fw-bold"><?= $stats['asesmen'] ?></h2>
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
                            <?php $no = 1;
                            foreach ($prodis as $p) :
                                // --- LOGIKA TANGGAL (UNTUK TAMPILAN TABEL) ---
                                $tglRaw = $p['tgl_kadaluarsa'];
                                $hasDate = !empty($tglRaw) && $tglRaw != '0000-00-00';

                                $displayDate = '<span class="text-muted fw-bold">-</span>';
                                $badgeStatus = '<span class="badge bg-secondary">' . esc($p['tahap']) . '</span>';

                                if ($hasDate) {
                                    $tgl_k = strtotime($tglRaw);
                                    $isExpired = $tgl_k < time();
                                    $isWarning = $tgl_k < strtotime("+6 months") && !$isExpired;
                                    $formattedDate = date('d M Y', $tgl_k);

                                    if ($isExpired) {
                                        $displayDate = '<span class="text-danger fw-bold">' . $formattedDate . '</span>';
                                        $badgeStatus = '<span class="badge bg-danger">Kadaluarsa</span>';
                                    } elseif ($isWarning) {
                                        $displayDate = '<span class="text-warning fw-bold">' . $formattedDate . '</span>';
                                        $badgeStatus = '<span class="badge bg-warning text-dark">Hampir Habis</span>';
                                    } else {
                                        $displayDate = '<span class="text-success fw-bold">' . $formattedDate . '</span>';
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
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="btnDetail(
                                                '<?= esc($p['nama_prodi']) ?>',
                                                '<?= esc($p['jenjang']) ?>',
                                                '<?= esc($p['tahap']) ?>', 
                                                '<?= esc($p['nama_lembaga_nasional']) ?>',
                                                '<?= !empty($p['nama_lembaga_internasional']) ? esc($p['nama_lembaga_internasional']) : '-' ?>',
                                                '<?= esc($p['peringkat']) ?>',
                                                '<?= esc($p['nilai']) ?>',
                                                '<?= esc($p['no_sk_akreditasi']) ?>',
                                                '<?= esc($p['tgl_kadaluarsa']) ?>',
                                                '<?= esc($p['biaya']) ?>',             
                                                '<?= esc($p['tahun_penyusunan']) ?>',  
                                                '<?= esc($p['ts']) ?>',                
                                                '<?= esc($p['ts-1']) ?>',              
                                                '<?= esc($p['ts-2']) ?>',              
                                                '<?= !empty($p['link_sertifikat']) ? $p['link_sertifikat'] : '#' ?>'
                                            )"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail">
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

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success">
                    <i class="bi bi-patch-check-fill me-2"></i>Detail Akreditasi Prodi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                    <div class="me-3">
                        <i class="bi bi-mortarboard-fill fs-1 text-success opacity-50"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-0" id="d_nama_prodi">-</h4>
                        <span class="badge bg-success" id="d_jenjang">-</span>
                        <span class="badge bg-warning text-dark ms-1" id="d_status">-</span>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 border-end">
                        <h6 class="fw-bold text-secondary small mb-3">DATA AKREDITASI</h6>

                        <div class="mb-3">
                            <label class="d-block text-muted small">Lembaga Akreditasi</label>
                            <span class="fw-bold fs-5 text-dark" id="d_lembaga">-</span>
                            <div id="d_lembaga_inter_div" class="d-none mt-1">
                                <span class="badge bg-info text-dark bg-opacity-10 border border-info" id="d_lembaga_inter">-</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="d-block text-muted small">Peringkat</label>
                                <span class="fw-bold text-primary fs-5" id="d_peringkat">-</span>
                            </div>
                            <div class="col-6">
                                <label class="d-block text-muted small">Nilai Angka</label>
                                <span class="fw-bold text-dark fs-5" id="d_nilai">-</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="d-block text-muted small">Nomor SK</label>
                            <span class="fw-bold text-dark text-break" id="d_no_sk">-</span>
                        </div>
                    </div>

                    <div class="col-md-6 ps-md-4">
                        <h6 class="fw-bold text-secondary small mb-3">PERIODE & BIAYA</h6>

                        <div class="mb-3 p-2 border border-danger border-opacity-25 bg-danger bg-opacity-10 rounded">
                            <label class="d-block text-danger small fw-bold">Tanggal Kadaluarsa</label>
                            <span class="fw-bold text-danger fs-5" id="d_tgl_kadaluarsa">-</span>
                        </div>

                        <div class="mb-3">
                            <label class="d-block text-muted small">Sisa Masa Berlaku</label>
                            <span class="fw-bold text-success" id="d_countdown">-</span>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="d-block text-muted small">Tahun Penyusunan</label>
                                <span class="fw-bold text-dark" id="d_tahun">-</span>
                            </div>
                            <div class="col-6">
                                <label class="d-block text-muted small">Biaya</label>
                                <span class="fw-bold text-dark" id="d_biaya">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold text-secondary small mb-3">DATA MAHASISWA (TS)</h6>
                <div class="row text-center g-2">
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light">
                            <small class="d-block text-muted">TS (Saat Ini)</small>
                            <span class="fw-bold" id="d_ts">-</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light">
                            <small class="d-block text-muted">TS-1</small>
                            <span class="fw-bold" id="d_ts1">-</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 border rounded bg-light">
                            <small class="d-block text-muted">TS-2</small>
                            <span class="fw-bold" id="d_ts2">-</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <a href="#" id="btnLinkSertifikat" target="_blank" class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Buka Sertifikat
                </a>
                <button type="button" id="btnNoSertifikat" class="btn btn-secondary rounded-pill px-4 d-none" disabled>
                    Tidak Ada Sertifikat
                </button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modalDetailStatistik" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Detail Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Prodi</th>
                                <th>Peringkat</th>
                                <th>Status/Tgl</th>
                            </tr>
                        </thead>
                        <tbody id="isiDetailTable">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('js/detail_akreditasi.js') ?>?v=<?= time() ?>"></script>

<?= $this->endSection() ?>