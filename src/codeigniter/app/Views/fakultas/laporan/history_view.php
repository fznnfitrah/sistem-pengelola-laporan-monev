<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="fw-bold text-success">History Laporan Monev</h4>
        <p class="text-muted small">Daftar riwayat seluruh laporan yang telah dikirim oleh fakultas.</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="ps-4 text-center">No</th>
                            <th width="15%">Tanggal</th>
                            <th>Item Monev</th>
                            <th>Periode</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($history as $h): ?>
                        <tr>
                            <td class="ps-4 text-center"><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($h['create_at'])) ?></td>
                            <td><span class="fw-bold text-dark"><?= $h['nama_monev'] ?></span></td>
                            <td>
                                <span class="badge bg-light text-success border">
                                    <?= $h['tahun_akademik'] ?> - <?= $h['semester'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success px-3 shadow-sm" 
                                    style="border-radius: 8px;"
                                    onclick="showDetail('<?= date('d/m/Y', strtotime($h['create_at'])) ?>', '<?= addslashes($h['nama_monev']) ?>', '<?= $h['tahun_akademik'] ?> - <?= $h['semester'] ?>', '<?= addslashes($h['nama_fakultas']) ?>', '<?= $h['link_bukti'] ?>', '<?= addslashes($h['keterangan']) ?>')"
                                    data-bs-toggle="modal" data-bs-target="#modalDetail">
                                    <i class="bi bi-search me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($history)): ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted italic">Belum ada riwayat pengiriman laporan.</td></tr>
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
                <h5 class="fw-bold text-success"><i class="bi bi-file-earmark-text me-2"></i>Rincian Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="small text-muted d-block">Tanggal Kirim</label>
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
                        <label class="small text-muted d-block">Fakultas Pengirim</label>
                        <span id="d_fakultas" class="fw-bold text-success small"></span>
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
    function showDetail(tanggal, monev, periode, fakultas, link, keterangan) {
        document.getElementById('d_tanggal').innerText = tanggal;
        document.getElementById('d_monev').innerText = monev;
        document.getElementById('d_periode').innerText = periode;
        document.getElementById('d_fakultas').innerText = fakultas;
        document.getElementById('d_keterangan').innerText = keterangan || 'Tidak ada catatan.';
        document.getElementById('d_link').href = link;
    }
</script>
<?= $this->endSection() ?>