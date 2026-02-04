<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-start gap-3 flex-column flex-md-row">
            <div>
                <h5 class="fw-bold text-success mb-0">Laporan Capaian Kinerja (Unit / Lembaga)</h5>
                <p class="text-muted small mb-0">Data realisasi kinerja berdasarkan indikator yang telah ditetapkan.</p>
            </div>
            
            <form action="" method="get" class="d-flex gap-2 flex-column flex-md-row" style="width: 100%; max-width: 500px;">
                <select name="periode" class="form-select border-2 flex-grow-1" style="border-radius: 10px;">
                    <?php foreach ($semua_periode as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $periode['id']) ? 'selected' : '' ?>>
                            <?= esc($p['tahun_akademik']) ?> - <?= esc($p['semester']) ?> 
                            <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-3 px-md-4" style="border-radius: 10px; white-space: nowrap;">Pilih</button>
            </form>
        </div>
    </div>


    <?php 
        // Logika Kunci Input
        $lockInput = ($hasData && !$editMode) || ($periode['status_aktif'] == 0); 
    ?>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header <?= ($periode['status_aktif'] == 1) ? 'bg-success' : 'bg-secondary' ?> text-white py-3" style="border-radius: 15px 15px 0 0;">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <i class="bi bi-table me-2"></i> Periode Laporan: <?= esc($periode['tahun_akademik']) ?> (<?= esc($periode['semester']) ?>)
                </span>
                <?php if($periode['status_aktif'] == 0): ?>
                    <span class="badge bg-warning text-dark"><i class="bi bi-lock-fill"></i> Terkunci (Arsip)</span>
                <?php elseif($hasData && !$editMode): ?>
                    <span class="badge bg-light text-success"><i class="bi bi-check-all"></i> Data Tersimpan</span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body p-0">
            <form action="<?= base_url('unit/kinerja/save') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="fk_setting_periode" value="<?= $periode['id'] ?>">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.8rem;">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="font-size: 0.75rem;" class="ps-2 ps-md-4">No</th>
                                <th style="font-size: 0.75rem; text-align: start;">Indikator Kinerja</th>
                                <th style="font-size: 0.75rem; display: none;" class="d-none d-md-table-cell">Standar Univ</th>
                                <th style="font-size: 0.75rem;">Realisasi</th>
                                <th style="font-size: 0.75rem; display: none;" class="d-none d-lg-table-cell">Bukti Dukung (Link)</th>
                                <th style="font-size: 0.75rem; display: none;" class="d-none d-xl-table-cell pe-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($indikator as $i => $item) : ?>
                                <?php 
                                    $val = $sudah_isi[$item['id']] ?? null;
                                ?>
                                <tr>
                                    <td class="text-center ps-2 ps-md-4" style="font-weight: bold;"><?= $i + 1 ?></td>
                                    <td>
                                        <p class="fw-bold mb-1 text-dark" style="max-width: 25ch; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            <?= esc($item['nama_kinerja']) ?>
                                        </p>
                                        <small class="text-muted" style="display: block; max-width: 25ch; overflow: hidden; text-overflow: ellipsis;">
                                            Satuan: <?= esc($item['satuan']) ?>
                                        </small>
                                        <!-- Mobile display of hidden columns -->
                                        <small class="d-md-none d-lg-none d-xl-none text-muted" style="display: block; margin-top: 0.25rem;">
                                            Std: <span class="badge bg-light text-success border fw-bold" style="font-size: 0.7rem;">
                                                <?= (int) $item['standar_nilai'] ?>
                                            </span>
                                        </small>
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <span class="badge bg-light text-success border fw-bold" style="font-size: 0.75rem;">
                                            <?= (int) $item['standar_nilai'] ?> </span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm text-center border-2 <?= $lockInput ? 'bg-light' : '' ?>" 
                                            name="data[<?= $item['id'] ?>][value]" 
                                            value="<?= $val['value'] ?? '' ?>" 
                                            placeholder="0"
                                            style="font-size: 0.8rem;"
                                            <?= $lockInput ? 'readonly' : 'required' ?>> 
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <?php if($lockInput && !empty($val['link_bukti'])): ?>
                                            <a href="<?= esc($val['link_bukti']) ?>" target="_blank" class="btn btn-sm btn-outline-success" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        <?php else: ?>
                                            <input type="url" class="form-control form-control-sm border-2 <?= $lockInput ? 'bg-light' : '' ?>" 
                                                   name="data[<?= $item['id'] ?>][link_bukti]" 
                                                   value="<?= $val['link_bukti'] ?? '' ?>" 
                                                   placeholder="https://..."
                                                   style="font-size: 0.75rem;"
                                                   <?= $lockInput ? 'readonly' : '' ?>>
                                        <?php endif; ?>
                                    </td>
                                    <td class="d-none d-xl-table-cell pe-2 pe-md-4">
                                        <input type="text" class="form-control form-control-sm border-2 <?= $lockInput ? 'bg-light' : '' ?>" 
                                               name="data[<?= $item['id'] ?>][keterangan]" 
                                               value="<?= $val['keterangan'] ?? '' ?>" 
                                               placeholder="Catatan..."
                                               style="font-size: 0.75rem;"
                                               <?= $lockInput ? 'readonly' : '' ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white py-3 text-end" style="border-radius: 0 0 15px 15px;">
                    <?php if ($periode['status_aktif'] == 1) : ?>
                        <?php if ($hasData && !$editMode) : ?>
                            <a href="?periode=<?= $periode['id'] ?>&mode=edit" class="btn btn-warning px-5 py-2 shadow-sm fw-bold text-white" style="border-radius: 10px;">
                                <i class="bi bi-pencil-square me-2"></i> Sesuaikan Capaian Kinerja
                            </a>
                        <?php elseif (!empty($indikator)) : ?>
                            <button type="submit" class="btn btn-success px-5 py-2 shadow-sm fw-bold" style="border-radius: 10px;">
                                <i class="bi bi-save me-2"></i> Simpan Semua Capaian Kinerja
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>