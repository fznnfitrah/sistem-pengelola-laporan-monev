<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-primary">Laporan Kinerja (<?= ucfirst($is_unit ? 'Unit' : 'Prodi') ?>)</h5>
                <small class="text-muted">Data Kinerja per Periode Akademik</small>
            </div>

            <form action="" method="get" class="d-flex gap-2">
                <div class="input-group">
                    <span class="input-group-text bg-light">Periode:</span>
                    <select name="periode" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php foreach ($semua_periode as $p) : ?>
                            <option value="<?= $p['id'] ?>" <?= ($p['id'] == $periode['id']) ? 'selected' : '' ?>>
                                <?= esc($p['tahun_akademik']) ?> (<?= esc($p['semester']) ?>)
                                <?= ($p['status_aktif'] == 1) ? '✅' : '🔒' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header <?= ($periode['status_aktif'] == 1) ? 'bg-success' : 'bg-secondary' ?> text-white">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-table me-2"></i> Data Periode:
                    <strong><?= esc($periode['tahun_akademik']) ?> (<?= esc($periode['semester']) ?>)</strong>
                </span>
                <?php if ($periode['status_aktif'] == 0): ?>
                    <span class="badge bg-warning text-dark"><i class="bi bi-lock-fill"></i> Terkunci (Arsip)</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body">
            <?php $isLocked = ($periode['status_aktif'] == 0); ?>

            <form action="<?= base_url('prodi/kinerja/save') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="fk_setting_periode" value="<?= $periode['id'] ?>">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-hover">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Indikator Kinerja</th>
                                <th width="15%">Realisasi</th>
                                <th>Bukti Dukung</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($indikator as $i => $item) : ?>
                                <?php
                                $val = $sudah_isi[$item['id']] ?? null;
                                $nilaiLama = $val ? $val['value'] : '';
                                $linkLama  = $val ? $val['link_bukti'] : '';
                                $ketLama   = $val ? $val['keterangan'] : '';
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td>
                                        <?= esc($item['nama_kinerja']) ?>
                                        <br>
                                        <span class="badge bg-light text-dark border mt-1">
                                            Satuan: <?= esc($item['satuan']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <input type="number" step="0.01" class="form-control text-center"
                                            name="data[<?= $item['id'] ?>][value]"
                                            value="<?= esc($nilaiLama) ?>"
                                            <?= $isLocked ? 'disabled' : '' ?>>
                                    </td>
                                    <td>
                                        <?php if ($isLocked && !empty($linkLama)): ?>
                                            <a href="<?= esc($linkLama) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-link-45deg"></i> Buka Bukti
                                            </a>
                                        <?php else: ?>
                                            <input type="text" class="form-control form-control-sm"
                                                name="data[<?= $item['id'] ?>][link_bukti]"
                                                value="<?= esc($linkLama) ?>"
                                                placeholder="https://"
                                                <?= $isLocked ? 'disabled' : '' ?>>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="data[<?= $item['id'] ?>][keterangan]"
                                            value="<?= esc($ketLama) ?>"
                                            <?= $isLocked ? 'disabled' : '' ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!$isLocked) : ?>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save"></i> Simpan Data Kinerja
                        </button>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>