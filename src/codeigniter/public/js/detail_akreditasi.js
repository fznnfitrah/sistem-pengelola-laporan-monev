function btnDetail(nama, jenjang, status, lembaga, lembaga_inter, peringkat, nilai, no_sk, tgl_kadaluarsa, biaya, tahun, ts, ts1, ts2, link) {
    
    // 1. Isi Data Teks Dasar
    const elNama = document.getElementById('d_nama_prodi');
    if(elNama) elNama.innerText = nama;
    
    document.getElementById('d_jenjang').innerText = jenjang;
    document.getElementById('d_status').innerText = status;
    document.getElementById('d_lembaga').innerText = lembaga;
    
    // Lembaga Internasional Logic
    const elInter = document.getElementById('d_lembaga_inter');
    const divInter = document.getElementById('d_lembaga_inter_div');
    if(lembaga_inter && lembaga_inter !== '-' && elInter && divInter) {
        elInter.innerText = lembaga_inter;
        divInter.classList.remove('d-none');
    } else if(divInter) {
        divInter.classList.add('d-none');
    }

    document.getElementById('d_peringkat').innerText = peringkat;
    document.getElementById('d_nilai').innerText = (nilai == 0) ? '-' : nilai;
    document.getElementById('d_no_sk').innerText = no_sk;
    document.getElementById('d_tahun').innerText = tahun;

    // 2. Format Tanggal & Hitung Mundur
    if(tgl_kadaluarsa && tgl_kadaluarsa !== '0000-00-00') {
        const dateObj = new Date(tgl_kadaluarsa);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById('d_tgl_kadaluarsa').innerText = dateObj.toLocaleDateString('id-ID', options);

        const now = new Date();
        const diffTime = dateObj - now;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        
        const elCount = document.getElementById('d_countdown');
        if(elCount) {
            if(diffDays > 0) {
                const years = Math.floor(diffDays / 365);
                const months = Math.floor((diffDays % 365) / 30);
                const days = Math.floor((diffDays % 365) % 30);
                elCount.innerText = `${years} Tahun, ${months} Bulan, ${days} Hari lagi`;
                elCount.className = "fw-bold text-success";
            } else {
                elCount.innerText = "Sudah Kadaluarsa";
                elCount.className = "fw-bold text-danger";
            }
        }

    } else {
        document.getElementById('d_tgl_kadaluarsa').innerText = '-';
        document.getElementById('d_countdown').innerText = '-';
    }

    // 3. Format Rupiah
    if(biaya) {
        let rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(biaya);
        document.getElementById('d_biaya').innerText = rupiah;
    } else {
        document.getElementById('d_biaya').innerText = 'Rp 0';
    }

    // 4. Data TS
    document.getElementById('d_ts').innerText = ts;
    document.getElementById('d_ts1').innerText = ts1;
    document.getElementById('d_ts2').innerText = ts2;

    // 5. Link Sertifikat
    const btnLink = document.getElementById('btnLinkSertifikat');
    const btnNoLink = document.getElementById('btnNoSertifikat');

    if (link && link !== '#') {
        if(btnLink) {
            btnLink.href = link;
            btnLink.classList.remove('d-none');
        }
        if(btnNoLink) btnNoLink.classList.add('d-none');
    } else {
        if(btnLink) btnLink.classList.add('d-none');
        if(btnNoLink) btnNoLink.classList.remove('d-none');
    }
}