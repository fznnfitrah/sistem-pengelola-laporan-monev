<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-secondary">Riwayat Laporan Monev</h5>
                    <a href="<?= base_url('prodi/laporan/input') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-lg"></i> Buat Laporan Baru
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
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 15%">Tanggal Upload</th>
                                    <th style="width: 20%">Jenis Monev</th>
                                    <th>Keterangan / Judul</th>
                                    <th style="width: 15%">Periode</th>
                                    <th class="text-center" style="width: 10%">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($laporan)) : ?>
                                    <?php $i = 1; foreach ($laporan as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td><?= date('d M Y H:i', strtotime($row['create_at'])) ?></td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <?= esc($row['nama_monev']) ?>
                                                </span>
                                            </td>
                                            <td><?= esc($row['keterangan']) ?></td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= esc($row['tahun_akademik']) ?> (<?= esc($row['semester']) ?>)
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= esc($row['link_bukti']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-link-45deg"></i> Buka
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Belum ada laporan yang dikirim.
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