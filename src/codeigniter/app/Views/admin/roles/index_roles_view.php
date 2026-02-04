<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 flex-column flex-md-row gap-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-shield-lock-fill me-2"></i>Daftar Roles Admin</h5>
                    <button type="button" class="btn btn-success btn-sm px-3 px-md-4 rounded-pill shadow-sm" onclick="btnAddRole()" style="white-space: nowrap;">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Role
                    </button>
                </div>

                <div class="card-body text-start">
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success border-0 shadow-sm small mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger border-0 shadow-sm small mb-4">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" style="font-size: 0.8rem;">
                            <thead class="table-light text-uppercase small fw-bold">
                                <tr>
                                    <th class="text-center ps-2 ps-md-3" style="font-size: 0.75rem;">No</th>
                                    <th class="ps-2 ps-md-3" style="font-size: 0.75rem;">Nama Role</th>
                                    <th style="font-size: 0.75rem; display: none;" class="d-none d-md-table-cell">Deskripsi</th>
                                    <th class="text-center" style="font-size: 0.75rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles)) : $i = 1; foreach ($roles as $row) : ?>
                                    <tr>
                                        <td class="text-center text-muted small ps-2 ps-md-3"><?= $i++ ?></td>
                                        <td class="ps-2 ps-md-3"><span class="fw-bold text-dark"><?= esc($row['nama_roles']) ?></span></td>
                                        <td style="display: none;" class="d-none d-md-table-cell"><span class="text-muted small"><?= esc(substr($row['deskripsi'] ?: '-', 0, 30)) ?></span></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                                <button type="button" class="btn btn-outline-warning btn-sm border-0" 
                                                    onclick='btnEditRole(<?= json_encode($row) ?>)'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <?php if ($row['id'] != 1) : ?>
                                                <form action="<?= base_url('admin/roles/' . $row['id']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0" onclick="return confirm('Hapus data role ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted small">Belum ada data role.</td>
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

<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success" id="modalRoleLabel">
                    <i class="bi bi-shield-plus me-2"></i><span id="textTitle">Tambah Role Baru</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formRole" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" name="nama_roles" id="r_nama" class="form-control bg-light border-0 py-2" placeholder="Contoh: Admin Fakultas" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" id="r_deskripsi" class="form-control bg-light border-0 py-2" rows="3" placeholder="Jelaskan hak akses role ini..."></textarea>
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
    let roleModal;

    document.addEventListener('DOMContentLoaded', function() {
        roleModal = new bootstrap.Modal(document.getElementById('modalRole'));
        
        <?php if (session()->getFlashdata('errors')) : ?>
            roleModal.show();
        <?php endif; ?>
    });

    function btnAddRole() {
        const form = document.getElementById('formRole');
        document.getElementById('textTitle').innerText = "Tambah Role Baru";
        form.action = "<?= base_url('admin/roles/save') ?>";
        document.getElementById('formMethod').value = "POST";
        form.reset();
        roleModal.show();
    }

    function btnEditRole(data) {
        const form = document.getElementById('formRole');
        document.getElementById('textTitle').innerText = "Edit Data Role";
        form.action = "<?= base_url('admin/roles') ?>/" + data.id;
        document.getElementById('formMethod').value = "PUT";
        
        document.getElementById('r_nama').value = data.nama_roles;
        document.getElementById('r_deskripsi').value = data.deskripsi || "";
        
        roleModal.show();
    }
</script>
<?= $this->endSection() ?>