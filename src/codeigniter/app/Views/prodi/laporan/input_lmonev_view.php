<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom p-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0 text-primary">Tagihan Laporan Monev</h5>
                            <small class="text-muted">Silakan pilih periode laporan yang ingin diisi/lihat.</small>
                        </div>

                        <div class="col-md-6">
                            <form action="" method="get">
                                <div class="input-group">
                                    <label class="input-group-text bg-light fw-bold">Periode:</label>
                                    <select name="periode" class="form-select" onchange="this.form.submit()">
                                        <?php foreach ($semua_periode as $p) : ?>
                                            <option value="<?= $p['id'] ?>"
                                                <?= ($p['id'] == $periode_pilih['id']) ? 'selected' : '' ?>>

                                                <?= esc($p['tahun_akademik']) ?> <?= esc($p['semester']) ?>

                                                <?= ($p['status_aktif'] == 1) ? '(Aktif Sekarang)' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn btn-primary" type="submit">Pilih</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            Gagal menyimpan data. Pastikan format link benar dan kolom terisi.
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th style="width: 5%">No</th>
                                    <th style="width: 25%">Item Monev</th>
                                    <th>Form Pengisian / Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($daftar_monev)) : ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Tidak ada item monev yang perlu dilaporkan pada periode ini.
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php $i = 1;
                                    foreach ($daftar_monev as $item) : ?>
                                        <?php
                                        // Cek apakah item ini sudah dilaporkan?
                                        $sudahLapor = array_key_exists($item['id'], $laporan_prodi);
                                        $dataLaporan = $sudahLapor ? $laporan_prodi[$item['id']] : null;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td>
                                                <strong><?= esc($item['nama_monev']) ?></strong>
                                                <?php if ($item['keterangan']): ?>
                                                    <br><small class="text-muted"><?= esc($item['keterangan']) ?></small>
                                                <?php endif; ?>
                                            </td>

                                            <td class="bg-light">
                                                <?php if ($sudahLapor) : ?>
                                                    <div class="p-2">
                                                        <span class="badge bg-success mb-2"><i class="bi bi-check-circle"></i> Sudah Dikirim</span>
                                                        <br>
                                                        <small class="text-muted">Link Bukti:</small><br>
                                                        <a href="<?= esc($dataLaporan['link_bukti']) ?>" target="_blank" class="text-decoration-none">
                                                            <i class="bi bi-link-45deg"></i> Lihat Dokumen
                                                        </a>
                                                        <hr class="my-1">
                                                        <small class="text-muted">Catatan:</small>
                                                        <p class="mb-0 text-sm fst-italic">"<?= esc($dataLaporan['keterangan']) ?>"</p>
                                                    </div>

                                                <?php else : ?>
                                                    <form action="<?= base_url('prodi/laporan/save') ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="fk_monev" value="<?= $item['id'] ?>">
                                                        <input type="hidden" name="fk_setting_periode" value="<?= $periode_pilih['id'] ?>">

                                                        <div class="row g-2">
                                                            <div class="col-md-5">
                                                                <input type="url" name="link_bukti" class="form-control form-control-sm"
                                                                    placeholder="Link Google Drive/Dokumen..." required>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="keterangan" class="form-control form-control-sm"
                                                                    placeholder="Keterangan singkat..." required>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                                    <i class="bi bi-send"></i> Simpan
                                                                </button>
                                                            </div>
                                                        </div>
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