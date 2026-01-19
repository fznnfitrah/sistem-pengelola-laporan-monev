<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">

</head>

<body>

  <div class="main-wrapper">
    <?= $this->include('layouts/sidebar') ?>

    <div id="content-wrapper">
      <?= $this->include('layouts/topbar') ?> <main class="flex-grow-1 p-4">
        <?= $this->renderSection('content') ?>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>