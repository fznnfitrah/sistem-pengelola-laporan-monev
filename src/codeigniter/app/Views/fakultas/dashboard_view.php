<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h2 class="mb-4 fw-bold">Dashboard Fakultas</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-pencil-square fs-1 text-success"></i>
                </div>
                <h5 class="mb-2">Input Laporan Monev</h5>
                <p class="mb-4 text-muted small">Isi tagihan laporan monev fakultas sesuai periode yang aktif.</p>
                <a href="<?= base_url('fakultas/laporan/input') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-clock-history fs-1 text-success"></i>
                </div>
                <h5 class="mb-2">History Laporan</h5>
                <p class="mb-4 text-muted small">Lihat kembali seluruh laporan yang pernah Anda kirimkan.</p>
                <a href="<?= base_url('fakultas/laporan/history') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-eye fs-1 text-success"></i>
                </div>
                <h5 class="mb-2">Monitoring Laporan</h5>
                <p class="mb-4 text-muted small">Memantau progres pengunggahan dokumen Program Studi di lingkup Fakultas.</p>
                <a href="<?= base_url('fakultas/monitoring') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>