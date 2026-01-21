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
                                    <th style="width: 15%">Tanggal</th>
                                    <th>Jenis Laporan Monev</th>
                                    <th style="width: 15%">Periode</th>
                                    <th class="text-center" style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($laporan)) : ?>
                                    <?php $i = 1;
                                    foreach ($laporan as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['create_at'])) ?></td>
                                            <td>
                                                <span class="fw-bold"><?= esc($row['nama_monev']) ?></span>
                                                <br>
                                                <small class="text-muted">
                                                    <?= esc(mb_substr($row['keterangan'] ?? '', 0, 50)) ?>...
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= esc($row['tahun_akademik']) ?> (<?= esc($row['semester']) ?>)
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('prodi/laporan/detail/' . $row['id']) ?>" class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
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