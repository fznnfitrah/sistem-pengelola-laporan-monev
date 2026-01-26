<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-success mb-0">Laporan Capaian Kinerja (Unit / Lembaga)</h5>
                <p class="text-muted small mb-0">Data realisasi kinerja berdasarkan indikator yang telah ditetapkan.</p>
            </div>
            
            <form action="" method="get" class="d-flex gap-2">
                <select name="periode" class="form-select border-2" style="width: 300px; border-radius: 10px;">
                    <?php foreach ($semua_periode as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= ($p['id'] == $periode['id']) ? 'selected' : '' ?>>
                            <?= esc($p['tahun_akademik']) ?> - <?= esc($p['semester']) ?> 
                            <?= ($p['status_aktif'] == 1) ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 10px;">Pilih</button>
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
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="5%" class="ps-4">No</th>
                                <th width="30%" class="text-start">Indikator Kinerja</th>
                                <th width="10%">Standar Univ</th>
                                <th width="12%">Realisasi</th>
                                <th width="20%">Bukti Dukung (Link)</th>
                                <th class="pe-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($indikator as $i => $item) : ?>
                                <?php 
                                    $val = $sudah_isi[$item['id']] ?? null;
                                ?>
                                <tr>
                                    <td class="text-center ps-4"><?= $i + 1 ?></td>
                                    <td>
                                        <p class="fw-bold mb-0 text-dark"><?= esc($item['nama_kinerja']) ?></p>
                                        <small class="text-muted">Satuan: <?= esc($item['satuan']) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-success border fw-bold" style="font-size: 0.9rem;">
                                            <?= (int) $item['standar_nilai'] ?> </span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control text-center border-2 <?= $lockInput ? 'bg-light' : '' ?>" 
                                            name="data[<?= $item['id'] ?>][value]" 
                                            value="<?= $val['value'] ?? '' ?>" 
                                            placeholder="0"
                                            <?= $lockInput ? 'readonly' : 'required' ?>> 
                                    </td>
                                    <td>
                                        <?php if($lockInput && !empty($val['link_bukti'])): ?>
                                            <a href="<?= esc($val['link_bukti']) ?>" target="_blank" class="btn btn-sm btn-outline-success w-100">
                                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Bukti
                                            </a>
                                        <?php else: ?>
                                            <input type="url" class="form-control form-control-sm border-2 <?= $lockInput ? 'bg-light' : '' ?>" 
                                                   name="data[<?= $item['id'] ?>][link_bukti]" 
                                                   value="<?= $val['link_bukti'] ?? '' ?>" 
                                                   placeholder="https://..."
                                                   <?= $lockInput ? 'readonly' : '' ?>>
                                        <?php endif; ?>
                                    </td>
                                    <td class="pe-4">
                                        <input type="text" class="form-control form-control-sm border-2 <?= $lockInput ? 'bg-light' : '' ?>" 
                                               name="data[<?= $item['id'] ?>][keterangan]" 
                                               value="<?= $val['keterangan'] ?? '' ?>" 
                                               placeholder="Catatan..."
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