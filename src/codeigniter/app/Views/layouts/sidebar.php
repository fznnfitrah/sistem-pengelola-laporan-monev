<div class="sidebar d-flex flex-column flex-shrink-0 p-3 shadow-sm">
    <a href="<?= base_url('dashboard') ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <i class="bi bi-layout-wtf fs-3 me-2" style="color: #025964;"></i>
        <span class="judul">Sistem Monev</span>
    </a>

    <hr class="text-secondary">

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <?php if (session()->get('fk_roles') == 1) : ?>
            <li class="nav-item mt-2">
                <a href="<?= base_url('admin/roles') ?>" class="nav-link <?= (uri_string() == 'admin/roles') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-person-gear me-2"></i> Kelola Roles
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="<?= base_url('admin/users') ?>" class="nav-link <?= (uri_string() == 'admin/users') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-person-gear me-2"></i> Kelola User
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 2) : ?>
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Menu Fakultas</small>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('fakultas/laporan/input') ?>" class="nav-link <?= (uri_string() == 'fakultas/laporan/input') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-pencil-square me-2"></i> Input Laporan
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('fakultas/laporan/history') ?>" class="nav-link <?= (uri_string() == 'fakultas/laporan/history') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-clock-history me-2"></i> History Laporan
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 3) : ?>
            <li class="nav-item mt-2">
                <a href="<?= base_url('prodi/laporan/input') ?>" class="nav-link <?= (uri_string() == 'prodi/laporan/input') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-file-earmark-plus me-2"></i> Input Laporan
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="<?= base_url('prodi/laporan/history') ?>" class="nav-link <?= (uri_string() == 'prodi/laporan/history') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-clock-history me-2"></i> History Laporan
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="<?= base_url('prodi/kinerja/input') ?>" class="nav-link <?= (uri_string() == 'prodi/kinerja/input') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Laporan Kinerja Prodi
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 4) : ?>
            <li class="nav-item mt-2">
                <a href="<?= base_url('unit/laporan/input') ?>" class="nav-link <?= (uri_string() == 'unit/laporan/input') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-file-earmark-plus me-2"></i> Input Laporan
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="<?= base_url('unit/laporan/history') ?>" class="nav-link <?= (uri_string() == 'unit/laporan/history') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-clock-history me-2"></i> History Laporan
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="<?= base_url('unit/kinerja/input') ?>" class="nav-link <?= (uri_string() == 'unit/kinerja/input') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Laporan Kinerja Unit
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 5) : ?>
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Data Master</small>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('univ/periode') ?>" class="nav-link <?= (uri_string() == 'univ/periode') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-calendar-check me-2"></i> Setting Periode
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('univ/master') ?>" class="nav-link <?= (strpos(uri_string(), 'univ/master') !== false || uri_string() == 'univ/fakultas' || uri_string() == 'univ/prodi') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-diagram-3 me-2"></i> Fakultas & Prodi
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('univ/unit') ?>" class="nav-link <?= (uri_string() == 'univ/unit') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-building-gear me-2"></i> Unit & Lembaga
                </a>
            </li>
            <li class="nav-item mt-3">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Monitoring & Monev</small>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('univ/monev') ?>" class="nav-link <?= (uri_string() == 'univ/monev') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-file-earmark-medical me-2"></i> Item Monev
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('univ/kinerja') ?>" class="nav-link <?= (uri_string() == 'univ/kinerja') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-trophy me-2"></i> Master Kinerja
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="<?= base_url('univ/monitoring') ?>" class="nav-link <?= (uri_string() == 'univ/monitoring') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-eye me-2"></i> Monitoring
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>