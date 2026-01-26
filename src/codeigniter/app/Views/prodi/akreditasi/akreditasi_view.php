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
                        $today = new DateTime(); // Waktu sekarang

                        foreach ($riwayat as $row): 
                            
                            // 1. HITUNG MUNDUR (COUNTDOWN)
                            $tglExp = new DateTime($row['tgl_kadaluarsa']);
                            $interval = $today->diff($tglExp); // Selisih waktu

                            // Tentukan warna & teks status
                            $badgeColor = 'bg-success'; 
                            $statusText = 'Berlaku';
                            $countdownText = "";

                            // Logic Warna & Warning
                            if ($tglExp < $today) {
                                // SUDAH KADALUARSA
                                $badgeColor = 'bg-secondary';
                                $statusText = 'Kadaluarsa';
                                $countdownText = "Lewat " . $interval->format('%y Thn %m Bln');
                            } elseif ($interval->days <= 180) { 
                                // KRITIS (< 6 Bulan)
                                $badgeColor = 'bg-danger';
                                $statusText = 'Segera Habis';
                                $countdownText = $interval->format('%m Bln %d Hari lagi');
                            } elseif ($interval->days <= 365) { 
                                // WARNING (< 1 Tahun)
                                $badgeColor = 'bg-warning text-dark';
                                $statusText = 'Warning';
                                $countdownText = $interval->format('%m Bln %d Hari lagi');
                            } else {
                                // AMAN
                                $countdownText = $interval->format('%y Thn %m Bln lagi');
                            }
                        ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="fw-bold text-dark"><?= esc($row['nama_lembaga']) ?></div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        No SK: <?= esc($row['no_sk_akreditasi']) ?>
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        Tgl Terbit: <?= date('d M Y', strtotime($row['tgl_sk_keluar'])) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if(!empty($row['peringkat'])): ?>
                                        <span class="fw-bold text-primary"><?= esc($row['peringkat']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['nilai'] ?? '-') ?></td>
                                <td>
                                    <div class="fw-bold text-dark">
                                        <?= date('d M Y', strtotime($row['tgl_kadaluarsa'])) ?>
                                    </div>
                                    <small class="<?= ($tglExp < $today) ? 'text-danger' : 'text-success' ?> fw-bold" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock me-1"></i><?= $countdownText ?>
                                    </small>
                                </td>
                                <td>
                                    <span class="badge <?= $badgeColor ?> rounded-pill" style="font-size: 0.65rem;">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetail<?= $row['id'] ?>"
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalDetail<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-success">
                                                <i class="bi bi-award-fill me-2"></i>Detail Akreditasi Prodi
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            
                                            <div class="row g-4">
                                                <div class="col-md-6 border-end">
                                                    <div class="mb-3">
                                                        <label class="small text-muted text-uppercase fw-bold">Program Studi</label>
                                                        <div class="fw-bold text-dark fs-5"><?= esc($row['nama_prodi']) ?></div>
                                                        <span class="badge bg-light text-dark border"><?= esc($row['jenjang'] ?? 'S1') ?></span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="small text-muted text-uppercase fw-bold">Lembaga Akreditasi</label>
                                                        <div class="fw-bold text-success"><?= esc($row['nama_lembaga']) ?></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6 mb-3">
                                                            <label class="small text-muted text-uppercase fw-bold">Peringkat</label>
                                                            <div class="fw-bold text-primary fs-4"><?= esc($row['peringkat'] ?? '-') ?></div>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label class="small text-muted text-uppercase fw-bold">Nilai / Skor</label>
                                                            <div class="fw-bold text-dark fs-4"><?= esc($row['nilai'] ?? '0') ?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 ps-md-4">
                                                    <div class="p-3 bg-light rounded-3 mb-3 border">
                                                        <label class="small text-muted fw-bold d-block mb-1">Nomor SK</label>
                                                        <span class="fw-bold text-dark text-break"><?= esc($row['no_sk_akreditasi']) ?></span>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label class="small text-muted fw-bold">Tanggal Terbit</label>
                                                            <div class="fw-bold"><?= date('d M Y', strtotime($row['tgl_sk_keluar'])) ?></div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="small text-muted fw-bold text-danger">Tanggal Kadaluarsa</label>
                                                            <div class="fw-bold text-danger"><?= date('d M Y', strtotime($row['tgl_kadaluarsa'])) ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="alert <?= ($tglExp < $today) ? 'alert-secondary' : 'alert-success' ?> d-flex align-items-center mb-0" role="alert">
                                                        <i class="bi bi-hourglass-split me-2 fs-4"></i>
                                                        <div>
                                                            <small class="d-block fw-bold">Sisa Masa Berlaku:</small>
                                                            <?= ($tglExp < $today) ? 'Sudah Berakhir' : $interval->format('%y Tahun, %m Bulan, %d Hari') ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4 pt-3 border-top">
                                                <label class="small text-muted fw-bold mb-2">Informasi Lainnya:</label>
                                                <div class="row small text-secondary">
                                                    <div class="col-md-4">
                                                        <i class="bi bi-calendar-event me-1"></i> Thn. Penyusunan: <b><?= esc($row['tahun_penyusunan']) ?></b>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <i class="bi bi-tag me-1"></i> Tahap: <b><?= esc($row['tahap']) ?></b>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <i class="bi bi-person me-1"></i> Inputer: <b><?= esc($row['penginput'] ?? 'Admin') ?></b>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer bg-light border-0">
                                            <button type="button" class="btn btn-light text-secondary" data-bs-dismiss="modal">Tutup</button>
                                            
                                            <?php if (!empty($row['link_sertifikat'])): ?>
                                                <a href="<?= esc($row['link_sertifikat']) ?>" target="_blank" class="btn btn-success shadow-sm">
                                                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Buka Sertifikat
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary" disabled>Tidak Ada Sertifikat</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<?= $this->endSection() ?>