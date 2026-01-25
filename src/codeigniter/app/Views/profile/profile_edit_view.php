<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-success mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h5>
                </div>
                
                <div class="card-body p-4">
                    
                    <form action="<?= base_url('profile/update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Username</label>
                            <input type="text" name="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" 
                                   value="<?= old('username', $user['username']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Email</label>
                            <input type="email" name="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                                   value="<?= old('email', $user['email']) ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>

                        <hr class="my-4 dashed">

                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Password Baru</label>
                            <input type="password" name="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            <div class="form-text text-muted">Minimal 6 karakter.</div>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="<?= base_url('profile') ?>" class="btn btn-light text-secondary">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>