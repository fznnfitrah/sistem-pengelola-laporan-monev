<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    
    <h2 class="mb-4">Selamat Datang, <?= esc(session()->get('username')) ?>!</h2>

    <div class="row">

        <?php if (session()->get('fk_roles') == 1) : ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 text-center p-4">
                    <h5 class="fw-bold">Total User</h5>
                    <p class="text-muted">Kelola pengguna sistem</p>
                    <a href="/users" class="btn btn-primary w-100">Kelola</a>
                </div>
            </div>
            <?php endif; ?>


        <?php if (session()->get('fk_roles') == 3) : ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 text-center p-4">
                    <h5 class="fw-bold">Input Laporan</h5>
                    <p class="text-muted">Unggah laporan Monev baru</p>
                    <a href="/laporan/input" class="btn btn-outline-dark w-100">Mulai Input</a>
                </div>
            </div>
             <div class="col-md-4 mb-4">
                <div class="card shadow border-0 text-center p-4">
                    <h5 class="fw-bold">History</h5>
                    <p class="text-muted">Lihat riwayat laporan</p>
                    <a href="/laporan/history" class="btn btn-outline-dark w-100">Buka History</a>
                </div>
            </div>
        <?php endif; ?>
        

        <?php if (session()->get('fk_roles') == 2) : ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 text-center p-4">
                    <h5 class="fw-bold">Status Monev</h5>
                    <p class="text-muted">Pantau progres Prodi</p>
                    <a href="/monitoring" class="btn btn-success w-100">Lihat Status</a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>