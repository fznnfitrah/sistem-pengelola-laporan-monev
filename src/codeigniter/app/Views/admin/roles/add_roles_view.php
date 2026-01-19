<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Role Baru</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('roles/save') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="role_name" class="form-label">Nama Role</label>
                            <input type="text" class="form-control" name="role_name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>