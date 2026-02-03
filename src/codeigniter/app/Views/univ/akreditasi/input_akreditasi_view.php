<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Input Akreditasi (Admin Univ)</h2>
            <p class="text-muted">Bantu input data akreditasi untuk Program Studi.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('validation')) : ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i> Terdapat kesalahan input. Silakan periksa kembali.
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="<?= base_url('univ/akreditasi/simpan') ?>" method="post" enctype="multipart/form-data">

                <div class="bg-light p-3 rounded-3 mb-4 border border-primary border-opacity-25">
                    <label class="form-label fw-bold text-primary"><i class="bi bi-building me-2"></i>PILIH PROGRAM STUDI <span class="text-danger">*</span></label>
                    <select name="fk_prodi" class="form-select form-select-lg" required>
                        <option value="">-- Cari / Pilih Prodi --</option>
                        <?php foreach ($prodi as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= (old('fk_prodi') == $p['id']) ? 'selected' : '' ?>>
                                <?= $p['nama_prodi'] ?> - <?= $p['nama_jenjang'] ?? '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text">Pilih prodi yang datanya akan Anda inputkan.</div>
                </div>
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h6 class="text-success fw-bold mb-3"><i class="bi bi-file-earmark-text me-2"></i>DATA SK & STATUS</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Saat Ini <span class="text-danger">*</span></label>
                            <select name="tahap" id="status_saat_ini" class="form-select bg-light border-success" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Persiapan" <?= old('tahap') == 'Persiapan' ? 'selected' : '' ?>>Persiapan</option>
                                <option value="Pengajuan" <?= old('tahap') == 'Pengajuan' ? 'selected' : '' ?>>Pengajuan</option>
                                <option value="Asesmen Lapangan" <?= old('tahap') == 'Asesmen Lapangan' ? 'selected' : '' ?>>Asesmen Lapangan</option>
                                <option value="Selesai" <?= old('tahap') == 'Selesai' ? 'selected' : '' ?>>Selesai (SK Terbit)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lembaga Akreditasi (Nasional) <span class="text-danger">*</span></label>
                            <select name="fk_lembaga" id="fk_lembaga" class="form-select" required>
                                <option value="" data-biaya="0">-- Pilih Lembaga Nasional --</option>
                                <?php foreach ($lembaga as $l): ?>
                                    <?php if ($l['jenis_lembaga'] == 'Nasional'): // Filter Nasional 
                                    ?>
                                        <option value="<?= $l['id'] ?>" data-biaya="<?= $l['biaya'] ?>">
                                            <?= $l['nama_lembaga'] ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-primary">
                                <i class="bi bi-globe me-1"></i> Lembaga Akreditasi Internasional (Opsional)
                            </label>
                            <select name="fk_lembaga_internasional" id="fk_lembaga_inter" class="form-select border-primary bg-primary bg-opacity-10">
                                <option value="">-- Tidak Ada / Kosongkan --</option>
                                <?php foreach ($lembaga as $l): ?>
                                    <?php if ($l['jenis_lembaga'] == 'Internasional'): // Filter Internasional 
                                    ?>
                                        <option value="<?= $l['id'] ?>">
                                            <?= $l['nama_lembaga'] ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-muted">Silakan pilih jika Prodi memiliki akreditasi internasional.</div>
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
                                <input type="number" name="nilai" id="nilai_angka" class="form-control" placeholder="0" value="<?= old('nilai') ?>" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor SK Akreditasi</label>
                            <input type="text" name="no_sk" id="no_sk" class="form-control" placeholder="Nomor Surat Keputusan" value="<?= old('no_sk') ?>">
                        </div>
                    </div>

                    <div class="col-md-6 ps-4">
                        <h6 class="text-success fw-bold mb-3"><i class="bi bi-calendar-event me-2"></i>PERIODE BERLAKU</h6>

                        <!-- <div class="mb-3">
                            <label class="form-label fw-bold">Tgl. SK Terbit</label>
                            <input type="date" name="tgl_sk" id="tgl_sk_terbit" class="form-control" value="<?= old('tgl_sk') ?>" disabled>
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Tgl. Kadaluarsa</label>
                            <input type="date" name="tgl_kadaluarsa" id="tgl_kadaluarsa" class="form-control border-danger" value="<?= old('tgl_kadaluarsa') ?>" disabled>
                        </div>

                        <hr>

                        <h6 class="text-success fw-bold mb-3 mt-4"><i class="bi bi-bar-chart-fill me-2"></i>DATA MAHASISWA (TS)</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">TS (Thn)</label>
                                <input type="number" name="ts" class="form-control bg-light" placeholder="Saat Ini" value="<?= old('ts') ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">TS-1 (Thn)</label>
                                <input type="number" name="ts_1" class="form-control" placeholder="-1 Tahun" value="<?= old('ts_1') ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small">TS-2 (Thn)</label>
                                <input type="number" name="ts_2" class="form-control" placeholder="-2 Tahun" value="<?= old('ts_2') ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Tahun Penyusunan</label>
                                <input type="number" name="tahun" class="form-control" value="<?= old('tahun', date('Y')) ?>">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Biaya (Rp)</label>
                                <input type="number" name="biaya" id="biaya" class="form-control" value="<?= old('biaya', 0) ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Sertifikat</label>
                            <input type="url" name="link" class="form-control" placeholder="https://..." value="<?= old('link') ?>">
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="<?= base_url('univ/monitoring') ?>" class="btn btn-light border me-2">Kembali</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>Simpan Data</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. LOGIKA STATUS SELESAI ---
        const statusSelect = document.getElementById('status_saat_ini');
        const targetFields = [
            document.getElementById('peringkat'),
            document.getElementById('nilai_angka'),
            // document.getElementById('tgl_sk_terbit'),
            document.getElementById('tgl_kadaluarsa'),
            document.getElementById('no_sk')
        ];

        function checkStatus() {
            if (statusSelect.value === 'Selesai') {
                targetFields.forEach(field => {
                    field.removeAttribute('disabled');
                    if (field.id === 'nilai_angka') {
                        field.required = false;
                    } else {
                        field.required = true;
                    }
                    // field.required = true;
                });
            } else {
                targetFields.forEach(field => {
                    field.setAttribute('disabled', 'disabled');
                    field.required = false;
                    field.value = ''; // jika ingin mereset saat status berubah
                });
            }
        }
        statusSelect.addEventListener('change', checkStatus);
        checkStatus(); // Run on load

        // --- 2. LOGIKA BIAYA LEMBAGA ---
        const selectLembaga = document.getElementById('fk_lembaga');
        const inputBiaya = document.getElementById('biaya');

        selectLembaga.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const biayaDefault = selectedOption.getAttribute('data-biaya');
            if (biayaDefault) inputBiaya.value = biayaDefault;
            else inputBiaya.value = 0;
        });
    });
</script>

<?= $this->endSection() ?>