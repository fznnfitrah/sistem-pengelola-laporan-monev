<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-file-earmark-plus fs-1 text-success"></i></div>
                <h5 class="mb-2">Masukkan Laporan</h5>
                <p class="mb-4">Masukkan Laporan Monitoring dan Evaluasi Program Studi.</p>
                <a href="<?= base_url('prodi/laporan/input') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-clock-history fs-1 text-success"></i></div>
                <h5 class="mb-2">History Laporan</h5>
                <p class="mb-4">Catatan Laporan Monitoring dan Evaluasi Program Studi yang sudah diinputkan.</p>
                <a href="<?= base_url('prodi/laporan/history') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-speedometer2 fs-1 text-success"></i></div>
                <h5 class="mb-2">Laporan Kinerja</h5>
                <p class="mb-4">Catatan KinerjaProgram Studi yang sudah diinputkan.</p>
                <a href="<?= base_url('prodi/kinerja/input') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>