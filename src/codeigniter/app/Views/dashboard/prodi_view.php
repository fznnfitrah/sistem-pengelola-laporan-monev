<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 text-center p-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">menu</h5>
                    <p class="text-muted">Ringkasan status Monev.</p>
                    <a href="#" class="btn btn-outline-dark w-100">Buka Menu</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 text-center p-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">input</h5>
                    <p class="text-muted">Unggah laporan Monev baru.</p>
                    <a href="#" class="btn btn-outline-dark w-100">Mulai Input</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 text-center p-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">history</h5>
                    <p class="text-muted">Lihat riwayat laporan.</p>
                    <a href="#" class="btn btn-outline-dark w-100">Lihat History</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>