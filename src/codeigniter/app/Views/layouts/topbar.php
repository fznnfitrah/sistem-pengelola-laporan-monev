<nav class="navbar navbar-expand navbar-light bg-white py-2" style="border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 1030;">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <button id="sidebarToggle" class="btn btn-link text-dark d-md-none me-2 shadow-none">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="d-flex flex-column">
                <span class="brand-uni">UNIVERSITAS TRUNODJOYO MADURA</span>
                <span class="brand-sub">Sistem Pengelola Laporan Monitoring dan Evaluasi</span>
            </div>
        </div>

        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center px-2 py-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #00d47e; border-radius: 50px;">
                    <img src="https://ui-avatars.com/api/?name=<?= session()->get('username') ?>&background=059669&color=fff" alt="profile" width="28" height="28" class="rounded-circle me-2">
                    <div class="d-none d-sm-block me-1">
                        <div class="fw-bold text-dark small" style="line-height: 1.2;"><?= esc(session()->get('username')) ?></div>
                        <div class="text-muted" style="font-size: 0.65rem;">
                            <?php
                            $role = session()->get('fk_roles');
                            switch ($role) {
                                case 1: echo 'Administrator'; break;
                                case 2: echo 'Fakultas'; break;
                                case 3: echo 'Prodi'; break;
                                case 4: echo 'Unit Kerja'; break;
                                case 5: echo 'Universitas'; break;
                                default: echo 'User';
                            }
                            ?>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="navbarDropdown" style="border-radius: 12px; min-width: 200px;">
                    <div class="px-3 py-2 border-bottom mb-1">
                        <p class="small text-muted mb-0">Selamat Datang,</p>
                        <p class="small fw-bold mb-0 text-dark"><?= esc(session()->get('username')) ?></p>
                    </div>
                    <a href="<?= base_url('profile') ?>" class="dropdown-item"><i class="bi bi-person me-2"></i> Profile</a>
                    <?php
                    $availableRoles = session()->get('available_roles');
                    $currentId = session()->get('current_user_id');
                    $currentEmail = session()->get('email');
                    if ($availableRoles && count($availableRoles) > 1 && !empty($currentEmail)):
                    ?>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-header text-dark fw-bold small">Pindah Akses:</li>
                        <?php foreach ($availableRoles as $acc): ?>
                            <?php if ($acc['id'] != $currentId && $acc['email'] === $currentEmail): ?>
                                <li>
                                    <a class="dropdown-item py-2 small" href="<?= base_url('auth/switch/' . $acc['id']) ?>">
                                        <i class="bi bi-arrow-left-right me-2 text-success"></i> Masuk sebagai 
                                        <strong>
                                            <?php
                                            switch ($acc['fk_roles']) {
                                                case 1: echo 'Admin'; break;
                                                case 2: echo 'Fakultas ' . $acc['fk_fakultas']; break;
                                                case 3: echo 'Prodi ' . $acc['fk_prodi']; break;
                                                case 4: echo 'Unit ' . $acc['fk_unit']; break;
                                                case 5: echo 'Universitas'; break;
                                                default: echo 'User';
                                            }
                                            ?>
                                        </strong>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>