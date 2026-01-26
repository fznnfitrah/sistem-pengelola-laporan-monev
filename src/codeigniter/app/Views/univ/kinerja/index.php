<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Master Kinerja</h2>
            <p class="text-muted">Kelola indikator profil dan standar minimal capaian target unit dan prodi.</p>
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
                            <th class="text-center">Standar Univ</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($kinerja as $k): ?>
                        <tr>
                            <td class="fw-bold text-secondary"><?= esc($k['nama_kinerja']) ?></td>
                            <td class="text-center">
                                <?php if($k['jenis'] == 'prodi'): ?>
                                    <span class="badge bg-primary px-3 text-white">Khusus Prodi</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark px-3">Khusus Unit</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><span class="text-muted"><?= esc($k['satuan']) ?></span></td>
                            <td class="text-center"><span class="fw-bold text-success"><?= (int)$k['standar_nilai'] ?></span></td>
                            <td class="text-center">
                                <?php if($k['status'] == 1): ?>
                                    <span class="badge bg-success shadow-sm" style="font-size: 0.7rem;">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary shadow-sm" style="font-size: 0.7rem;">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning border-0" 
                                        onclick="btnEdit('<?= $k['id'] ?>', '<?= addslashes($k['nama_kinerja']) ?>', '<?= $k['jenis'] ?>', '<?= $k['satuan'] ?>', '<?= (int)$k['standar_nilai'] ?>', '<?= $k['status'] ?>')" 
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
                        <input type="text" name="nama_kinerja" class="form-control shadow-sm" placeholder="Contoh: Jumlah Publikasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">JENIS (PERUNTUKAN)</label>
                        <select name="jenis" class="form-select shadow-sm" required>
                            <option value="prodi">Program Studi (Prodi)</option>
                            <option value="unit">Unit Kerja / Lembaga</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">SATUAN</label>
                            <input type="text" name="satuan" class="form-control shadow-sm" placeholder="Contoh: Dokumen" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">STANDAR NILAI</label>
                            <input type="number" name="standar_nilai" class="form-control shadow-sm" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-success btn-rounded w-100 shadow-sm">Simpan Indikator</button>
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
                        <input type="text" name="nama_kinerja" id="e_nama" class="form-control shadow-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">JENIS</label>
                        <select name="jenis" id="e_jenis" class="form-select shadow-sm">
                            <option value="prodi">Program Studi (Prodi)</option>
                            <option value="unit">Unit Kerja / Lembaga</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">SATUAN</label>
                            <input type="text" name="satuan" id="e_satuan" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">STANDAR NILAI</label>
                            <input type="number" name="standar_nilai" id="e_standar" class="form-control shadow-sm">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">STATUS AKTIF</label>
                        <select name="status" id="e_status" class="form-select shadow-sm">
                            <option value="1">Aktif (Muncul di Prodi/Unit)</option>
                            <option value="0">Non-Aktif (Sembunyikan)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 btn-rounded text-white mt-2 shadow-sm">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function btnEdit(id, nama, jenis, satuan, standar, status) {
        document.getElementById('e_id').value = id;
        document.getElementById('e_nama').value = nama;
        document.getElementById('e_jenis').value = jenis;
        document.getElementById('e_satuan').value = satuan;
        document.getElementById('e_standar').value = standar;
        document.getElementById('e_status').value = status;
    }
</script>
<?= $this->endSection() ?>