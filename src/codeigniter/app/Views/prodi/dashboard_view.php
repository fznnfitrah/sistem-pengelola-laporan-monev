<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-calendar-check fs-1 text-success"></i></div>
                <h5 class="mb-2">prodi</h5>
                <p class="mb-4">inputan laporan monev prodi.</p>
                <a href="/" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>