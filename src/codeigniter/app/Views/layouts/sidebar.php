<div class="sidebar d-flex flex-column flex-shrink-0 p-3 shadow-sm">

    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
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
                <a href="/users" class="nav-link <?= (uri_string() == 'users') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-person-gear me-2"></i> Kelola User
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 3 || session()->get('fk_roles') == 4) : ?>
            <li class="nav-item mt-2">
                <a href="/laporan/input" class="nav-link <?= (uri_string() == 'laporan/input') ? 'active' : 'text-dark' ?>">
                    <i class="bi bi-pencil-square me-2"></i> Input Laporan
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>