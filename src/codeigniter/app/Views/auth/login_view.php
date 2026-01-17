<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Pengelola Laporan Monev</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 align-items-center">
        <div class="col-md-6 mb-5 mb-md-0 text-center text-md-start">
            <h1 class="fw-bold display-5 text-dark">SISTEM PENGELOLA</h1>
            <h1 class="fw-bold display-5 text-dark mb-4">LAPORAN MONEV</h1>
            <p class="text-secondary lead">
                Aplikasi untuk mengelola laporan monitoring dan evaluasi prodi <br>
                Universitas Trunodjoyo Madura
            </p>
        </div>

        <div class="col-md-5 offset-md-1">
            <div class="card border-0 shadow-lg p-4" style="background-color: #005d66; border-radius: 20px;">
                <div class="card-body text-white text-center">
                    <h2 class="fw-bold mb-1">Masuk</h2>
                    <p class="small mb-4">Untuk memulai sesi !</p>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger py-2 small">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/login') ?>" method="post">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control py-2 rounded-pill text-center" placeholder="Masukkan username">
                        </div>

                        <div class="mb-2">
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control py-2 rounded-start-pill text-center" placeholder="Masukkan password" style="border-right: none;">
                                <span class="input-group-text bg-white border-start-0 rounded-end-pill" style="cursor: pointer;" onclick="togglePassword()">
                                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="text-start mb-3 ms-2">
                            <a href="#" class="text-white text-decoration-none small">Lupa password?</a>
                        </div>

                        <div class="mb-3 position-relative">
                            <hr class="border-white opacity-50">
                            <span class="position-absolute top-50 start-50 translate-middle px-3" style="background-color: #005d66; font-size: 0.85rem;">Atau</span>
                        </div>

                        <div class="mb-4">
                            <input type="email" name="email" class="form-control py-2 rounded-pill text-center" placeholder="Masukkan email">
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 rounded-pill fw-bold" style="background-color: #00d285; border: none;">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("bi-eye-slash");
        toggleIcon.classList.add("bi-eye");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("bi-eye");
        toggleIcon.classList.add("bi-eye-slash");
    }
}
</script>
</body>
</html>