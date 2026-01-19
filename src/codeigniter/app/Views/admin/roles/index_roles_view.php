<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <h5 class="mb-0 text-secondary">Daftar Roles Admin</h5>
                    <a href="<?= base_url('admin/roles/add') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Role
                    </a>
                </div>

                <div class="card-body">

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 25%;">Nama Role</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 15%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles) && is_array($roles)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($roles as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td class="fw-bold"><?= esc($row['nama_roles']) ?></td>
                                            <td><?= esc($row['deskripsi']) ?></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-warning btn-sm me-1" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="<?= base_url('admin/roles/' . $row['id']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?> <input type="hidden" name="_method" value="DELETE">

                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data role ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                <!-- <a href="#" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            Belum ada data role yang tersedia.
                                        </td>
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