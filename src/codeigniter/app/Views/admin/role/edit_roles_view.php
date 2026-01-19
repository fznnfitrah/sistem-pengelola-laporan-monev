<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-secondary">Edit Role</h5>
                </div>
                <div class="card-body">
                    
                    <?php $errors = session()->getFlashdata('errors'); ?>

                    <form action="<?= base_url('admin/roles/' . $role['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <input type="hidden" name="_method" value="PUT">

                        <div class="mb-3">
                            <label for="nama_roles" class="form-label">Nama Role <span class="text-danger">*</span></label>
                            
                            <input type="text" 
                                   class="form-control <?= (isset($errors['nama_roles'])) ? 'is-invalid' : ''; ?>" 
                                   id="nama_roles" 
                                   name="nama_roles" 
                                   value="<?= old('nama_roles', $role['nama_roles']) ?>">
                            
                            <div class="invalid-feedback">
                                <?= esc($errors['nama_roles'] ?? '') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control <?= (isset($errors['deskripsi'])) ? 'is-invalid' : ''; ?>" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"><?= old('deskripsi', $role['deskripsi']) ?></textarea>
                            
                            <div class="invalid-feedback">
                                <?= esc($errors['deskripsi'] ?? '') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>