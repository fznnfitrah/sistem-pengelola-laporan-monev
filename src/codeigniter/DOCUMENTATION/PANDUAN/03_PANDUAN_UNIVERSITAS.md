# PANDUAN PENGGUNA - ROLE UNIVERSITAS

## Overview

Role Universitas (UNIV) berperan dalam mengelola master data universitas, monitoring laporan dari semua unit, dan mengatur parameter sistem. Tanggung jawab utama:

- Mengelola data Fakultas dan Program Studi
- Mengelola Unit dan Lembaga Akreditasi
- Mengatur Periode Akademik
- Mengatur Master Data Monev dan Kinerja
- Mengelola Jenjang Program Studi
- Monitoring laporan dari seluruh organisasi

---

## 1. Login ke Sistem

1. Buka aplikasi di `http://localhost:8080`
2. Masukkan username dan password role Universitas
3. Klik tombol **Login**
4. Anda akan diarahkan ke halaman Dashboard Universitas

---

## 2. Mengelola Master Data Universitas

### 2.1 Master Data (Fakultas & Prodi)

Halaman utama untuk mengelola struktur akademik universitas.

**Akses:** Menu → **Master/Setup**

#### Menambah Fakultas Baru

1. Klik tombol **Tambah Fakultas** di bagian Fakultas
2. Isi form:
   - **Nama Fakultas**: Nama lengkap fakultas
   - **Kode Fakultas**: Kode unik untuk identifikasi
   - **Deskripsi**: Penjelasan singkat (opsional)
3. Klik **Simpan**

#### Mengedit Fakultas

1. Cari fakultas di tabel daftar Fakultas
2. Klik tombol **Edit** atau ikon pensil
3. Ubah data yang diperlukan
4. Klik **Simpan** atau **Update**

#### Menghapus Fakultas

1. Cari fakultas di tabel daftar
2. Klik tombol **Hapus** atau ikon tempat sampah
3. Konfirmasi penghapusan
4. Fakultas akan dihapus (beserta semua prodi di dalamnya)

#### Menambah Program Studi (Prodi)

1. Klik tombol **Tambah Prodi** di bagian Program Studi
2. Isi form:
   - **Nama Prodi**: Nama lengkap program studi
   - **Kode Prodi**: Kode unik (contoh: IF-01, PSIKOLOGI-01)
   - **Fakultas**: Pilih fakultas induk
   - **Jenjang**: Pilih jenjang (S1, S2, S3, D3, dst)
   - **Deskripsi**: Penjelasan singkat (opsional)
3. Klik **Simpan**

---

### 2.2 Mengelola Unit & Lembaga

**Akses:** Menu → **Unit & Lembaga** atau **Unit**

#### Menambah Unit Baru

1. Klik tombol **Tambah Unit** atau **+ Unit Baru**
2. Isi form:
   - **Nama Unit**: Nama lengkap unit (misal: Bagian Akademik, LPPM, dst)
   - **Kode Unit**: Kode unik untuk identifikasi
   - **Deskripsi**: Penjelasan singkat
3. Klik **Simpan**

#### Mengedit Unit

1. Cari unit di tabel daftar
2. Klik tombol **Edit** atau ikon pensil
3. Ubah data yang diperlukan
4. Klik **Simpan** atau **Update**

#### Menghapus Unit

1. Cari unit di tabel daftar
2. Klik tombol **Hapus** atau ikon tempat sampah
3. Konfirmasi penghapusan
4. Unit akan dihapus dari sistem

---

## 3. Mengatur Periode Akademik

### 3.1 Melihat Daftar Periode

**Akses:** Menu → **Periode Akademik** atau **Periode**

Di halaman ini Anda dapat melihat semua periode akademik yang tersedia.

### 3.2 Menambah Periode Baru

1. Klik tombol **Tambah Periode** atau **+ Periode Baru**
2. Isi form:
   - **Tahun Akademik**: Tahun akademik (misal: 2024/2025)
   - **Semester**: Nomor semester (1 atau 2)
   - **Status Aktif**: Centang jika periode ini aktif
3. Klik **Simpan**

### 3.3 Set Periode Aktif

1. Cari periode di tabel daftar yang ingin dijadikan aktif
2. Klik tombol **Set Aktif**
3. Periode ini akan menjadi periode aktif untuk semua pengguna

### 3.4 Menghapus Periode

1. Cari periode di tabel daftar
2. Klik tombol **Hapus** atau ikon tempat sampah
3. Konfirmasi penghapusan

---

## 4. Master Data Monev

**Akses:** Menu → **Master Monev** atau **Monev**

Kelola daftar monitoring dan evaluasi yang akan dipantau.

### 4.1 Menambah Monev Baru

1. Klik tombol **Tambah Monev** atau **+ Monev Baru**
2. Isi form:
   - **Nama Monev**: Nama parameter monitoring (misal: "Tingkat Keberhasilan Mahasiswa", "Kepuasan Alumni", dst)
   - **Periode**: Pilih periode akademik
   - **Status**: Pilih status (Aktif/Tidak Aktif)
   - **Keterangan**: Penjelasan detail tentang monev ini
3. Klik **Simpan**

### 4.2 Mengedit Monev

1. Cari monev di tabel daftar
2. Klik tombol **Edit** atau ikon pensil
3. Ubah data yang diperlukan
4. Klik **Simpan** atau **Update**

### 4.3 Copy Monev dari Periode Terdahulu

1. Klik tombol **Copy** pada monev yang ingin dicopy
2. Pilih periode tujuan
3. Monev akan dicopy ke periode baru dengan nilai yang sama

### 4.4 Menghapus Monev

1. Cari monev di tabel daftar
2. Klik tombol **Hapus**
3. Konfirmasi penghapusan

---

## 5. Master Data Kinerja

**Akses:** Menu → **Master Kinerja** atau **Kinerja**

Kelola daftar indikator kinerja yang akan dievaluasi.

### 5.1 Menambah Kinerja Baru

1. Klik tombol **Tambah Kinerja** atau **+ Kinerja Baru**
2. Isi form:
   - **Nama Kinerja**: Nama indikator kinerja (misal: "IPK Rata-rata", "Daya Serap Alumni", dst)
   - **Target**: Target nilai kinerja (jika ada)
   - **Satuan**: Satuan pengukuran (persen, nilai, jumlah, dst)
   - **Keterangan**: Penjelasan detail
3. Klik **Simpan**

### 5.2 Mengedit Kinerja

1. Cari kinerja di tabel daftar
2. Klik tombol **Edit**
3. Ubah data yang diperlukan
4. Klik **Simpan** atau **Update**

### 5.3 Menghapus Kinerja

1. Cari kinerja di tabel daftar
2. Klik tombol **Hapus**
3. Konfirmasi penghapusan

---

## 6. Mengelola Jenjang Program Studi

**Akses:** Menu → **Jenjang** atau **Master Jenjang**

Kelola daftar jenjang program studi (S1, S2, S3, D3, D4, dst).

### 6.1 Menambah Jenjang Baru

1. Klik tombol **Tambah Jenjang** atau **+ Jenjang Baru**
2. Isi form:
   - **Nama Jenjang**: Nama jenjang (misal: "Sarjana (S1)", "Magister (S2)", dst)
   - **Kode Jenjang**: Kode singkat (S1, S2, S3, D3, D4, dst)
3. Klik **Simpan**

---

## 7. Mengelola Lembaga Akreditasi

**Akses:** Menu → **Lembaga Akreditasi** atau **Lembaga**

Kelola daftar lembaga akreditasi (BAN-PT, ASIC, FIBAA, dst).

### 7.1 Menambah Lembaga Akreditasi

1. Klik tombol **Tambah Lembaga** atau **+ Lembaga Baru**
2. Isi form:
   - **Nama Lembaga**: Nama lembaga akreditasi
   - **Singkatan**: Singkatan lembaga (misal: BAN-PT, ASIC)
   - **Keterangan**: Penjelasan singkat
3. Klik **Simpan**

---

## 8. Monitoring Laporan

**Akses:** Menu → **Monitoring Laporan** atau **Monitoring**

Pantau status pengumpulan laporan dari semua unit, prodi, dan fakultas.

### 8.1 Fitur Monitoring

- **Status Per Unit**: Lihat laporan mana saja yang sudah dikumpulkan
- **Filter**: Filter berdasarkan periode, unit, atau status
- **Detail Laporan**: Klik laporan untuk melihat detail dan bukti

---

## 9. Monitoring Akreditasi

**Akses:** Menu → **Monitoring Akreditasi**

Pantau status akreditasi program studi dan universitas.

### 9.1 Fitur Monitoring Akreditasi

- **Daftar Akreditasi**: Lihat semua data akreditasi prodi
- **Rekap Akreditasi**: Lihat ringkasan akreditasi per lembaga
- **Status Akreditasi**: Pantau status akreditasi (dalam proses, selesai, expired, dst)

---

## 10. Dashboard Universitas

Di halaman Dashboard, Anda dapat melihat:

- **Statistik Keseluruhan**: Jumlah fakultas, prodi, dan unit
- **Status Periodik**: Periode akademik aktif saat ini
- **Ringkasan Laporan**: Status pengumpulan laporan terbaru
- **Grafik & Chart**: Visualisasi data monev dan kinerja

---

## 11. Profil Pengguna

**Akses:** Menu → **Profil** atau klik nama pengguna di pojok kanan atas

Di halaman ini Anda dapat:

- **Mengubah Data Profil**: Ubah nama, email, nomor telepon
- **Ganti Password**: Ubah password akun
- **Lihat Informasi Akun**: Lihat detail akun Anda

---

## 12. Tips & Tricks

- **Pencarian**: Gunakan fitur cari untuk menemukan data dengan cepat
- **Filter & Sort**: Gunakan filter untuk menampilkan data berdasarkan kriteria tertentu
- **Export Data**: Beberapa halaman menyediakan opsi export ke Excel
- **Backup**: Selalu backup data penting sebelum melakukan perubahan besar

---

## 13. Menu Navigasi Lengkap

| Menu                      | Fungsi                       |
| ------------------------- | ---------------------------- |
| **Dashboard**             | Halaman utama universitas    |
| **Master/Setup**          | Kelola fakultas dan prodi    |
| **Unit & Lembaga**        | Kelola unit dan lembaga      |
| **Periode Akademik**      | Atur periode akademik        |
| **Master Monev**          | Kelola parameter monev       |
| **Master Kinerja**        | Kelola indikator kinerja     |
| **Jenjang**               | Kelola jenjang program studi |
| **Lembaga Akreditasi**    | Kelola lembaga akreditasi    |
| **Monitoring Laporan**    | Pantau laporan               |
| **Monitoring Akreditasi** | Pantau akreditasi            |
| **Profil**                | Ubah profil pengguna         |
| **Logout**                | Keluar dari sistem           |

---

**Pertanyaan atau masalah? Hubungi administrator sistem Anda.**
