<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-success mb-1">Input Akreditasi Baru</h4>
            <p class="text-muted small mb-0">Tambahkan riwayat akreditasi prodi (SK baru atau lampau).</p>
        </div>
        <a href="<?= base_url('prodi/akreditasi') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            
            <?php if (session()->has('validation')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Gagal Menyimpan!</strong> Mohon periksa kembali isian formulir di bawah.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('prodi/akreditasi/create') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row g-4">
                    <div class="col-lg-6 border-end">
                        <h6 class="text-uppercase text-success fw-bold small mb-3 border-bottom pb-2">
                            <i class="bi bi-award me-2"></i>Data Surat Keputusan (SK)
                        </h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Lembaga Akreditasi <span class="text-danger">*</span></label>
                            <select name="fk_lembaga" class="form-select <?= session('validation') && session('validation')->hasError('fk_lembaga') ? 'is-invalid' : '' ?>">
                                <option value="">-- Pilih Lembaga --</option>
                                <?php foreach ($lembaga as $L): ?>
                                    <option value="<?= $L['id'] ?>" <?= old('fk_lembaga') == $L['id'] ? 'selected' : '' ?>>
                                        <?= esc($L['nama_lembaga']) ?> (<?= esc($L['jenis_lembaga']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Wajib dipilih.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Peringkat <span class="text-danger">*</span></label>
                                <select name="peringkat" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Unggul" <?= old('peringkat') == 'Unggul' ? 'selected' : '' ?>>Unggul</option>
                                    <option value="Baik Sekali" <?= old('peringkat') == 'Baik Sekali' ? 'selected' : '' ?>>Baik Sekali</option>
                                    <option value="Baik" <?= old('peringkat') == 'Baik' ? 'selected' : '' ?>>Baik</option>
                                    <option value="A" <?= old('peringkat') == 'A' ? 'selected' : '' ?>>A</option>
                                    <option value="B" <?= old('peringkat') == 'B' ? 'selected' : '' ?>>B</option>
                                    <option value="C" <?= old('peringkat') == 'C' ? 'selected' : '' ?>>C</option>
                                    <option value="Tidak Terakreditasi" <?= old('peringkat') == 'Tidak Terakreditasi' ? 'selected' : '' ?>>Tidak Terakreditasi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Nilai Angka</label>
                                <input type="number" name="nilai" step="0.01" class="form-control" placeholder="Cth: 368" value="<?= old('nilai') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nomor SK <span class="text-danger">*</span></label>
                            <input type="text" name="no_sk" class="form-control" placeholder="Nomor Surat Keputusan" value="<?= old('no_sk') ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Tgl. SK Terbit <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_sk" class="form-control" value="<?= old('tgl_sk') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-danger">Tgl. Kadaluarsa <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_kadaluarsa" class="form-control border-danger" value="<?= old('tgl_kadaluarsa') ?>">
                                <div class="form-text text-danger" style="font-size: 0.7rem;">*Digunakan untuk hitung mundur.</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 ps-lg-4">
                        <h6 class="text-uppercase text-secondary fw-bold small mb-3 border-bottom pb-2">
                            <i class="bi bi-folder2-open me-2"></i>Data Pendukung
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Tahun Penyusunan</label>
                                <input type="number" name="tahun" class="form-control" placeholder="2025" value="<?= old('tahun') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Biaya (Rp)</label>
                                <input type="number" name="biaya" class="form-control" placeholder="0" value="<?= old('biaya') ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Tahap Pengajuan</label>
                                <select name="tahap_pengajuan" class="form-select">
                                    <option value="TS-1">TS-1</option>
                                    <option value="TS-2">TS-2</option>
                                    <option value="TS-3">TS-3</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Status Saat Ini</label>
                                <select name="tahap" class="form-select bg-light text-dark fw-bold">
                                    <option value="Selesai" selected>Selesai (SK Terbit)</option>
                                    <option value="Asesmen Lapangan">Asesmen Lapangan</option>
                                    <option value="Pengajuan">Pengajuan</option>
                                    <option value="Persiapan">Persiapan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Link Sertifikat (Google Drive) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="link" class="form-control" placeholder="https://..." value="<?= old('link') ?>">
                            </div>
                            <div class="form-text">Pastikan link dapat diakses publik (Open Access).</div>
                        </div>

                        <div class="d-grid pt-2">
                            <button type="submit" class="btn btn-success shadow-sm fw-bold py-2">
                                <i class="bi bi-save me-2"></i> Simpan Data Akreditasi
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?= $this->endSection() ?>