<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-secondary">Detail Laporan</h5>
                    <a href="<?= base_url('prodi/laporan/history') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h4 class="text-primary fw-bold"><?= esc($laporan['nama_monev']) ?></h4>
                        <span class="badge bg-light text-dark border">
                            Periode: <?= esc($laporan['tahun_akademik']) ?> (<?= esc($laporan['semester']) ?>)
                        </span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold text-muted">Tanggal Upload</div>
                        <div class="col-md-8">
                            : <?= date('d F Y, H:i', strtotime($laporan['create_at'])) ?> WIB
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold text-muted">Pengirim</div>
                        <div class="col-md-8">
                            : <?= esc($laporan['nama_prodi']) ?>
                            <?= empty($laporan['nama_prodi']) ? '(Unit Kerja)' : '' ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold text-muted">Keterangan / Catatan</div>
                        <div class="col-md-8">
                            <div class="p-3 bg-light rounded border">
                                <?php if (empty($laporan['keterangan'])) : ?>
                                    <span class="text-muted fst-italic">- Tidak ada keterangan -</span>
                                <?php else : ?>
                                    <?= nl2br(esc($laporan['keterangan'] ?? '')) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <a href="<?= esc($laporan['link_bukti']) ?>" target="_blank" class="btn btn-primary btn-lg">
                                    <i class="bi bi-folder2-open me-2"></i> Buka Dokumen Bukti (Link)
                                </a>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted fst-italic">Link akan terbuka di tab baru. Pastikan Anda memiliki akses.</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>