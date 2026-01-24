<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-secondary">Tambah User Baru</h5>
                </div>
                <div class="card-body">

                    <form action="<?= base_url('admin/users/save') ?>" method="post">
                        <?= csrf_field() ?>
                        <?php $errors = session()->getFlashdata('errors'); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Informasi Akun</h6>

                                <div class="mb-3">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control <?= (isset($errors['username'])) ? 'is-invalid' : ''; ?>" value="<?= old('username') ?>" placeholder="cth: admin">
                                    <div class="invalid-feedback"><?= esc($errors['username'] ?? '') ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control <?= (isset($errors['email'])) ? 'is-invalid' : ''; ?>" value="<?= old('email') ?>" placeholder="cth: email@example.com">
                                    <div class="invalid-feedback"><?= esc($errors['email'] ?? '') ?></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control <?= (isset($errors['password'])) ? 'is-invalid' : ''; ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status Akun</label>
                                    <select name="status" class="form-select">
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="non-aktif">Non-Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted border-bottom pb-2 mb-3">Hak Akses & Unit</h6>

                                <div class="mb-3">
                                    <label class="form-label">Role Pengguna <span class="text-danger">*</span></label>
                                    <select name="fk_roles" class="form-select <?= (isset($errors['fk_roles'])) ? 'is-invalid' : ''; ?>">
                                        <option value="" selected disabled>-- Pilih Role --</option>
                                        <?php foreach ($roles as $role) : ?>
                                            <option value="<?= $role['id'] ?>" <?= (old('fk_roles') == $role['id']) ? 'selected' : '' ?>>
                                                <?= $role['nama_roles'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih role pengguna.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fakultas (Opsional)</label>
                                    <select name="fk_fakultas" class="form-select">
                                        <option value="" selected>-- Tidak Ada / Bukan Fakultas --</option>
                                        <?php foreach ($data_fakultas as $fak) : ?>
                                            <option value="<?= $fak['id'] ?>" <?= (old('fk_fakultas') == $fak['id']) ? 'selected' : '' ?>>
                                                <?= $fak['nama_fakultas'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Program Studi (Opsional)</label>
                                    <select name="fk_prodi" class="form-select">
                                        <option value="" selected>-- Tidak Ada / Bukan Prodi --</option>
                                        <?php foreach ($data_prodi as $prodi) : ?>
                                            <option value="<?= $prodi['id'] ?>" <?= (old('fk_prodi') == $prodi['id']) ? 'selected' : '' ?>>
                                                <?= $prodi['nama_prodi'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kode Unit (FK Unit)</label>
                                    <select name="fk_unit" class="form-select">
                                        <option value="" selected>-- Tidak Ada / Bukan Unit --</option>
                                        <?php foreach ($data_unit as $unit) : ?>
                                            <option value="<?= $unit['id'] ?>" <?= (old('fk_unit') == $unit['id']) ? 'selected' : '' ?>>
                                                <?= $unit['id'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">Simpan User</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>