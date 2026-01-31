<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'App Dashboard' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
  
  <style>
    /* Tambahan CSS Inline untuk memastikan layout tidak pecah */
    html, body {
      height: 100%;
      margin: 0;
    }
    
    /* Root container agar footer lengket di bawah */
    .app-root {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Area Tengah (Sidebar + Konten) harus mengisi ruang kosong */
    .app-middle {
      display: flex;
      flex: 1; /* flex-grow: 1 */
      position: relative;
    }

    /* Pastikan Sidebar menyesuaikan tinggi konten tengah, bukan viewport */
    .sidebar {
      height: auto !important; /* Override height lama */
      min-height: 100%;       /* Ikuti tinggi konten */
    }
  </style>
</head>

<body>

  <div class="app-root">

      <div class="app-middle">
        
        <?= $this->include('layouts/sidebar') ?>

        <div id="content-wrapper" class="d-flex flex-column w-100 bg-light">
          
          <?= $this->include('layouts/topbar') ?>

          <main class="flex-grow-1 p-4">
            <?= $this->renderSection('content') ?>
          </main>

        </div>
      </div>

      <?= $this->include('layouts/footer') ?>

  </div>

  <div id="sidebarOverlay"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sidebar = document.getElementById('sidebar');
      const toggle = document.getElementById('sidebarToggle');
      const closeBtn = document.getElementById('sidebarClose'); // Tombol X
      const overlay = document.getElementById('sidebarOverlay');

      // Fungsi Toggle
      function toggleSidebar() {
        if(sidebar && overlay) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
      }

      // Fungsi Tutup
      function closeSidebar() {
         if(sidebar && overlay) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
         }
      }

      if (toggle) toggle.addEventListener('click', toggleSidebar);
      if (overlay) overlay.addEventListener('click', closeSidebar);
      if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    });
  </script>
</body>
</html>