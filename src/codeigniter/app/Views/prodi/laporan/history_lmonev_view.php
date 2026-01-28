<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="fw-bold text-success mb-1">History Laporan Monev Prodi</h4>
        <p class="text-muted small">Daftar riwayat seluruh laporan yang telah dikirim oleh program studi.</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="ps-4">No</th>
                            <th width="15%">Waktu Upload</th>
                            <th class="text-start">Item Monev</th>
                            <th>Periode</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($laporan as $row): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>

                                <td>
                                    <div class="fw-bold text-dark">
                                        <?= date('d/m/Y', strtotime($row['create_at'])) ?>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= date('H:i', strtotime($row['create_at'])) ?> WIB
                                    </small>

                                    <?php if (!empty($row['update_at']) && $row['update_at'] != $row['create_at']): ?>
                                        <div class="mt-1 border-top pt-1">
                                            <small class="text-warning fst-italic" style="font-size: 0.7rem;">
                                                <i class="bi bi-pencil-fill"></i> Diedit: <br>
                                                <?= date('d/m H:i', strtotime($row['update_at'])) ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start">
                                    <span class="fw-bold text-dark"><?= esc($row['nama_monev']) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-success border">
                                        <?= esc($row['tahun_akademik']) ?> - <?= esc($row['semester']) ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success px-3 shadow-sm"
                                        style="border-radius: 8px;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail"

                                        /* Data Tanggal Lengkap Format 24 Jam */
                                        data-tanggal="<?= date('d/m/Y H:i', strtotime($row['create_at'])) ?> WIB"

                                        data-monev="<?= esc($row['nama_monev']) ?>"
                                        data-periode="<?= esc($row['tahun_akademik']) ?> - <?= esc($row['semester']) ?>"
                                        data-prodi="<?= esc($row['nama_prodi']) ?>"
                                        data-link="<?= esc($row['link_bukti']) ?>"
                                        data-keterangan="<?= esc($row['keterangan'] ?? '-') ?>">

                                        <i class="bi bi-search me-1"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($laporan)): ?>
                            <tr>
                                <td colspan="5" class="py-5 text-muted italic">Belum ada riwayat pengiriman laporan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-success"><i class="bi bi-file-earmark-text me-2"></i>Rincian Laporan Prodi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="small text-muted d-block">Waktu Kirim</label>
                        <span id="d_tanggal" class="fw-bold text-dark small"></span>
                    </div>
                    <div class="col-6">
                        <label class="small text-muted d-block">Periode</label>
                        <span id="d_periode" class="fw-bold text-dark small"></span>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted d-block">Item Monev</label>
                        <span id="d_monev" class="fw-bold text-dark small"></span>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted d-block">Program Studi Pengirim</label>
                        <span id="d_prodi" class="fw-bold text-success small"></span>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 border">
                            <label class="small text-muted d-block mb-1">Catatan Pengirim:</label>
                            <span id="d_keterangan" class="small italic text-secondary"></span>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <a href="#" id="d_link" target="_blank" class="btn btn-success w-100 py-2 shadow-sm fw-bold" style="border-radius: 10px;">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Buka Dokumen Bukti
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    var modalDetail = document.getElementById('modalDetail');
    modalDetail.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        // Ambil data
        var tanggal = button.getAttribute('data-tanggal');
        var monev = button.getAttribute('data-monev');
        var periode = button.getAttribute('data-periode');
        var prodi = button.getAttribute('data-prodi');
        var link = button.getAttribute('data-link');
        var keterangan = button.getAttribute('data-keterangan');

        // Isi ke modal
        document.getElementById('d_tanggal').textContent = tanggal;
        document.getElementById('d_monev').textContent = monev;
        document.getElementById('d_periode').textContent = periode;
        document.getElementById('d_prodi').textContent = prodi;
        document.getElementById('d_keterangan').textContent = keterangan;
        document.getElementById('d_link').href = link;
    });
</script>
<?= $this->endSection() ?>