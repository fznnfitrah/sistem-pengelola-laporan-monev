<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="fw-bold text-success mb-1">History Laporan Monev Unit</h4>
        <p class="text-muted small">Daftar riwayat seluruh laporan yang telah dikirim oleh unit.</p>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="ps-4">No</th>
                            <th width="15%">Tanggal</th>
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
                                <td><?= date('d/m/Y', strtotime($row['create_at'])) ?></td>
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

                                        data-tanggal="<?= date('d/m/Y', strtotime($row['create_at'])) ?>"
                                        data-monev="<?= esc($row['nama_monev']) ?>"
                                        data-periode="<?= esc($row['tahun_akademik']) ?> - <?= esc($row['semester']) ?>"
                                        data-unit="<?= esc($row['nama_unit'] ?? 'Unit Kerja') ?>"
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
                <h5 class="fw-bold text-success"><i class="bi bi-file-earmark-text me-2"></i>Rincian Laporan Unit</h5>
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
                        <label class="small text-muted d-block">Unit Pengirim</label>
                        <span id="d_unit" class="fw-bold text-success small"></span>
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

<!-- <script>
    function showDetail(tanggal, monev, periode, unit, link, keterangan) {
        document.getElementById('d_tanggal').innerText = tanggal;
        document.getElementById('d_monev').innerText = monev;
        document.getElementById('d_periode').innerText = periode;
        document.getElementById('d_unit').innerText = unit;
        document.getElementById('d_keterangan').innerText = keterangan || 'Tidak ada catatan.';
        document.getElementById('d_link').href = link;
    }
</script> -->

<script>
    // Ambil elemen modal
    let modalDetail = document.getElementById('modalDetail');

    // Jalankan fungsi saat modal dibuka
    modalDetail.addEventListener('show.bs.modal', function(event) {
        // Tombol yang diklik
        let button = event.relatedTarget;

        // Ambil data dari atribut data-* tombol tersebut
        let tanggal = button.getAttribute('data-tanggal');
        let monev = button.getAttribute('data-monev');
        let periode = button.getAttribute('data-periode');
        let unit = button.getAttribute('data-unit');
        let link = button.getAttribute('data-link');
        let keterangan = button.getAttribute('data-keterangan');

        // Masukkan ke dalam elemen Modal
        document.getElementById('d_tanggal').innerText = tanggal;
        document.getElementById('d_monev').innerText = monev;
        document.getElementById('d_periode').innerText = periode;

        // Pastikan ID ini ada di HTML Modal Anda
        document.getElementById('d_unit').innerText = unit;

        document.getElementById('d_keterangan').innerText = keterangan;
        document.getElementById('d_link').href = link;
    });
</script>
<?= $this->endSection() ?>