<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Profil Pengguna</h4>
            <p class="text-muted small mb-0">Kelola informasi akun dan identitas Anda di sini.</p>
        </div>
    </div>

    <?php
    $roleId = (int) ($user['fk_roles'] ?? 0);
    $roleDisplay = 'Pengguna';
    $badgeColor = 'bg-secondary';

    switch ($roleId) {
        case 1:
            $roleDisplay = 'Administrator';
            $badgeColor = 'bg-dark';
            break;
        case 2:
            $roleDisplay = 'Fakultas';
            $badgeColor = 'bg-warning text-dark';
            break;
        case 3:
            $roleDisplay = 'Program Studi';
            $badgeColor = 'bg-primary';
            break;
        case 4:
            $roleDisplay = 'Unit Kerja';
            $badgeColor = 'bg-info text-dark';
            break;
        case 5:
            $roleDisplay = 'Pimpinan / Rektorat';
            $badgeColor = 'bg-danger';
            break;
        default:
            $roleDisplay = 'User (Level ' . $roleId . ')';
            $badgeColor = 'bg-secondary';
    }
    ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                <div class="card-body text-center p-5">
                    <div class="position-relative d-inline-block mb-4">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-success shadow-sm"
                            style="width: 120px; height: 120px; font-size: 3.5rem; border: 4px solid #fff;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle"
                            style="width: 20px; height: 20px;" title="Akun Aktif"></div>
                    </div>

                    <h4 class="fw-bold text-dark mb-1"><?= esc($user['username']) ?></h4>

                    <span class="badge <?= $badgeColor ?> rounded-pill px-3 py-2 text-uppercase mb-4" style="letter-spacing: 1px; font-size: 0.7rem;">
                        <?= esc($roleDisplay) ?>
                    </span>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-success fw-bold py-2" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                            <i class="bi bi-pencil-square me-2"></i> Edit Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0 ps-4 pt-4">
                    <h6 class="fw-bold text-success text-uppercase small mb-0"><i class="bi bi-card-list me-2"></i>Rincian Akun</h6>
                </div>
                <div class="card-body p-4">

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('validation')) : ?>
                        <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Memperbarui Profil. Silakan periksa inputan Anda.
                        </div>
                    <?php endif; ?>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <label class="small text-muted text-uppercase fw-bold mb-1">Alamat Email</label>
                                <div class="fw-bold text-dark d-flex align-items-center">
                                    <i class="bi bi-envelope me-2 text-success"></i>
                                    <?= esc($user['email']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <label class="small text-muted text-uppercase fw-bold mb-1">Status Keanggotaan</label>
                                <div class="fw-bold text-dark d-flex align-items-center">
                                    <i class="bi bi-shield-check me-2 text-success"></i>
                                    Aktif / Terverifikasi
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($user['nama_prodi']) || !empty($user['nama_unit']) || !empty($user['nama_fakultas'])) : ?>
                        <hr class="my-4 border-light">
                        <h6 class="fw-bold text-success text-uppercase small mb-3"><i class="bi bi-building me-2"></i>Afiliasi Kerja</h6>
                        <div class="list-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
                            <?php if (!empty($user['nama_prodi'])) : ?>
                                <div class="list-group-item border-0 px-4 py-3 d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3"><i class="bi bi-mortarboard-fill"></i></div>
                                    <div><small class="text-muted d-block">Program Studi</small><span class="fw-bold text-dark"><?= esc($user['nama_prodi']) ?></span></div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($user['nama_unit'])) : ?>
                                <div class="list-group-item border-0 px-4 py-3 d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3"><i class="bi bi-building-fill"></i></div>
                                    <div><small class="text-muted d-block">Unit Kerja</small><span class="fw-bold text-dark"><?= esc($user['nama_unit']) ?></span></div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($user['nama_fakultas'])) : ?>
                                <div class="list-group-item border-0 px-4 py-3 d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 text-dark rounded-circle p-2 me-3"><i class="bi bi-bank2"></i></div>
                                    <div><small class="text-muted d-block">Fakultas</small><span class="fw-bold text-dark"><?= esc($user['nama_fakultas']) ?></span></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-success"></i>Edit Profil Saya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= base_url('profile/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body px-4 pt-2 pb-4">
                    <p class="text-muted small mb-3">Perbarui informasi akun Anda. Kosongkan password jika tidak ingin mengubahnya.</p>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>"
                            value="<?= old('username', $user['username']) ?>" required>
                        <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="email" name="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>"
                            value="<?= old('email', $user['email']) ?>" placeholder="contoh@email.com">

                        <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="password" name="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                            placeholder="Min. 6 karakter">
                        <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                    </div>

                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('validation')) : ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalEditProfil'));
            myModal.show();
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>