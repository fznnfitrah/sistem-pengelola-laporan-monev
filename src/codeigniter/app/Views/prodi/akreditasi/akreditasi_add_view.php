<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Input Akreditasi Baru</h5>
            <small class="text-muted">Tambahkan riwayat akreditasi prodi.</small>
        </div>
        <div class="card-body p-4">

            <form action="<?= base_url('prodi/akreditasi/create') ?>" method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-6 border-end">
                        <h6 class="text-success fw-bold mb-3"><i class="bi bi-file-earmark-text me-2"></i>DATA SK & STATUS</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Saat Ini <span class="text-danger">*</span></label>
                            <select name="tahap" id="status_saat_ini" class="form-select bg-light border-success" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Persiapan">Persiapan</option>
                                <option value="Pengajuan">Pengajuan</option>
                                <option value="Asesmen Lapangan">Asesmen Lapangan</option>
                                <option value="Selesai">Selesai (SK Terbit)</option>
                            </select>
                            <div class="form-text text-muted">Pilih "Selesai" untuk membuka input nilai & tanggal.</div>
                        </div>

                        <input type="hidden" name="tahap_pengajuan" value="TS-1">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lembaga Akreditasi <span class="text-danger">*</span></label>
                            <select name="fk_lembaga" id="fk_lembaga" class="form-select" required>
                                <option value="" data-biaya="0">-- Pilih Lembaga --</option>
                                <?php foreach ($lembaga as $l): ?>
                                    <option value="<?= $l['id'] ?>" data-biaya="<?= $l['biaya'] ?>">
                                        <?= $l['nama_lembaga'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Peringkat</label>
                                <select name="peringkat" id="peringkat" class="form-select" disabled>
                                    <option value="">-- Pilih Peringkat --</option>
                                    <option value="Unggul">Unggul</option>
                                    <option value="Baik Sekali">Baik Sekali</option>
                                    <option value="Baik">Baik</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Nilai Angka</label>
                                <input type="number" name="nilai" id="nilai_angka" class="form-control" placeholder="0" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor SK Akreditasi</label>
                            <input type="text" name="no_sk" id="no_sk" class="form-control" placeholder="Nomor Surat Keputusan" disabled>
                        </div>
                    </div>

                    <div class="col-md-6 ps-4">
                        <h6 class="text-success fw-bold mb-3"><i class="bi bi-calendar-event me-2"></i>PERIODE BERLAKU</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tgl. SK Terbit</label>
                            <input type="date" name="tgl_sk" id="tgl_sk_terbit" class="form-control" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Tgl. Kadaluarsa</label>
                            <input type="date" name="tgl_kadaluarsa" id="tgl_kadaluarsa" class="form-control border-danger" disabled>
                            <div class="form-text text-danger small">*Digunakan untuk hitung mundur dashboard</div>
                        </div>

                        <hr>

                        <h6 class="text-success fw-bold mb-3 mt-4"><i class="bi bi-bar-chart-fill me-2"></i>DATA TAHUN PENGAJUAN AKREDITASI (TS)</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">TS <span class="text-muted">(Saat Ini)</span></label>
                                <input type="number" name="ts" class="form-control bg-light" placeholder="Thn" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">TS-1 <span class="text-muted">(1 Thn Lalu)</span></label>
                                <input type="number" name="ts_1" class="form-control" placeholder="Thn" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">TS-2 <span class="text-muted">(2 Thn Lalu)</span></label>
                                <input type="number" name="ts_2" class="form-control" placeholder="Thn" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Tahun Penyusunan</label>
                                <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Biaya (Rp)</label>
                                <input type="number" name="biaya" id="biaya" class="form-control" value="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Sertifikat (Google Drive)</label>
                            <input type="url" name="link" class="form-control" placeholder="https://...">
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="<?= base_url('prodi/akreditasi') ?>" class="btn btn-light border me-2">Kembali</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>Simpan Data Akreditasi</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src=" <?= base_url('js/input_akreditasi.js') ?> "></script>

<?= $this->endSection() ?>