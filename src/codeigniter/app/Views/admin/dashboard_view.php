<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
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
        <div class="col-md-4 mb-4">
            <div class="card dashboard-card shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-people fs-1 text-success"></i>
                </div>
                <h5 class="mb-2">Kelola User</h5>
                <p class="mb-4">Kelola pengguna sistem.</p>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-custom w-100">Kelola</a>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>