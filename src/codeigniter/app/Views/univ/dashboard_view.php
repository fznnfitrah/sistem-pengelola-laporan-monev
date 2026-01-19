<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h2 class="mb-4 fw-bold">Dashboard Universitas</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-calendar-check fs-1 text-success"></i></div>
                <h5 class="mb-2">Setting Periode</h5>
                <p class="mb-4">Atur periode default laporan untuk seluruh user.</p>
                <a href="<?= base_url('univ/periode') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-diagram-3 fs-1 text-success"></i></div>
                <h5 class="mb-2">Fakultas & Prodi</h5>
                <p class="mb-4">Kelola data fakultas dan prodi (Varchar ID).</p>
                <a href="<?= base_url('univ/master') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-building-gear fs-1 text-success"></i></div>
                <h5 class="mb-2">Unit & Lembaga</h5>
                <p class="mb-4">Kelola unit kerja non-akademik (mUnit).</p>
                <a href="<?= base_url('univ/unit') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-file-earmark-medical fs-1 text-success"></i></div>
                <h5 class="mb-2">Item Monev</h5>
                <p class="mb-4">Atur daftar dokumen wajib unggah tiap periode.</p>
                <a href="<?= base_url('univ/monev') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-trophy fs-1 text-success"></i></div>
                <h5 class="mb-2">Master Kinerja</h5>
                <p class="mb-4">Atur indikator profil unit (mKinerja).</p>
                <a href="<?= base_url('univ/kinerja') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3"><i class="bi bi-eye fs-1 text-success"></i></div>
                <h5 class="mb-2">Monitoring</h5>
                <p class="mb-4">Pantau progres pengunggahan seluruh unit.</p>
                <a href="<?= base_url('univ/monitoring') ?>" class="btn btn-custom w-100">Buka</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>