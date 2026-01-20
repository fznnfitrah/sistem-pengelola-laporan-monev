<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Input Laporan Monev</h5>
                    <small>Periode Aktif: <strong><?= esc($periode['tahun_akademik']) ?> (<?= esc($periode['semester']) ?>)</strong></small>
                </div>

                <div class="card-body">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            Laporan yang sudah dikirim <strong>tidak dapat diubah atau dihapus</strong>. Pastikan data benar sebelum simpan.
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('prodi/laporan/save') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Jenis Laporan <span class="text-danger">*</span></label>
                            <select name="fk_monev" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Jenis Laporan --</option>
                                <?php foreach ($jenis_monev as $m) : ?>
                                    <option value="<?= $m['id'] ?>" <?= (old('fk_monev') == $m['id']) ? 'selected' : '' ?>>
                                        <?= esc($m['nama_monev']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Bukti Dokumen (Google Drive/Cloud) <span class="text-danger">*</span></label>
                            <input type="url" name="link_bukti" class="form-control"
                                placeholder="https://docs.google.com/..."
                                value="<?= old('link_bukti') ?>" required>
                            <div class="form-text">Pastikan link dapat diakses (Public/Anyone with the link).</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan / Judul Laporan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" rows="3"
                                placeholder="Contoh: Laporan Evaluasi Pembelajaran Semester Genap..." required><?= old('keterangan') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('prodi/laporan/history') ?>" class="btn btn-secondary">Lihat Riwayat</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>