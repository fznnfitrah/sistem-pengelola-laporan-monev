# DAFTAR LENGKAP FITUR APLIKASI

## Ringkasan Fitur

Dokumen ini berisi daftar lengkap semua fitur yang tersedia dalam Sistem Pengelolaan Laporan Monitoring dan Evaluasi Program Studi, diorganisir berdasarkan role/peran pengguna.

---

## 1. FITUR UNTUK ROLE ADMIN

### 1.1 Kelola Pengguna

- ✅ Melihat daftar semua pengguna
- ✅ Menambah pengguna baru
- ✅ Mengubah data pengguna
- ✅ Menghapus pengguna
- ✅ Reset password pengguna
- ✅ Filter & cari pengguna
- ✅ Export daftar pengguna (Excel)

**Routes:**

- GET `/admin/users` - Melihat daftar pengguna
- GET `/admin/users/add` - Form tambah pengguna
- POST `/admin/users/save` - Simpan pengguna baru
- GET `/admin/users/edit/:id` - Form edit pengguna
- PUT `/admin/users/:id` - Update data pengguna
- DELETE `/admin/users/:id` - Hapus pengguna

### 1.2 Kelola Role

- ✅ Melihat daftar semua role
- ✅ Menambah role baru
- ✅ Mengubah data role
- ✅ Menghapus role
- ✅ Kelola permission per role
- ✅ Filter & cari role

**Routes:**

- GET `/admin/roles` - Melihat daftar role
- GET `/admin/roles/add` - Form tambah role
- POST `/admin/roles/save` - Simpan role baru
- GET `/admin/roles/edit/:id` - Form edit role
- PUT `/admin/roles/:id` - Update data role
- DELETE `/admin/roles/:id` - Hapus role

### 1.3 Dashboard Admin

- ✅ Melihat statistik pengguna
- ✅ Melihat statistik sistem
- ✅ Log aktivitas pengguna

---

## 2. FITUR UNTUK ROLE UNIVERSITAS (UNIV)

### 2.1 Master Data - Fakultas & Program Studi

- ✅ Melihat daftar fakultas
- ✅ Menambah fakultas baru
- ✅ Mengubah data fakultas
- ✅ Menghapus fakultas
- ✅ Melihat daftar program studi per fakultas
- ✅ Menambah program studi baru
- ✅ Mengubah data program studi
- ✅ Menghapus program studi

**Routes:**

- GET `/univ/master` - Halaman master data
- POST `/univ/master/simpanFakultas` - Simpan fakultas
- POST `/univ/master/editFakultas` - Edit fakultas
- GET `/univ/master/hapusFakultas/:id` - Hapus fakultas
- POST `/univ/master/simpanProdi` - Simpan prodi
- POST `/univ/master/editProdi` - Edit prodi
- GET `/univ/master/hapusProdi/:id` - Hapus prodi

### 2.2 Unit & Lembaga

- ✅ Melihat daftar unit
- ✅ Menambah unit baru
- ✅ Mengubah data unit
- ✅ Menghapus unit
- ✅ Mengelola lembaga akreditasi

**Routes:**

- GET `/univ/unit` - Halaman unit & lembaga
- POST `/univ/unit/simpan` - Simpan unit
- POST `/univ/unit/edit` - Edit unit
- GET `/univ/unit/hapus/:id` - Hapus unit

### 2.3 Periode Akademik

- ✅ Melihat daftar periode akademik
- ✅ Menambah periode baru
- ✅ Set periode aktif
- ✅ Menghapus periode
- ✅ Filter periode berdasarkan tahun/semester

**Routes:**

- GET `/univ/periode` - Halaman periode akademik
- POST `/univ/periode/simpan` - Simpan periode
- GET `/univ/periode/setAktif/:id` - Set periode aktif
- GET `/univ/periode/hapus/:id` - Hapus periode

### 2.4 Master Data Monev

- ✅ Melihat daftar monev
- ✅ Menambah monev baru
- ✅ Mengubah data monev
- ✅ Menghapus monev
- ✅ Copy monev dari periode sebelumnya
- ✅ Filter monev per periode

**Routes:**

- GET `/univ/monev` - Halaman master monev
- POST `/univ/monev/simpan` - Simpan monev
- POST `/univ/monev/update` - Update monev
- GET `/univ/monev/hapus/:id` - Hapus monev
- POST `/univ/monev/copy` - Copy monev

### 2.5 Master Data Kinerja

- ✅ Melihat daftar kinerja
- ✅ Menambah kinerja baru
- ✅ Mengubah data kinerja
- ✅ Menghapus kinerja
- ✅ Filter kinerja berdasarkan jenis

**Routes:**

- GET `/univ/kinerja` - Halaman master kinerja
- POST `/univ/kinerja/simpan` - Simpan kinerja
- POST `/univ/kinerja/edit` - Edit kinerja
- GET `/univ/kinerja/hapus/:id` - Hapus kinerja

### 2.6 Jenjang Program Studi

- ✅ Melihat daftar jenjang (S1, S2, S3, D3, D4, dst)
- ✅ Menambah jenjang baru
- ✅ Mengubah data jenjang
- ✅ Menghapus jenjang

**Routes:**

- GET `/univ/jenjang` - Halaman jenjang
- POST `/univ/jenjang/simpan` - Simpan jenjang
- POST `/univ/jenjang/edit` - Edit jenjang
- GET `/univ/jenjang/hapus/:id` - Hapus jenjang

### 2.7 Lembaga Akreditasi

- ✅ Melihat daftar lembaga akreditasi (BAN-PT, ASIC, FIBAA, dst)
- ✅ Menambah lembaga baru
- ✅ Mengubah data lembaga
- ✅ Menghapus lembaga

**Routes:**

- GET `/univ/lembaga_akreditasi` - Halaman lembaga akreditasi
- POST `/univ/lembaga_akreditasi/simpan` - Simpan lembaga
- POST `/univ/lembaga_akreditasi/edit` - Edit lembaga
- GET `/univ/lembaga_akreditasi/hapus/:id` - Hapus lembaga

### 2.8 Input Akreditasi Program Studi

- ✅ Universitas dapat menginput akreditasi untuk prodi
- ✅ Melihat daftar akreditasi semua prodi
- ✅ Mengubah data akreditasi

**Routes:**

- GET `/univ/akreditasi/input` - Form input akreditasi
- POST `/univ/akreditasi/simpan` - Simpan akreditasi

### 2.9 Monitoring Laporan

- ✅ Melihat status pengumpulan laporan dari semua unit, prodi, dan fakultas
- ✅ Filter laporan berdasarkan periode, unit, status
- ✅ Melihat detail laporan per unit
- ✅ Download laporan dalam format PDF/Excel
- ✅ Kirim notifikasi/reminder ke unit yang belum mengumpulkan

**Routes:**

- GET `/univ/monitoring` - Halaman monitoring laporan

### 2.10 Monitoring Akreditasi

- ✅ Melihat status akreditasi semua program studi
- ✅ Melihat ringkasan akreditasi per lembaga
- ✅ Filter akreditasi berdasarkan status (Terakreditasi, Pending, Expired)
- ✅ Download laporan akreditasi

**Routes:**

- GET `/univ/monitoring/akreditasi` - Halaman monitoring akreditasi
- GET `/univ/monitoring/rekap` - Ringkasan akreditasi

### 2.11 Dashboard Universitas

- ✅ Melihat statistik universitas (jumlah fakultas, prodi, unit)
- ✅ Melihat status periode aktif
- ✅ Melihat ringkasan laporan terbaru
- ✅ Grafik & chart monev dan kinerja
- ✅ Quick access ke fitur utama

---

## 3. FITUR UNTUK ROLE FAKULTAS

### 3.1 Dashboard Fakultas

- ✅ Melihat statistik laporan prodi
- ✅ Melihat status pengumpulan laporan
- ✅ Grafik & chart monev prodi
- ✅ Aktivitas terbaru

**Routes:**

- GET `/fakultas/dashboard` - Dashboard fakultas

### 3.2 Melihat Laporan dari Prodi

- ✅ Melihat semua laporan monev dari prodi dalam fakultas
- ✅ Melihat detail laporan prodi
- ✅ Download laporan prodi
- ✅ Filter laporan berdasarkan periode, prodi, status
- ✅ Cari laporan

**Routes:**

- GET `/fakultas/laporan/input` - Input laporan (jika diberikan akses)
- POST `/fakultas/laporan/simpan` - Simpan laporan
- GET `/fakultas/laporan/history` - Riwayat laporan

### 3.3 Monitoring Laporan Fakultas

- ✅ Melihat status pengumpulan laporan dari semua prodi dalam fakultas
- ✅ Melihat presentase pengumpulan laporan
- ✅ Filter berdasarkan periode
- ✅ Analisa data laporan

**Routes:**

- GET `/fakultas/monitoring` - Monitoring laporan fakultas

---

## 4. FITUR UNTUK ROLE PRODI (PROGRAM STUDI)

### 4.1 Input Laporan Monitoring dan Evaluasi

- ✅ Menambah laporan monev baru
- ✅ Mengisi parameter monev sesuai yang ditetapkan universitas
- ✅ Upload/masukkan link bukti pendukung
- ✅ Menambah keterangan atau catatan
- ✅ Simpan laporan
- ✅ Kirim laporan ke universitas

**Routes:**

- GET `/prodi/laporan/input` - Form input laporan
- POST `/prodi/laporan/save` - Simpan laporan

### 4.2 Kinerja Prodi

- ✅ Menambah data kinerja program studi
- ✅ Mengisi parameter kinerja (IPK rata-rata, daya serap alumnus, dst)
- ✅ Upload/masukkan link bukti pendukung
- ✅ Simpan data kinerja

**Routes:**

- GET `/prodi/kinerja/input` - Form input kinerja
- POST `/prodi/kinerja/save` - Simpan kinerja

### 4.3 Akreditasi Program Studi

- ✅ Melihat daftar akreditasi program studi
- ✅ Menambah/mengubah data akreditasi (BAN-PT, ASIC, FIBAA)
- ✅ Masukkan status akreditasi
- ✅ Upload sertifikat akreditasi
- ✅ Pantau masa berlaku akreditasi

**Routes:**

- GET `/prodi/akreditasi/index` - Daftar akreditasi
- GET `/prodi/akreditasi/new` - Form akreditasi baru
- POST `/prodi/akreditasi/simpan` - Simpan akreditasi

### 4.4 Riwayat & History Laporan

- ✅ Melihat semua laporan yang sudah dikumpulkan
- ✅ Melihat status laporan (dikirim, pending, disetujui, dst)
- ✅ Melihat tanggal pengumpulan
- ✅ Edit laporan (jika belum deadline)
- ✅ Hapus laporan (jika belum deadline)
- ✅ Download laporan

**Routes:**

- GET `/prodi/laporan/history` - Riwayat laporan

---

## 5. FITUR UNTUK ROLE UNIT (UNIT KERJA/LEMBAGA)

### 5.1 Input Laporan Monitoring dan Evaluasi Unit

- ✅ Menambah laporan monev unit baru
- ✅ Mengisi parameter monev sesuai ketentuan
- ✅ Upload/masukkan link bukti pendukung
- ✅ Menambah keterangan atau catatan
- ✅ Simpan laporan
- ✅ Kirim laporan

**Routes:**

- GET `/unit/laporan/input` - Form input laporan
- POST `/unit/laporan/save` - Simpan laporan

### 5.2 Kinerja Unit

- ✅ Menambah data kinerja unit
- ✅ Mengisi parameter kinerja unit
- ✅ Upload/masukkan link bukti pendukung
- ✅ Simpan data kinerja

**Routes:**

- GET `/unit/kinerja/input` - Form input kinerja
- POST `/unit/kinerja/save` - Simpan kinerja

### 5.3 Riwayat & History Laporan Unit

- ✅ Melihat semua laporan yang sudah dikumpulkan
- ✅ Melihat tanggal pengumpulan
- ✅ Edit laporan (jika belum deadline)
- ✅ Hapus laporan (jika belum deadline)
- ✅ Download laporan

**Routes:**

- GET `/unit/laporan/history` - Riwayat laporan

---

## 6. FITUR UMUM (SEMUA ROLE)

### 6.1 Authentication

- ✅ Login dengan username dan password
- ✅ Logout dari sistem
- ✅ Switch ke role lain (jika user memiliki multiple role)
- ✅ Session management

**Routes:**

- GET `/login` - Halaman login
- POST `/auth/login` - Process login
- GET `/auth/logout` - Process logout
- GET `/auth/switch/:id` - Switch role

### 6.2 profil Pengguna

- ✅ Melihat profil pribadi
- ✅ Mengubah data profil (nama, email, nomor telepon)
- ✅ Ganti password
- ✅ Melihat informasi akun (role, unit, akses)

**Routes:**

- GET `/profile` atau `/profile/` - Halaman profil
- GET `/profile/edit` - Form edit profil
- POST `/profile/update` - Simpan perubahan profil

### 6.3 Dashboard Umum

- ✅ Melihat ringkasan informasi
- ✅ Quick access ke fitur-fitur utama
- ✅ Notifikasi deadline laporan
- ✅ Informasi periode akademik aktif

**Routes:**

- GET `/` atau `/dashboard` - Halaman dashboard

---

## 7. FITUR TECHNICAL/BACKEND

### 7.1 Database Management

- ✅ Migration database (CodeIgniter Spark)
- ✅ Database seeding untuk data dummy
- ✅ Backup & restore database

### 7.2 Logging & Audit

- ✅ Log aktivitas pengguna
- ✅ Audit trail untuk perubahan data
- ✅ Error logging

### 7.3 Security

- ✅ Authentication filter
- ✅ Authorization/permission check per route
- ✅ CSRF protection
- ✅ Password hashing

---

## RINGKASAN FITUR PER ROLE

| Fitur                      | Admin | Universitas | Fakultas | Prodi | Unit |
| -------------------------- | :---: | :---------: | :------: | :---: | :--: |
| Kelola Pengguna            |  ✅   |     ❌      |    ❌    |  ❌   |  ❌  |
| Kelola Role                |  ✅   |     ❌      |    ❌    |  ❌   |  ❌  |
| Master Data Fakultas/Prodi |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Unit & Lembaga             |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Periode Akademik           |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Master Monev               |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Master Kinerja             |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Jenjang Program Studi      |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Lembaga Akreditasi         |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Input Laporan Monev        |  ❌   |     ❌      |    ⚠️    |  ✅   |  ✅  |
| Input Kinerja              |  ❌   |     ❌      |    ❌    |  ✅   |  ✅  |
| Input Akreditasi           |  ❌   |     ✅      |    ❌    |  ✅   |  ❌  |
| Melihat Laporan            |  ❌   |     ✅      |    ✅    |  ✅   |  ✅  |
| Monitoring Laporan         |  ❌   |     ✅      |    ✅    |  ❌   |  ❌  |
| Monitoring Akreditasi      |  ❌   |     ✅      |    ❌    |  ❌   |  ❌  |
| Edit Profil                |  ✅   |     ✅      |    ✅    |  ✅   |  ✅  |

**Keterangan:**

- ✅ = Fitur tersedia penuh
- ❌ = Fitur tidak tersedia
- ⚠️ = Fitur tersedia dengan batasan

---

**Catatan:** Daftar fitur ini dapat berubah seiring dengan pengembangan aplikasi. Untuk informasi lebih detail tentang setiap fitur, lihat file panduan pengguna di folder `PANDUAN`."
