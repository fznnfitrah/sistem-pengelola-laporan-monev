<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-success mb-1">Riwayat Akreditasi Prodi</h4>
            <p class="text-muted small mb-0">Daftar riwayat akreditasi yang tercatat dalam sistem.</p>
        </div>
        <a href="<?= base_url('prodi/akreditasi/new') ?>" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Data
        </a>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> <?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="ps-4">No</th>
                            <th class="text-start">Lembaga & SK</th>
                            <th>Peringkat</th>
                            <th>Nilai</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $today = new DateTime();

                        foreach ($riwayat as $row):

                            // --- 1. LOGIC HITUNG MUNDUR (UNTUK TAMPILAN TABEL) ---
                            $tglKadaluarsa = $row['tgl_kadaluarsa'];
                            $hasExpiration = !empty($tglKadaluarsa) && $tglKadaluarsa != '0000-00-00';

                            // Default
                            $badgeColor = 'bg-secondary';
                            $statusText = $row['tahap'];
                            $countdownText = '-';
                            $formattedExpDate = '<span class="text-muted">-</span>';

                            if ($hasExpiration) {
                                $tglExp = new DateTime($tglKadaluarsa);
                                $interval = $today->diff($tglExp);
                                $formattedExpDate = date('d M Y', strtotime($tglKadaluarsa));

                                if ($tglExp < $today) {
                                    $badgeColor = 'bg-secondary';
                                    $statusText = 'Kadaluarsa';
                                    $countdownText = "Lewat " . $interval->format('%y Thn %m Bln');
                                } elseif ($interval->days <= 180) {
                                    $badgeColor = 'bg-danger';
                                    $statusText = 'Segera Habis';
                                    $countdownText = $interval->format('%m Bln %d Hari lagi');
                                } elseif ($interval->days <= 365) {
                                    $badgeColor = 'bg-warning text-dark';
                                    $statusText = 'Warning';
                                    $countdownText = $interval->format('%m Bln %d Hari lagi');
                                } else {
                                    $badgeColor = 'bg-success';
                                    $statusText = 'Berlaku';
                                    $countdownText = $interval->format('%y Thn %m Bln lagi');
                                }
                            }
                        ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="fw-bold text-dark"><?= esc($row['nama_lembaga']) ?></div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        No SK: <?= esc($row['no_sk_akreditasi'] ?: '-') ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($row['peringkat'])): ?>
                                        <span class="fw-bold text-primary"><?= esc($row['peringkat']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['nilai'] ?? '-') ?></td>

                                <td>
                                    <div class="fw-bold text-dark">
                                        <?= $formattedExpDate ?>
                                    </div>
                                    <?php if ($hasExpiration): ?>
                                        <small class="<?= ($tglExp < $today) ? 'text-danger' : 'text-success' ?> fw-bold" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock me-1"></i> <?= $countdownText ?>
                                        </small>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="badge <?= $badgeColor ?> rounded-pill" style="font-size: 0.65rem;">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-success"
                                        onclick="btnDetail(
                                            '<?= esc($row['nama_prodi']) ?>',
                                            '<?= esc($row['jenjang']) ?>',
                                            '<?= esc($row['tahap']) ?>', 
                                            '<?= esc($row['nama_lembaga']) ?>',
                                            '<?= !empty($row['nama_lembaga_internasional']) ? esc($row['nama_lembaga_internasional']) : '-' ?>',
                                            '<?= esc($row['peringkat']) ?>',
                                            '<?= esc($row['nilai']) ?>',
                                            '<?= esc($row['no_sk_akreditasi']) ?>',
                                            '<?= esc($row['tgl_kadaluarsa']) ?>',
                                            '<?= esc($row['biaya']) ?>',             
                                            '<?= esc($row['tahun_penyusunan']) ?>',  
                                            '<?= esc($row['ts']) ?>',                
                                            '<?= esc($row['ts-1']) ?>',              
                                            '<?= esc($row['ts-2']) ?>',              
                                            '<?= !empty($row['link_sertifikat']) ? $row['link_sertifikat'] : '#' ?>',
                                            '<?= esc($row['penginput']) ?>',    
                                            '<?= esc($row['create_at']) ?>'   
                                        )"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($riwayat)): ?>
                            <tr>
                                <td colspan="7" class="py-5 text-muted fst-italic">Belum ada data riwayat akreditasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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

                <div class="mt-4 pt-3 border-top d-flex justify-content-between text-muted small">
                    <div>
                        <i class="bi bi-person-circle me-1"></i> Diinput oleh:
                        <span class="fw-bold text-dark" id="d_penginput">-</span>
                    </div>
                    <div>
                        <i class="bi bi-clock-history me-1"></i> Tgl Input:
                        <span class="fw-bold text-dark" id="d_tgl_input">-</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <a href="#" id="btnLinkSertifikat" target="_blank" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Lihat Sertifikat
                </a>
                <button type="button" id="btnNoSertifikat" class="btn btn-secondary rounded-pill px-4 d-none" disabled>
                    Tidak Ada Sertifikat
                </button>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('js/detail_akreditasi.js') ?>"></script>

<?= $this->endSection() ?>