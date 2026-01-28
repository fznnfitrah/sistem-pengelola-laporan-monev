document.addEventListener("DOMContentLoaded", function() {
// 1. Ambil Element
const statusSelect = document.getElementById('status_saat_ini');

const fieldPeringkat = document.getElementById('peringkat');
const fieldNilai = document.getElementById('nilai_angka');
const fieldTglTerbit = document.getElementById('tgl_sk_terbit');
const fieldTglKadaluarsa = document.getElementById('tgl_kadaluarsa');
const fieldNoSk = document.getElementById('no_sk');

// List field yang akan dimatikan/hidupkan
const targetFields = [fieldPeringkat, fieldNilai, fieldTglTerbit, fieldTglKadaluarsa, fieldNoSk];

// 2. Fungsi Cek Status
function checkStatus() {
    // Value harus sama persis dengan <option value="...">
    const status = statusSelect.value;
    
    if(status === 'Selesai') {
        // Jika SELESAI: Hidupkan field (Hapus atribut disabled)
        targetFields.forEach(field => {
            field.removeAttribute('disabled');
            field.required = true; // Opsional: Jadikan wajib isi jika sudah selesai
        });
    } else {
        // Jika BELUM SELESAI: Matikan field & Kosongkan isinya
        targetFields.forEach(field => {
            field.setAttribute('disabled', 'disabled');
            field.value = ''; // Reset nilai agar tidak tersimpan sampah
            field.required = false; 
        });
    }
}

// 3. Pasang Event Listener (Saat dropdown berubah)
statusSelect.addEventListener('change', checkStatus);

// 4. Jalankan sekali saat halaman dimuat (untuk handle old input saat validasi gagal)
checkStatus();
});

document.addEventListener("DOMContentLoaded", function() {
    // Ambil elemen
    const selectLembaga = document.getElementById('fk_lembaga');
    const inputBiaya = document.getElementById('biaya');

    // Fungsi Update Biaya
    selectLembaga.addEventListener('change', function() {
        // 1. Ambil opsi yang sedang dipilih user
        const selectedOption = this.options[this.selectedIndex];
        
        // 2. Ambil nilai dari atribut 'data-biaya'
        const biayaDefault = selectedOption.getAttribute('data-biaya');

        // 3. Masukkan ke input biaya
        // Cek jika biayaDefault ada (tidak null), jika tidak ada set 0
        if (biayaDefault) {
            inputBiaya.value = biayaDefault;
        } else {
            inputBiaya.value = 0;
        }
    });
});
