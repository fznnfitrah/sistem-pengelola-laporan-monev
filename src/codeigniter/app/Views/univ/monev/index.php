<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Master Item Monev Per Periode</h2>
            <p class="text-muted small">Atur dokumen wajib berdasarkan periode semester yang aktif.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah" style="border-radius: 10px;">
            <i class="bi bi-file-earmark-plus me-1"></i> Tambah Item
        </button>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php 
    $currentPeriode = null; 
    $isFirst = true;

    foreach($monev as $m): 
        // Logika Pemisah: Jika ID Periode berubah, buat Card baru
        if ($currentPeriode !== $m['fk_setting_periode']): 
            if (!$isFirst) echo '</tbody></table></div></div></div>'; // Tutup tabel sebelumnya
            $currentPeriode = $m['fk_setting_periode'];
            $isFirst = false;
    ?>
        <div class="card border-0 shadow-sm mb-5" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white border-0 pt-4 ps-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-calendar3 fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Periode <?= esc($m['tahun_akademik']) ?></h5>
                        <span class="badge bg-light text-success border small"><?= esc($m['semester']) ?></span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 mt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="5%">No</th>
                                <th width="45%">Nama Item Monev</th>
                                <th width="25%">Keterangan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; endif; ?>

                        <tr>
                            <td class="ps-4 text-muted"><?= $no++ ?></td>
                            <td class="fw-bold text-dark"><?= esc($m['nama_monev']) ?></td>
                            <td><small class="text-muted"><?= esc($m['keterangan']) ?: '-' ?></small></td>
                            <td class="text-center">
                                <?php if($m['status'] == 1): ?>
                                    <span class="badge bg-success-soft text-success px-3 py-2">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-soft text-danger px-3 py-2">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning border-0" 
                                        onclick="btnEdit('<?= $m['id'] ?>', '<?= esc($m['nama_monev']) ?>', '<?= $m['status'] ?>', '<?= esc($m['keterangan']) ?>', '<?= $m['fk_setting_periode'] ?>')" 
                                        data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= base_url('univ/monev/hapus/'.$m['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus item ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
    <?php endforeach; ?>
    
    <?php if (!$isFirst) echo '</tbody></table></div></div></div>'; // Tutup card terakhir ?>

    <?php if(empty($monev)): ?>
        <div class="alert alert-light border text-center p-5">
            <i class="bi bi-folder2-open display-4 text-muted"></i>
            <p class="mt-3">Belum ada item monev yang dikonfigurasi.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .bg-success-soft { background-color: #e6fffa; color: #38b2ac; }
    .bg-danger-soft { background-color: #fff5f5; color: #e53e3e; }
    .mb-5 { margin-bottom: 3rem !important; }
</style>

<script>
    function btnEdit(id, nama, status, keterangan, fk_periode) {
        document.getElementById('e_id').value = id;
        document.getElementById('e_nama').value = nama;
        document.getElementById('e_status').value = status;
        document.getElementById('e_keterangan').value = keterangan;
        document.getElementById('e_fk_periode').value = fk_periode;
    }
</script>
<?= $this->endSection() ?>