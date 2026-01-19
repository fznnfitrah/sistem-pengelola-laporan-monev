<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php if ($roleId == 1) : ?>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-people fs-1 text-success"></i>
                    </div>
                    <h5 class="mb-2">Kelola Role</h5>
                    <p class="mb-4">Kelola dan atur hak akses Menu.</p>
                    <a href="<?= base_url('admin/roles') ?>" class="btn btn-custom w-100">Kelola</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($roleId == 2) : ?>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                    </div>
                    <h5 class="mb-2">Status Monev</h5>
                    <p class="mb-4">Pantau progres pengunggahan laporan tiap Prodi.</p>
                    <a href="<?= base_url('monitoring') ?>" class="btn btn-custom w-100">Lihat Status</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($roleId == 3) : ?>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-cloud-arrow-up fs-1 text-success"></i>
                    </div>
                    <h5 class="mb-2">Input Laporan</h5>
                    <p class="mb-4">Unggah link laporan Monev terbaru ke sistem.</p>
                    <a href="<?= base_url('laporan/input') ?>" class="btn btn-custom w-100">Mulai Input</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-journal-text fs-1 text-success"></i>
                    </div>
                    <h5 class="mb-2">History</h5>
                    <p class="mb-4">Lihat kembali riwayat laporan yang telah diunggah.</p>
                    <a href="<?= base_url('laporan/history') ?>" class="btn btn-custom w-100">Buka History</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($roleId == 5) : ?>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card shadow-sm text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                    </div>
                    <h5 class="mb-2">Input User</h5>
                    <p class="mb-4">Tambahkan pengguna baru ke sistem.</p>
                    <a href="<?= base_url('monitoring') ?>" class="btn btn-custom w-100">Lihat Status</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>