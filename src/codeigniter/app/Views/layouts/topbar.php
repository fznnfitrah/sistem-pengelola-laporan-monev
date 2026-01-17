<nav class="navbar navbar-expand navbar-light bg-white py-2" style="border-bottom: 1px solid #e5e7eb;">
    <div class="container-fluid">
        
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-dark d-md-none me-2">
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
                                if($role == 1) echo 'Administrator';
                                elseif($role == 3) echo 'Fakultas';
                                elseif($role == 4) echo 'Prodi';
                            ?>
                        </div>
                    </div>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="navbarDropdown" style="border-radius: 12px; min-width: 200px;">
                    <div class="px-3 py-2 border-bottom mb-1">
                        <p class="small text-muted mb-0">Selamat Datang,</p>
                        <p class="small fw-bold mb-0 text-dark"><?= esc(session()->get('username')) ?></p>
                    </div>
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item py-2 text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>