<div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 260px; background-color: #0f172a; min-height: 100vh; border-right: 1px solid #1e293b;">

    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-tornado fs-3 me-2 text-primary"></i>
        <span class="fs-4 fw-bold">Logo Universitas</span>
    </a>

    <hr style="border-color: #334155;">

    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item">
            <a href="/dashboard" class="nav-link active">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <?php if (session()->get('fk_roles') == 1) : ?>
            <li class="nav-item mt-1">
                <a href="/users" class="nav-link text-white-50">
                    <i class="bi bi-person-gear me-2"></i> Kelola User
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="/master-data" class="nav-link text-white-50">
                    <i class="bi bi-database me-2"></i> Master Data
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 3) : ?>
            <li class="nav-item mt-1">
                <a href="/laporan/input" class="nav-link text-white-50">
                    <i class="bi bi-pencil-square me-2"></i> Input Laporan
                </a>
            </li>
            <li class="nav-item mt-1">
                <a href="/laporan/history" class="nav-link text-white-50">
                    <i class="bi bi-clock-history me-2"></i> History Laporan
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('fk_roles') == 2) : ?>
            <li class="nav-item mt-1">
                <a href="/laporan/rekap" class="nav-link text-white-50">
                    <i class="bi bi-file-earmark-text me-2"></i> Rekap Laporan
                </a>
            </li>
        <?php endif; ?>

    </ul>

</div>

<style>
    .hover-white:hover {
        color: #fff !important;
        background-color: #1e293b;
        border-radius: 5px;
    }
</style>