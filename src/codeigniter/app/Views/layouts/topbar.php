<nav class="navbar navbar-expand navbar-dark w-100" style="background-color: #0f172a; border-bottom: 1px solid #1e293b;">
    <div class="container-fluid">
        
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-white d-md-none me-3">
                <i class="bi bi-list fs-4"></i>
            </button>
            <span class="navbar-brand mb-0 h1 fs-6 text-secondary">Dashboard &gt; Overview</span>
        </div>

        <ul class="navbar-nav ms-auto align-items-center">
            
            <!-- <li class="nav-item me-3">
                <a class="nav-link position-relative" href="#">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </a>
            </li>

            <div class="vr text-white me-3" style="height: 25px;"></div> -->

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle me-2 border border-secondary">
                    <span class="d-none d-sm-inline small fw-bold"><?= session()->get('username') ?? 'User' ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">Log Out</a></li>
                </ul>
            </li>

        </ul>
    </div>
</nav>