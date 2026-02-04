<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 text-start">
        <div>
            <h2 class="fw-bold text-dark mb-1">Master Item Monev Per Periode</h2>
            <p class="text-muted small">Atur dokumen wajib berdasarkan periode semester yang aktif.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm px-4" onclick="btnAddItem()">
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
        if ($currentPeriode !== $m['fk_setting_periode']): 
            if (!$isFirst) echo '</tbody></table></div></div></div>'; 
            $currentPeriode = $m['fk_setting_periode'];
            $isFirst = false;
    ?>
        <div class="card border-0 shadow-sm mb-5" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white border-0 pt-4 ps-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                        <i class="bi bi-calendar3 fs-5"></i>
                    </div>
                    <div class="text-start">
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
                            <td class="fw-bold text-dark text-start"><?= esc($m['nama_monev']) ?></td>
                            <td class="text-start"><small class="text-muted"><?= esc($m['keterangan']) ?: '-' ?></small></td>
                            <td class="text-center">
                                <span class="badge rounded-pill <?= $m['status'] == 1 ? 'bg-success' : 'bg-danger' ?> bg-opacity-10 text-<?= $m['status'] == 1 ? 'success' : 'danger' ?> border px-3 py-2">
                                    <?= $m['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-warning rounded-pill px-3" 
                                            onclick='btnEdit(<?= json_encode($m) ?>)'>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="<?= base_url('univ/monev/hapus/'.$m['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus item ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
    <?php endforeach; ?>
    
    <?php if (!$isFirst) echo '</tbody></table></div></div></div>'; ?>

    <?php if(empty($monev)): ?>
        <div class="alert alert-light border text-center p-5" style="border-radius: 15px;">
            <i class="bi bi-folder2-open display-4 text-muted"></i>
            <p class="mt-3 text-muted">Belum ada item monev yang dikonfigurasi.</p>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalMonev" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success" id="modalMonevTitle">
                    <i class="bi bi-file-earmark-check me-2"></i><span>Tambah Item Monev</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formMonev" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="m_id">
                
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Periode <span class="text-danger">*</span></label>
                        <select name="fk_setting_periode" id="m_periode" class="form-select bg-light border-0 py-2" required>
                            <option value="" disabled selected>-- Pilih Periode --</option>
                            <?php foreach($periodes as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['tahun_akademik'] ?> - <?= $p['semester'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Item Monev <span class="text-danger">*</span></label>
                        <input type="text" name="nama_monev" id="m_nama" class="form-control bg-light border-0 py-2" placeholder="Contoh: Laporan Kemajuan" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Keterangan</label>
                        <textarea name="keterangan" id="m_keterangan" class="form-control bg-light border-0 py-2" rows="3" placeholder="Opsional..."></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="status" id="m_status" class="form-select bg-light border-0 py-2">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let monevModal;

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Modal Bootstrap
        monevModal = new bootstrap.Modal(document.getElementById('modalMonev'));
    });

    function btnAddItem() {
        document.getElementById('modalMonevTitle').querySelector('span').innerText = "Tambah Item Monev";
        const form = document.getElementById('formMonev');
        form.action = "<?= base_url('univ/monev/simpan') ?>"; // Sesuaikan URL simpan Anda
        form.reset();
        document.getElementById('m_id').value = "";
        monevModal.show();
    }

    function btnEdit(data) {
        document.getElementById('modalMonevTitle').querySelector('span').innerText = "Edit Item Monev";
        const form = document.getElementById('formMonev');
        form.action = "<?= base_url('univ/monev/update') ?>"; // Sesuaikan URL update Anda
        
        // Isi data ke dalam form
        document.getElementById('m_id').value = data.id;
        document.getElementById('m_nama').value = data.nama_monev;
        document.getElementById('m_status').value = data.status;
        document.getElementById('m_keterangan').value = data.keterangan;
        document.getElementById('m_periode').value = data.fk_setting_periode;
        
        monevModal.show();
    }
</script>
<?= $this->endSection() ?>