<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-success mb-0">Tagihan Laporan Monev Unit</h5>
                <p class="text-muted small mb-0">Silakan pilih periode untuk mengisi atau memperbarui laporan.</p>
            </div>
            <form action="" method="get" class="d-flex gap-2">
                <select name="periode" class="form-select border-2" style="width: 280px; border-radius: 10px;">
                    <?php foreach ($semua_periode as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $periode_pilih['id']) ? 'selected' : '' ?>>
                            <?= esc($p['tahun_akademik']) ?> - <?= esc($p['semester']) ?>
                            <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 10px;">Pilih</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="ps-4 text-center">No</th>
                            <th width="35%">Item Monev</th>
                            <th>Form Pengisian / Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftar_monev)) : ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted fst-italic">
                                    Belum ada item tagihan untuk periode ini.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php $no = 1;
                        foreach ($daftar_monev as $item) : ?>
                            <?php
                            $sudahLapor = array_key_exists($item['id'], $laporan_unit);
                            $dataLaporan = $sudahLapor ? $laporan_unit[$item['id']] : null;
                            ?>
                            <tr>
                                <td class="ps-4 text-center"><?= $no++ ?></td>
                                <td>
                                    <p class="fw-bold mb-1 text-dark"><?= esc($item['nama_monev']) ?></p>
                                    <small class="text-muted italic"><?= esc($item['keterangan']) ?></small>
                                </td>
                                <td>
                                    <?php if ($sudahLapor) : ?>
                                        <div class="p-3 bg-light rounded-3 border-start border-success border-4 shadow-sm">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <span class="badge bg-success mb-2"><i class="bi bi-check-circle me-1"></i> Sudah Dikirim</span><br>
                                                    <a href="<?= esc($dataLaporan['link_bukti']) ?>" target="_blank" class="small text-decoration-none text-success fw-bold">
                                                        <i class="bi bi-link-45deg"></i> Lihat Dokumen Saat Ini
                                                    </a>
                                                </div>
                                                <button class="btn btn-sm btn-outline-success border-0" type="button" data-bs-toggle="collapse" data-bs-target="#editForm<?= $item['id'] ?>">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                            </div>
                                            <p class="small text-muted mb-0 mt-1 italic">"<?= esc($dataLaporan['keterangan']) ?>"</p>
                                        </div>

                                        <div class="collapse mt-2" id="editForm<?= $item['id'] ?>">
                                            <form action="<?= base_url('unit/laporan/save') ?>" method="post" class="row g-2 p-2 border rounded bg-white">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="fk_monev" value="<?= $item['id'] ?>">
                                                <input type="hidden" name="fk_setting_periode" value="<?= $periode_pilih['id'] ?>">
                                                <div class="col-md-5">
                                                    <input type="url" name="link_bukti" class="form-control form-control-sm border-2" value="<?= esc($dataLaporan['link_bukti']) ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="keterangan" class="form-control form-control-sm border-2" value="<?= esc($dataLaporan['keterangan']) ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm"><i class="bi bi-arrow-repeat me-1"></i> Perbarui</button>
                                                </div>
                                            </form>
                                        </div>

                                    <?php else : ?>
                                        <form action="<?= base_url('unit/laporan/save') ?>" method="post" class="row g-2 p-1">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="fk_monev" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="fk_setting_periode" value="<?= $periode_pilih['id'] ?>">

                                            <div class="col-md-5">
                                                <input type="url" name="link_bukti" class="form-control form-control-sm border-2" placeholder="Link G-Drive/Dokumen..." required style="border-radius: 8px;">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="keterangan" class="form-control form-control-sm border-2" placeholder="Keterangan singkat..." required style="border-radius: 8px;">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm" style="border-radius: 8px;">
                                                    <i class="bi bi-send me-1"></i> Simpan
                                                </button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>