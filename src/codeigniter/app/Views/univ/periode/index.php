<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Setting Periode</h2>
            <p class="text-muted small">Kelola masa aktif semester untuk pelaporan monev dan capaian kinerja.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah" style="border-radius: 10px;">
            <i class="bi bi-calendar-plus me-1"></i> Tambah Periode
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="30%">Tahun Akademik</th>
                            <th>Semester</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($periode as $p): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-dark"><?= esc($p['tahun_akademik']) ?></td>
                            <td><?= esc($p['semester']) ?></td>
                            <td class="text-center">
                                <?php if($p['status_aktif'] == 1): ?>
                                    <span class="badge bg-success px-3 py-2" style="border-radius: 8px;">Aktif (Default)</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border px-3 py-2" style="border-radius: 8px;">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($p['status_aktif'] == 0): ?>
                                    <a href="<?= base_url('univ/periode/setAktif/'.$p['id']) ?>" class="btn btn-sm btn-primary px-3 shadow-sm me-1" style="border-radius: 8px;">Aktifkan</a>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger border-0" 
                                        onclick="konfirmasiHapus('<?= $p['id'] ?>', '<?= esc($p['tahun_akademik']) ?> - <?= esc($p['semester']) ?>')"
                                        data-bs-toggle="modal" data-bs-target="#modalHapus">
                                        <i class="bi bi-trash fs-6"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-secondary border-0" title="Periode aktif tidak bisa dihapus" disabled>
                                        <i class="bi bi-trash fs-6"></i>
                                    </button>
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

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/periode/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold text-success">Tambah Periode Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TAHUN AKADEMIK</label>
                        <input type="text" name="tahun_akademik" class="form-control border-2" placeholder="Contoh: 2025/2026" style="border-radius: 10px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">SEMESTER</label>
                        <select name="semester" class="form-select border-2" style="border-radius: 10px;" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm" style="border-radius: 12px;">Simpan Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px; width: 400px; margin: auto;">
            <div class="modal-header border-0 pt-4 px-4 justify-content-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #fff5f5;">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2.5rem;"></i>
                </div>
            </div>
            <div class="modal-body text-center px-4">
                <h5 class="fw-bold text-dark">Hapus Periode?</h5>
                <p class="text-muted small">
                    Apakah Anda yakin ingin menghapus periode <br>
                    <span id="nama_periode_hapus" class="fw-bold text-danger"></span>?
                </p>
                <div class="p-2 rounded-3 mt-2" style="background-color: #fee2e2;">
                    <p class="text-danger small mb-0 fw-bold">
                        <i class="bi bi-info-circle me-1"></i> Data Tagihan, Laporan, & Kinerja akan ikut terhapus permanen!
                    </p>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4 justify-content-center">
                <button type="button" class="btn btn-light px-4 py-2 fw-bold text-secondary" data-bs-dismiss="modal" style="border-radius: 12px;">Batal</button>
                <a href="#" id="btn_link_hapus" class="btn btn-danger px-4 py-2 fw-bold shadow-sm" style="border-radius: 12px;">Ya, Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    function konfirmasiHapus(id, nama) {
        document.getElementById('nama_periode_hapus').innerText = nama;
        document.getElementById('btn_link_hapus').href = "<?= base_url('univ/periode/hapus') ?>/" + id;
    }
</script>

<?= $this->endSection() ?>