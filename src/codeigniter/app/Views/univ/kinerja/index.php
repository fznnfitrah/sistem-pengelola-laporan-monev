<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Master Kinerja</h2>
            <p class="text-muted">Kelola indikator profil untuk capaian target unit dan prodi.</p>
        </div>
        <button class="btn btn-success btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-trophy me-1"></i> Tambah Indikator
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nama Indikator Kinerja</th>
                            <th class="text-center">Peruntukan</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($kinerja as $k): ?>
                        <tr>
                            <td class="fw-bold text-secondary"><?= $k['nama_kinerja'] ?></td>
                            <td class="text-center">
                                <?php if($k['jenis'] == 'prodi'): ?>
                                    <span class="badge bg-primary px-3">Khusus Prodi</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark px-3">Khusus Unit</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><span class="text-muted"><?= $k['satuan'] ?></span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning border-0" 
                                        onclick="btnEdit('<?= $k['id'] ?>', '<?= $k['nama_kinerja'] ?>', '<?= $k['jenis'] ?>', '<?= $k['satuan'] ?>')" 
                                        data-bs-toggle="modal" data-bs-target="#modalEdit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= base_url('univ/kinerja/hapus/'.$k['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus indikator ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
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
            <form action="<?= base_url('univ/kinerja/simpan') ?>" method="post">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah Indikator Kinerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA INDIKATOR</label>
                        <input type="text" name="nama_kinerja" class="form-control" placeholder="Contoh: Jumlah Publikasi Internasional" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">JENIS (PERUNTUKAN)</label>
                        <select name="jenis" class="form-select" required>
                            <option value="prodi">Program Studi (Prodi)</option>
                            <option value="unit">Unit Kerja / Lembaga</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">SATUAN</label>
                        <input type="text" name="satuan" class="form-control" placeholder="Contoh: Dokumen, Persentase, Judul" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success btn-rounded w-100">Simpan Indikator</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form action="<?= base_url('univ/kinerja/edit') ?>" method="post">
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-4 text-warning">Edit Indikator Kinerja</h5>
                    <input type="hidden" name="id" id="e_id">
                    <div class="mb-3">
                        <label class="small fw-bold">NAMA INDIKATOR</label>
                        <input type="text" name="nama_kinerja" id="e_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">JENIS</label>
                        <select name="jenis" id="e_jenis" class="form-select">
                            <option value="prodi">Program Studi (Prodi)</option>
                            <option value="unit">Unit Kerja / Lembaga</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">SATUAN</label>
                        <input type="text" name="satuan" id="e_satuan" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 btn-rounded text-white mt-2">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function btnEdit(id, nama, jenis, satuan) {
        document.getElementById('e_id').value = id;
        document.getElementById('e_nama').value = nama;
        document.getElementById('e_jenis').value = jenis;
        document.getElementById('e_satuan').value = satuan;
    }
</script>
<?= $this->endSection() ?>