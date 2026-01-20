<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<style>
    .card-master { border: none; border-radius: 15px; transition: 0.3s; }
    .card-master:hover { transform: translateY(-5px); }
    .table thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; color: #495057; font-weight: 600; }
    .btn-rounded { border-radius: 10px; padding: 8px 20px; }
    .badge-id { font-family: 'Courier New', Courier, monospace; letter-spacing: 1px; }
    .btn-action { padding: 0.25rem 0.5rem; font-size: 0.875rem; border-radius: 8px; }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Struktur Organisasi</h2>
            <p class="text-muted">Kelola data induk Fakultas dan Program Studi Universitas</p>
        </div>
        <div>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success border-0 shadow-sm py-2 px-4 mb-0 animate__animated animate__fadeIn">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card card-master shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-building me-2 text-success"></i>Daftar Fakultas</h5>
                    <button class="btn btn-success btn-sm btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahFakultas">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Fakultas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($mfakultas as $f): ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark border badge-id"><?= $f['id'] ?></span></td>
                                    <td class="fw-semibold text-secondary"><?= $f['nama_fakultas'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-action btn-outline-warning border-0" onclick="btnEditFakultas('<?= $f['id'] ?>', '<?= $f['nama_fakultas'] ?>')" data-bs-toggle="modal" data-bs-target="#modalEditFakultas">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="<?= base_url('univ/master/hapusFakultas/'.$f['id']) ?>" class="btn btn-action btn-outline-danger border-0" onclick="return confirm('Hapus fakultas <?= $f['nama_fakultas'] ?>?')">
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

        <div class="col-lg-7 mb-4">
            <div class="card card-master shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-mortarboard me-2 text-primary"></i>Program Studi</h5>
                    <button class="btn btn-primary btn-sm btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Prodi
                    </button>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Prodi</th>
                                    <th>Fakultas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($prodi as $p): ?>
                                <tr>
                                    <td><span class="badge bg-light text-primary border badge-id"><?= $p['id'] ?></span></td>
                                    <td class="fw-semibold text-secondary"><?= $p['nama_prodi'] ?></td>
                                    <td><span class="small text-muted italic"><?= $p['nama_fakultas'] ?></span></td>
                                    <td class="text-center">
                                        <button class="btn btn-action btn-outline-warning border-0" onclick="btnEditProdi('<?= $p['id'] ?>', '<?= $p['fk_fakultas'] ?>', '<?= $p['nama_prodi'] ?>')" data-bs-toggle="modal" data-bs-target="#modalEditProdi">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="<?= base_url('univ/master/hapusProdi/'.$p['id']) ?>" class="btn btn-action btn-outline-danger border-0" onclick="return confirm('Hapus prodi <?= $p['nama_prodi'] ?>?')">
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
    </div>
</div>

<div class="modal fade" id="modalTambahFakultas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Tambah Fakultas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('univ/master/simpanFakultas') ?>" method="post">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KODE FAKULTAS (ID)</label>
                        <input type="text" name="id" class="form-control form-control-lg border-2" placeholder="Contoh: FT, FEB" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA FAKULTAS</label>
                        <input type="text" name="nama_fakultas" class="form-control form-control-lg border-2" placeholder="Nama Lengkap Fakultas" required style="border-radius: 12px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-rounded px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditFakultas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Edit Fakultas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('univ/master/editFakultas') ?>" method="post">
                <div class="modal-body px-4">
                    <input type="hidden" name="id_lama" id="f_id_lama">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KODE FAKULTAS (ID)</label>
                        <input type="text" name="id" id="f_id" class="form-control form-control-lg border-2" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA FAKULTAS</label>
                        <input type="text" name="nama_fakultas" id="f_nama" class="form-control form-control-lg border-2" required style="border-radius: 12px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning btn-rounded px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahProdi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Tambah Program Studi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('univ/master/simpanProdi') ?>" method="post">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">PILIH FAKULTAS</label>
                        <select name="fk_fakultas" class="form-select form-select-lg border-2" required style="border-radius: 12px;">
                            <option value="">-- Pilih Induk Fakultas --</option>
                            <?php foreach($mfakultas as $f): ?>
                                <option value="<?= $f['id'] ?>"><?= $f['nama_fakultas'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KODE PRODI (ID)</label>
                        <input type="text" name="id" class="form-control form-control-lg border-2" placeholder="Contoh: INF, AKT" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA PROGRAM STUDI</label>
                        <input type="text" name="nama_prodi" class="form-control form-control-lg border-2" placeholder="Nama Prodi" required style="border-radius: 12px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-rounded px-4">Simpan Prodi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProdi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Edit Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('univ/master/editProdi') ?>" method="post">
                <div class="modal-body px-4">
                    <input type="hidden" name="id_lama" id="p_id_lama">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">PILIH FAKULTAS</label>
                        <select name="fk_fakultas" id="p_fk" class="form-select form-select-lg border-2" required style="border-radius: 12px;">
                            <?php foreach($mfakultas as $f): ?>
                                <option value="<?= $f['id'] ?>"><?= $f['nama_fakultas'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KODE PRODI (ID)</label>
                        <input type="text" name="id" id="p_id" class="form-control form-control-lg border-2" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA PROGRAM STUDI</label>
                        <input type="text" name="nama_prodi" id="p_nama" class="form-control form-control-lg border-2" required style="border-radius: 12px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light btn-rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning btn-rounded px-4">Update Prodi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function btnEditFakultas(id, nama) {
        document.getElementById('f_id_lama').value = id;
        document.getElementById('f_id').value = id;
        document.getElementById('f_nama').value = nama;
    }

    function btnEditProdi(id, fk, nama) {
        document.getElementById('p_id_lama').value = id;
        document.getElementById('p_id').value = id;
        document.getElementById('p_fk').value = fk;
        document.getElementById('p_nama').value = nama;
    }
</script>

<?= $this->endSection() ?>