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

// --- FUNGSI BARU (DETAIL LIST STATISTIK) ---
function showDetail(tipe, dataRaw) {
    let html = '';
    let title = '';
    const hariIni = new Date();
    const enamBulanLagi = new Date();
    enamBulanLagi.setMonth(enamBulanLagi.getMonth() + 6);

    const filtered = dataRaw.filter(item => {
        const tglK = item.tgl_kadaluarsa ? new Date(item.tgl_kadaluarsa) : null;
        
        if (tipe === 'kadaluarsa') {
            title = 'Daftar Prodi Kadaluarsa';
            return tglK && tglK < hariIni;
        } else if (tipe === 'akan_habis') {
            title = 'Masa Berlaku < 6 Bulan';
            return tglK && tglK >= hariIni && tglK < enamBulanLagi;
        } else if (tipe === 'persiapan') {
            title = 'Tahap: Sedang Persiapan';
            return item.tahap === 'Persiapan';
        } else if (tipe === 'pengajuan') {
            title = 'Tahap: Pengajuan Akreditasi';
            return item.tahap === 'Pengajuan';
        } else if (tipe === 'asesmen') {
            title = 'Tahap: Asesmen Lapangan';
            return item.tahap === 'Asesmen Lapangan';
        } else if (tipe === 'total_prodi') {
            title = 'Seluruh Prodi Terpantau';
            return true;
        }
        return false;
    });

    if (filtered.length > 0) {
        filtered.forEach((item, index) => {
            let tglDisplay = (item.tgl_kadaluarsa && item.tgl_kadaluarsa !== '0000-00-00') ? item.tgl_kadaluarsa : '-';
            html += `
                <tr class="align-middle">
                    <td class="text-center small">${index + 1}</td>
                    <td class="text-start">
                        <div class="fw-bold text-dark">${item.nama_prodi}</div>
                        <span class="badge bg-light text-secondary border" style="font-size: 0.65rem;">${item.jenjang}</span>
                    </td>
                    <td class="text-center"><span class="badge bg-primary px-2 py-1">${item.peringkat || '-'}</span></td>
                    <td class="text-center">
                        <div class="small fw-bold ${tipe === 'kadaluarsa' ? 'text-danger' : 'text-dark'}">${tglDisplay}</div>
                        <small class="text-muted" style="font-size: 0.7rem;">${item.tahap}</small>
                    </td>
                </tr>`;
        });
    } else {
        html = '<tr><td colspan="4" class="text-center py-4 text-muted">Tidak ada data untuk kategori ini.</td></tr>';
    }

    document.getElementById('modalTitle').innerHTML = `<i class="bi bi-info-circle-fill me-2 text-primary"></i> ${title}`;
    document.getElementById('isiDetailTable').innerHTML = html;
    
    var modalStat = new bootstrap.Modal(document.getElementById('modalDetailStatistik'));
    modalStat.show();
}