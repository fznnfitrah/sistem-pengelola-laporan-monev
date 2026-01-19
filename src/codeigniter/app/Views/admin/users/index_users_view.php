<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0 text-secondary">Daftar Pengguna (User)</h5>
                    <a href="<?= base_url('admin/users/add') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-person-plus"></i> Tambah User
                    </a>
                </div>
                <div class="card-body">

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)) : ?>
                                    <?php $i = 1;
                                    foreach ($users as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td><?= esc($row['username']) ?></td>
                                            <td><?= esc($row['email']) ?></td>

                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <?= esc($row['nama_roles']) ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?= base_url('admin/users/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm me-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="<?= base_url('admin/users/' . $row['id']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data user.</td>
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
<?= $this->endSection() ?>