    // --- FUNGSI MODAL ---
    function btnEditFakultas(id, nama) {
        document.getElementById('f_id_lama').value = id;
        document.getElementById('f_id').value = id;
        document.getElementById('f_nama').value = nama;
    }

    function btnEditProdi(id, fk, nama) {
        document.getElementById('p_id_lama').value = id;
        document.getElementById('p_id').value = id;
        document.getElementById('p_fk').value = fk;
        document.getElementById('p_nama').value = nama;
    }

    // --- LOGIKA SWEETALERT ---

    // 1. Cek Success Flashdata
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2500,
            showConfirmButton: false
        });
    <?php endif; ?>

    // 2. Cek Error Flashdata (Validation & Exception)
    <?php if (session()->getFlashdata('errors')) : ?>
        <?php
        $errors = session()->getFlashdata('errors');
        // Ubah array errors menjadi list HTML
        $list_error = '<ul class="text-start">';
        foreach ($errors as $e) {
            $list_error .= '<li>' . esc($e) . '</li>';
        }
        $list_error .= '</ul>';
        ?>

        Swal.fire({
            icon: 'error',
            title: 'Ups, ada kesalahan!',
            html: '<?= $list_error ?>',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tutup'
        }).then(() => {
            // Opsional: Buka kembali modal jika ada error input
            // (Anda perlu logika JS tambahan untuk mendeteksi modal mana yang harus dibuka)
        });
    <?php endif; ?>

    // 3. Konfirmasi Hapus
    function konfirmasiHapus(url) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }