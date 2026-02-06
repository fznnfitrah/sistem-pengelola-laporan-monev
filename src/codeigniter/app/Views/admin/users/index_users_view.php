<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 flex-column flex-md-row gap-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="bi bi-people-fill me-2"></i>Manajemen Pengguna
                    </h5>
                    <button type="button" class="btn btn-success btn-sm px-3 px-md-4 rounded-pill" onclick="btnAddUser()" style="white-space: nowrap;">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah User
                    </button>
                </div>
                <div class="card-body">

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success border-0 shadow-sm small">
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" style="font-size: 0.8rem;">
                            <thead class="table-light text-uppercase small fw-bold">
                                <tr>
                                    <th class="text-center ps-2 ps-md-3" style="font-size: 0.75rem;">No</th>
                                    <th class="ps-2 ps-md-3" style="font-size: 0.75rem;">Info Pengguna</th>
                                    <th style="font-size: 0.75rem; display: none;" class="d-none d-md-table-cell">Status</th>
                                    <th style="font-size: 0.75rem; display: none;" class="d-none d-lg-table-cell">Role</th>
                                    <th class="text-center" style="font-size: 0.75rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)) : $i = 1;
                                    foreach ($users as $row) : ?>
                                        <tr>
                                            <td class="text-center text-muted small ps-2 ps-md-3"><?= $i++ ?></td>
                                            <td class="ps-2 ps-md-3">
                                                <div class="fw-bold text-dark" style="font-size: 0.8rem;"><?= esc($row['username']) ?></div>
                                                <small class="text-muted"><i class="bi bi-envelope me-1"></i><?= esc(substr($row['email'] ?: '-', 0, 20)) ?></small>
                                                <div style="font-size: 0.7rem; margin-top: 4px;" class="d-md-none">
                                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-dark border px-2 py-1" style="font-size: 0.65rem;"><?php $st = (string)esc($row['status']); echo ucfirst($st); ?></span>
                                                </div>
                                            </td>
                                            <td style="display: none;" class="d-none d-md-table-cell">
                                                <?php
                                                $st = (string)esc($row['status']);
                                                $badgeClass = ($st == 'aktif') ? 'bg-success' : (($st == 'baru') ? 'bg-info' : 'bg-secondary');
                                                ?>
                                                <span class="badge rounded-pill <?= $badgeClass ?> bg-opacity-10 text-dark border px-2" style="font-size: 0.7rem;">
                                                    <?= ucfirst($st) ?>
                                                </span>
                                            </td>
                                            <td style="display: none;" class="d-none d-lg-table-cell">
                                                <div class="badge bg-primary bg-opacity-10 text-primary border border-primary" style="font-size: 0.7rem;">
                                                    <?= esc($row['nama_roles']) ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                    <button type="button" class="btn btn-outline-warning btn-sm border-0"
                                                        onclick='btnEditUser(<?= json_encode($row) ?>)'>
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <form action="<?= base_url('admin/users/' . $row['id']) ?>" method="post" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0" onclick="return confirm('Hapus user ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted small">Belum ada data pengguna.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success" id="modalTitle">
                    <i class="bi bi-person-circle me-2"></i><span>Tambah User</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formUser" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6 border-end">
                            <h6 class="fw-bold text-secondary small mb-3 text-uppercase">Kredensial Akun</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="u_username" class="form-control bg-light border-0 py-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" id="u_email" class="form-control bg-light border-0 py-2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold" id="labelPass">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="u_password" class="form-control bg-light border-0 py-2">
                                <small class="text-muted mt-1 d-block" id="passHelp" style="display:none; font-size: 11px;">
                                    <i class="bi bi-info-circle me-1"></i>Kosongkan jika tidak ingin mengubah password.
                                </small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" id="u_status" class="form-select bg-light border-0 py-2">
                                    <option value="baru">Baru</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4">
                            <h6 class="fw-bold text-secondary small mb-3 text-uppercase">Akses & Penempatan</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Role <span class="text-danger">*</span></label>
                                <select name="fk_roles" id="u_role" class="form-select bg-light border-0 py-2" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <?php foreach ($roles as $role) : ?>
                                        <option value="<?= $role['id'] ?>"><?= $role['nama_roles'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3 text-start">
                                <label class="form-label small fw-bold text-start">Fakultas</label>
                                <select name="fk_fakultas" id="u_fakultas" class="form-select bg-light border-0 py-2">
                                    <option value="">-- Bukan Fakultas --</option>
                                    <?php foreach ($data_fakultas as $fak) : ?>
                                        <option value="<?= $fak['id'] ?>"><?= $fak['nama_fakultas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Program Studi</label>
                                <select name="fk_prodi" id="u_prodi" class="form-select bg-light border-0 py-2">
                                    <option value="">-- Bukan Prodi --</option>
                                    <?php foreach ($data_prodi as $prodi) : ?>
                                        <option value="<?= $prodi['id'] ?>"><?= $prodi['nama_prodi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Unit</label>
                                <select name="fk_unit" id="u_unit" class="form-select bg-light border-0 py-2">
                                    <option value="">-- Bukan Unit --</option>
                                    <?php foreach ($data_unit as $unit) : ?>
                                        <option value="<?= $unit['id'] ?>"><?= $unit['id'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold small" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm fw-bold small">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Inisialisasi modal menggunakan vanilla JS agar lebih stabil
    let userModal;

    document.addEventListener('DOMContentLoaded', function() {
        userModal = new bootstrap.Modal(document.getElementById('modalUser'));

        // Munculkan kembali jika ada error validasi dari server
        <?php if (session()->getFlashdata('errors')) : ?>
            userModal.show();
        <?php endif; ?>
    });

    function btnAddUser() {
        const form = document.getElementById('formUser');
        document.querySelector('#modalTitle span').innerText = "Tambah User Baru";
        form.action = "<?= base_url('admin/users/save') ?>";
        document.getElementById('formMethod').value = "POST";
        form.reset();

        document.getElementById('passHelp').style.display = "none";
        document.getElementById('labelPass').innerHTML = 'Password <span class="text-danger">*</span>';
        document.getElementById('u_password').required = true;

        userModal.show();
    }

    function btnEditUser(data) {
        const form = document.getElementById('formUser');
        document.querySelector('#modalTitle span').innerText = "Edit Data User";
        form.action = "<?= base_url('admin/users') ?>/" + data.id;
        document.getElementById('formMethod').value = "PUT";

        document.getElementById('passHelp').style.display = "block";
        document.getElementById('labelPass').innerHTML = 'Password';
        document.getElementById('u_password').required = false;
        document.getElementById('u_password').value = "";

        // Pemetaan data ke ID form
        document.getElementById('u_username').value = data.username;
        document.getElementById('u_email').value = data.email || "";
        document.getElementById('u_status').value = data.status;
        document.getElementById('u_role').value = data.fk_roles;
        document.getElementById('u_fakultas').value = data.fk_fakultas || "";
        document.getElementById('u_prodi').value = data.fk_prodi || "";
        document.getElementById('u_unit').value = data.fk_unit || "";

        userModal.show();
    }
</script>
<?= $this->endSection() ?>