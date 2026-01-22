<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white border-bottom p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-1 fw-bold text-primary">Tagihan Laporan Monev (Unit)</h5>
                            <small class="text-muted">
                                Periode:
                                <span class="badge bg-light text-dark border">
                                    <?= esc($periode_pilih['tahun_akademik']) ?> (<?= esc($periode_pilih['semester']) ?>)
                                </span>
                            </small>
                        </div>

                        <div class="col-md-6">
                            <form action="" method="get" class="d-flex justify-content-md-end mt-3 mt-md-0">
                                <div class="input-group" style="max-width: 300px;">
                                    <label class="input-group-text bg-light fw-bold">Periode</label>
                                    <select name="periode" class="form-select" onchange="this.form.submit()">
                                        <?php foreach ($semua_periode as $p) : ?>
                                            <option value="<?= $p['id'] ?>"
                                                <?= ($p['id'] == $periode_pilih['id']) ? 'selected' : '' ?>>
                                                <?= esc($p['tahun_akademik']) ?> (<?= esc($p['semester']) ?>)
                                                <?= ($p['status_aktif'] == 1) ? '✅' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal menyimpan!</strong> Periksa kembali isian Anda.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 30%">Jenis Laporan / Monev</th>
                                    <th>Status & Form Pengisian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($daftar_monev)) : ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-5">
                                            <i class="bi bi-clipboard-x fs-1 d-block mb-2"></i>
                                            Tidak ada tagihan laporan monev pada periode ini.
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php $i = 1;
                                    foreach ($daftar_monev as $item) : ?>
                                        <?php
                                        $sudahLapor = array_key_exists($item['id'], $laporan_prodi);
                                        $dataLaporan = $sudahLapor ? $laporan_prodi[$item['id']] : null;
                                        ?>
                                        <tr>
                                            <td class="text-center fw-bold"><?= $i++ ?></td>

                                            <td>
                                                <div class="fw-bold text-dark"><?= esc($item['nama_monev']) ?></div>
                                                <?php if (!empty($item['keterangan'])): ?>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="bi bi-info-circle me-1"></i><?= esc($item['keterangan']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>

                                            <td class="bg-light">
                                                <?php if ($sudahLapor) : ?>
                                                    <div class="p-2 border rounded bg-white border-success">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle-fill"></i> Sudah Dikirim
                                                            </span>
                                                            <small class="text-muted">
                                                                <?= date('d M Y, H:i', strtotime($dataLaporan['create_at'])) ?>
                                                            </small>
                                                        </div>

                                                        <div class="mb-1">
                                                            <a href="<?= esc($dataLaporan['link_bukti']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-link-45deg"></i> Buka Bukti Link
                                                            </a>
                                                        </div>

                                                        <hr class="my-2 dashed">

                                                        <small class="text-secondary fw-bold">Keterangan:</small>
                                                        <div class="fst-italic text-muted small">
                                                            "<?= esc($dataLaporan['keterangan']) ?>"
                                                        </div>
                                                    </div>

                                                <?php else : ?>
                                                    <form action="<?= base_url('unit/laporan/save') ?>" method="post" enctype="multipart/form-data">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="fk_monev" value="<?= $item['id'] ?>">
                                                        <input type="hidden" name="fk_setting_periode" value="<?= $periode_pilih['id'] ?>">

                                                        <div class="row g-2 align-items-center">
                                                            <div class="col-md-5">
                                                                <label class="form-label visually-hidden">Link Bukti</label>
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text bg-white"><i class="bi bi-link"></i></span>
                                                                    <input type="url" name="link_bukti" class="form-control"
                                                                        placeholder="https://..." required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="form-label visually-hidden">Keterangan</label>
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text bg-white"><i class="bi bi-pencil"></i></span>
                                                                    <input type="text" name="keterangan" class="form-control"
                                                                        placeholder="Ket. singkat laporan..." required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                                                                    <i class="bi bi-send-fill"></i> Kirim
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-text small mt-1 text-muted">
                                                        </div> -->
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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