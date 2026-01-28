<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url('css/master.css') ?>">


<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center section-header">
        <div>
            <h2 class="fw-bold text-dark mb-1">Data Akademik</h2>
            <p class="text-muted mb-0">Manajemen Fakultas & Program Studi</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahFakultas">
                <i class="bi bi-building-add me-2"></i>Tambah Fakultas
            </button>

            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProdi">
                <i class="bi bi-plus-lg me-2"></i>Tambah Prodi
            </button>
        </div>
    </div>

    <?php if (empty($mfakultas)): ?>
        <div class="alert alert-light border text-center py-5 shadow-sm">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Belum ada data Fakultas. Silakan tambahkan data baru.</p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($mfakultas as $f): ?>
                <div class="col-12">
                    <div class="card card-fakultas">
                        <div class="fakultas-header">
                            <div class="d-flex align-items-center">
                                <span class="badge-id-fakultas me-3 shadow-sm"><?= $f['id'] ?></span>
                                <div>
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Fakultas</small>
                                    <h5 class="fw-bold text-dark mb-0">
                                        <?= str_ireplace('Fakultas', '', $f['nama_fakultas']) ?>
                                    </h5>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-link text-secondary p-0 me-2" onclick="btnEditFakultas('<?= $f['id'] ?>', '<?= $f['nama_fakultas'] ?>')" data-bs-toggle="modal" data-bs-target="#modalEditFakultas" title="Edit">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </button>
                                <button class="btn btn-link text-danger p-0" onclick="konfirmasiHapus('<?= base_url('univ/master/hapusFakultas/' . $f['id']) ?>')" title="Hapus">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <?php
                            $prodiTerkait = array_filter($prodi, function ($p) use ($f) {
                                return $p['fk_fakultas'] == $f['id'];
                            });
                            ?>

                            <?php if (empty($prodiTerkait)): ?>
                                <div class="empty-prodi">
                                    <small>Belum ada Program Studi.</small>
                                </div>
                            <?php else: ?>
                                <div class="scroll-area-prodi">
                                    <table class="table table-prodi table-hover">
                                        <thead>
                                            <tr>
                                                <th class="ps-4" width="10%">Kode</th>
                                                <th width="35%">Program Studi</th>
                                                <th width="10%">Jenjang</th>
                                                <th width="30%">Legalitas (SK Pendirian)</th>
                                                <th class="text-end pe-4" width="15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($prodiTerkait as $p): ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <span class="badge-id-prodi"><?= $p['id'] ?></span>
                                                    </td>

                                                    <td class="fw-bold text-dark">
                                                        <?= $p['nama_prodi'] ?>
                                                    </td>

                                                    <td>
                                                        <?php if (!empty($p['jenjang'])): ?>
                                                            <span class="badge bg-info text-dark bg-opacity-10 border border-info px-2 py-1" style="font-size: 0.75rem;">
                                                                <?= $p['jenjang'] ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted small">-</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <?php if (!empty($p['no_sk_pendirian'])): ?>
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                                                                    <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                                                                    <?= $p['no_sk_pendirian'] ?>
                                                                </span>

                                                                <?php if (!empty($p['tgl_sk_pendirian']) && $p['tgl_sk_pendirian'] != '0000-00-00'): ?>
                                                                    <span class="text-muted" style="font-size: 0.8rem;">
                                                                        <i class="bi bi-calendar3 me-1"></i>
                                                                        <?= date('d M Y', strtotime($p['tgl_sk_pendirian'])) ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-muted small italic">Data SK belum diisi</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="text-end pe-4">
                                                        <div class="btn-group shadow-sm" role="group">
                                                            <button class="btn btn-sm btn-white border text-warning"
                                                                onclick="btnEditProdi(
                                                                    '<?= $p['id'] ?>', 
                                                                    '<?= $p['fk_fakultas'] ?>', 
                                                                    '<?= $p['nama_prodi'] ?>',
                                                                    '<?= $p['fk_jenjang'] ?>',
                                                                    '<?= $p['no_sk_pendirian'] ?>',
                                                                    '<?= $p['tgl_sk_pendirian'] ?>'
                                                                )"
                                                                data-bs-toggle="modal" data-bs-target="#modalEditProdi" title="Edit Data">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-white border text-danger"
                                                                onclick="konfirmasiHapus('<?= base_url('univ/master/hapusProdi/' . $p['id']) ?>')" title="Hapus Data">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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
                        <input type="text" name="id" class="form-control form-control-lg border-2" placeholder="Contoh: FT, FEB" value="<?= old('id') ?>" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA FAKULTAS</label>
                        <input type="text" name="nama_fakultas" class="form-control form-control-lg border-2" placeholder="Nama Lengkap Fakultas" value="<?= old('nama_fakultas') ?>" required style="border-radius: 12px;">
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
                            <?php foreach ($mfakultas as $f): ?>
                                <option value="<?= $f['id'] ?>" <?= (old('fk_fakultas') == $f['id']) ? 'selected' : '' ?>><?= $f['nama_fakultas'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">KODE PRODI (ID)</label>
                        <input type="text" name="id" class="form-control form-control-lg border-2" placeholder="Contoh: INF, AKT" value="<?= old('id') ?>" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">NAMA PROGRAM STUDI</label>
                        <input type="text" name="nama_prodi" class="form-control form-control-lg border-2" placeholder="Nama Prodi" value="<?= old('nama_prodi') ?>" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">JENJANG PENDIDIKAN</label>
                        <select name="fk_jenjang" class="form-select form-select-lg border-2" required style="border-radius: 12px;">
                            <option value="">-- Pilih Jenjang --</option>
                            <?php foreach ($mjenjang as $j): ?>
                                <option value="<?= $j['id'] ?>" <?= (old('fk_jenjang') == $j['id']) ? 'selected' : '' ?>>
                                    <?= $j['jenjang'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">NO. SK PENDIRIAN</label>
                            <input type="text" name="no_sk_pendirian" class="form-control form-control-lg border-2"
                                placeholder="Nomor SK" value="<?= old('no_sk_pendirian') ?>" style="border-radius: 12px;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">TGL. SK PENDIRIAN</label>
                            <input type="date" name="tgl_sk_pendirian" class="form-control form-control-lg border-2"
                                value="<?= old('tgl_sk_pendirian') ?>" style="border-radius: 12px;">
                        </div>
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
                            <?php foreach ($mfakultas as $f): ?>
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
    // --- FUNGSI MODAL ---
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

    // --- LOGIKA SWEETALERT ---

    // 1. Cek Success Flashdata
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2500,
            showConfirmButton: false
        });
    <?php endif; ?>

    // 2. Cek Error Flashdata (Validation & Exception)
    <?php if (session()->getFlashdata('errors')) : ?>
        <?php
        $errors = session()->getFlashdata('errors');
        $list_error = '<ul class="text-start">';
        foreach ($errors as $e) {
            $list_error .= '<li>' . esc($e) . '</li>';
        }
        $list_error .= '</ul>';
        ?>

        Swal.fire({
            icon: 'error',
            title: 'Ups, ada kesalahan!',
            html: '<?= $list_error ?>',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tutup'
        });
    <?php endif; ?>

    // 3. Konfirmasi Hapus
    function konfirmasiHapus(url) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>

<?= $this->endSection() ?>