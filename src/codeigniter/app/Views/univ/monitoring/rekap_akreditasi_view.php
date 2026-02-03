<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-success">Full Rekap Report Akreditasi Prodi</h4>
        <a href="<?= base_url('univ/monitoring/akreditasi') ?>" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle text-center mb-0" style="font-size: 10px; min-width: 1600px;">
                    <thead class="table-dark text-uppercase" style="font-size: 10px;">
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2" class="text-start ps-3">Program Studi</th>
                            <th rowspan="2">Jenjang</th>
                            <th rowspan="2">No. SK Pendirian</th>
                            <th rowspan="2">Tgl. SK Pendirian</th>
                            <th rowspan="2">Fakultas</th>
                            <th rowspan="2" class="bg-primary">Akre Internasional</th>
                            <th rowspan="2">Peringkat</th>
                            <th rowspan="2">Nilai</th>
                            <th rowspan="2">Nomor SK Akreditasi</th>
                            <th rowspan="2">Kadaluarsa</th>
                            <th rowspan="2">Sisa (Bulan)</th>
                            <th rowspan="2">Persiapan H-6</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2">Lembaga</th>
                            <th rowspan="2">Biaya</th>
                            <th colspan="3">Data Tahun Pengajuan (TS)</th>
                        </tr>
                        <tr>
                            <th>TS</th>
                            <th>TS-1</th>
                            <th>TS-2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($rekap as $r) : ?>
                            <tr class="<?= empty($r['tgl_kadaluarsa']) ? 'bg-light' : '' ?>">
                                <td><?= $no++ ?></td>
                                <td class="text-start ps-3 fw-bold"><?= esc($r['nama_prodi']) ?></td>
                                <td><?= esc($r['jenjang']) ?></td>

                                <td class="small"><?= esc($r['no_sk_pendirian'] ?: '-') ?></td>
                                <td>
                                    <?= (!empty($r['tgl_sk_pendirian']) && $r['tgl_sk_pendirian'] != '0000-00-00')
                                        ? date('d-M-y', strtotime($r['tgl_sk_pendirian']))
                                        : '-' ?>
                                </td>

                                <td><?= esc($r['nama_fakultas']) ?></td>

                                <td class="fw-bold <?= $r['akre_internasional'] == 'Ya' ? 'text-primary' : '' ?>">
                                    <?= $r['akre_internasional'] ?>
                                </td>

                                <td><span class="badge <?= empty($r['peringkat']) ? 'bg-secondary' : 'bg-primary' ?>"><?= esc($r['peringkat'] ?: '-') ?></span></td>
                                <td><?= esc($r['nilai'] ?: '-') ?></td>
                                <td class="small"><?= esc($r['no_sk_akreditasi'] ?: '-') ?></td>
                                <td><?= $r['tgl_kadaluarsa'] ? date('d-M-y', strtotime($r['tgl_kadaluarsa'])) : '-' ?></td>

                                <td class="<?= is_numeric($r['sisa_bulan']) && $r['sisa_bulan'] < 0 ? 'bg-danger text-white' : '' ?>">
                                    <?= $r['sisa_bulan'] ?>
                                </td>

                                <td class="text-primary fw-bold"><?= $r['tgl_persiapan'] ?></td>
                                <td class="text-center">
                                    <?php
                                    // Logika Warna Badge Sederhana
                                    $badgeWarna = 'bg-secondary'; // Default (Abu-abu)

                                    if ($r['tahap'] == 'Selesai') {
                                        $badgeWarna = 'bg-success'; // Hijau
                                    } elseif ($r['tahap'] == 'Persiapan') {
                                        $badgeWarna = 'bg-warning text-dark'; // Kuning
                                    } elseif ($r['tahap'] == 'Pengajuan') {
                                        $badgeWarna = 'bg-info text-dark'; // Biru Muda
                                    } elseif ($r['tahap'] == 'Asesmen Lapangan') {
                                        $badgeWarna = 'bg-primary'; // Biru Tua
                                    }
                                    ?>
                                    <span class="badge <?= $badgeWarna ?> rounded-pill">
                                        <?= esc($r['tahap']) ?>
                                    </span>
                                </td>
                                <td><?= esc($r['nama_lembaga'] ?: '-') ?></td>
                                <td><?= $r['biaya'] ? number_format($r['biaya'], 0, ',', '.') : '-' ?></td>
                                <td><?= esc($r['ts'] ?: '-') ?></td>
                                <td><?= esc($r['ts-1'] ?: '-') ?></td>
                                <td><?= esc($r['ts-2'] ?: '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <h6 class="fw-bold small">*Update <?= $tgl_update ?></h6>
            <table class="table table-bordered border-dark text-center align-middle" style="font-size: 13px;">
                <thead class="bg-light">
                    <tr class="fw-bold">
                        <th colspan="2" class="text-start ps-3">TABULASI DATA AKREDITASI PS DI UTM</th>
                        <th width="15%">JUMLAH</th>
                        <th width="20%">PERSENTASE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tabulasi as $label => $jumlah):
                        $persen = ($total > 0) ? ($jumlah / $total) * 100 : 0;
                    ?>
                        <tr>
                            <td colspan="2" class="text-start ps-3"><?= $label ?></td>
                            <td><?= $jumlah ?></td>
                            <td><?= number_format($persen, 2) ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="fw-bold bg-light">
                        <td colspan="2" class="text-end pe-3">Jumlah Total</td>
                        <td><?= $total ?></td>
                        <td>100.00%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-5 offset-md-1">
            <table class="table table-bordered border-dark text-center align-middle mt-4" style="font-size: 13px;">
                <thead class="bg-light">
                    <tr class="fw-bold">
                        <th class="text-start ps-3">JUMLAH AKREDITASI PRODI</th>
                        <th width="20%">JUMLAH</th>
                        <th width="20%">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Penggabungan kategori sesuai Gambar 4
                    $cat1 = $tabulasi['A'] + $tabulasi['Unggul'];
                    $cat2 = $tabulasi['B'] + $tabulasi['Baik Sekali'];
                    $cat3 = $tabulasi['C'] + $tabulasi['Baik'] + $tabulasi['Belum Terakreditasi'];
                    ?>
                    <tr>
                        <td class="text-start ps-3">A + UNGGUL</td>
                        <td><?= $cat1 ?></td>
                        <td><?= ($total > 0) ? round(($cat1 / $total) * 100) : 0 ?>%</td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3">B + BAIK SEKALI</td>
                        <td><?= $cat2 ?></td>
                        <td><?= ($total > 0) ? round(($cat2 / $total) * 100) : 0 ?>%</td>
                    </tr>
                    <tr>
                        <td class="text-start ps-3">C + BAIK + BELUM</td>
                        <td><?= $cat3 ?></td>
                        <td><?= ($total > 0) ? round(($cat3 / $total) * 100) : 0 ?>%</td>
                    </tr>
                    <tr class="fw-bold bg-light">
                        <td class="text-start ps-3">JUMLAH TOTAL</td>
                        <td><?= $total ?></td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?= $this->endSection() ?>