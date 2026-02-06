# PANDUAN PENGGUNA - ROLE ADMIN

## Overview

Role Admin memiliki akses penuh untuk mengelola pengguna dan role dalam sistem. Admin bertanggung jawab untuk:

- Mengelola daftar pengguna
- Mengelola role dan permission
- Monitor akses sistem

---

## 1. Login ke Sistem

1. Buka aplikasi di `http://localhost:8080`
2. Masukkan **Username** dan **Password** Anda
3. Klik tombol **Login**
4. Anda akan diarahkan ke halaman Dashboard

---

## 2. Mengelola Pengguna

### 2.1 Melihat Daftar Pengguna

1. Dari menu navigasi, pilih **Admin** → **Kelola Pengguna**
2. Anda akan melihat daftar semua pengguna dalam sistem

### 2.2 Menambah Pengguna Baru

1. Klik tombol **Tambah Pengguna** atau **+ Pengguna Baru**
2. Isi form dengan data:
   - **Nama Pengguna** (username): Nama login unik
   - **Email**: Email pengguna
   - **Password**: Kata sandi (minimal 6 karakter)
   - **Role**: Pilih role pengguna (Admin, Universitas, Fakultas, Prodi, Unit)
3. Klik **Simpan** atau **Save**

### 2.3 Mengubah Data Pengguna

1. Di tabel daftar pengguna, cari pengguna yang ingin diubah
2. Klik tombol **Edit** atau ikon pensil
3. Ubah data yang diperlukan
4. Klik **Simpan** atau **Update**

### 2.4 Menghapus Pengguna

1. Di tabel daftar pengguna, cari pengguna yang ingin dihapus
2. Klik tombol **Hapus** atau ikon tempat sampah
3. Konfirmasi penghapusan
4. Pengguna akan dihapus dari sistem

---

## 3. Mengelola Role

### 3.1 Melihat Daftar Role

1. Dari menu navigasi, pilih **Admin** → **Kelola Role**
2. Anda akan melihat daftar semua role yang tersedia

### 3.2 Menambah Role Baru

1. Klik tombol **Tambah Role** atau **+ Role Baru**
2. Isi form dengan data:
   - **Nama Role**: Nama role (misal: Coordinator, Reviewer, dst)
   - **Deskripsi**: Penjelasan singkat tentang role
   - **Permission**: Pilih permission yang dimiliki role ini
3. Klik **Simpan** atau **Save**

### 3.3 Mengubah Role

1. Di tabel daftar role, cari role yang ingin diubah
2. Klik tombol **Edit** atau ikon pensil
3. Ubah data yang diperlukan
4. Klik **Simpan** atau **Update**

### 3.4 Menghapus Role

1. Di tabel daftar role, cari role yang ingin dihapus
2. Klik tombol **Hapus** atau ikon tempat sampah
3. Konfirmasi penghapusan
4. Role akan dihapus dari sistem

---

## 4. Dashboard Admin

Di halaman Dashboard, Anda dapat melihat:

- **Statistik Pengguna**: Jumlah total pengguna aktif
- **Statistik Sistem**: Overview sistem secara keseluruhan
- **Aktivitas Terbaru**: Log aktivitas pengguna terakhir

---

## 5. Menu Navigasi Admin

| Menu                | Fungsi                    |
| ------------------- | ------------------------- |
| **Dashboard**       | Halaman utama/beranda     |
| **Kelola Pengguna** | Mengelola daftar pengguna |
| **Kelola Role**     | Mengelola daftar role     |
| **Profil**          | Mengubah data profil Anda |
| **Logout**          | Keluar dari sistem        |

---

## 6. Tips & Tricks

- **Pencarian Pengguna**: Gunakan fitur cari untuk menemukan pengguna dengan cepat
- **Filter Data**: Gunakan filter untuk menampilkan pengguna berdasarkan kriteria tertentu
- **Export Data**: Beberapa fitur mungkin menyediakan opsi export data ke Excel
- **Undo/Redo**: Pastikan Anda mem-backup data penting sebelum melakukan penghapusan

---

## 7. Keamanan

- **Jangan bagikan login credentials** Anda dengan siapapun
- **Ganti password secara berkala** untuk menjaga keamanan akun
- **Perhatikan log aktivitas** untuk mendeteksi aktivitas mencurigakan
- **Backup database secara rutin** untuk mencegah kehilangan data

---

**Pertanyaan atau masalah? Hubungi administrator sistem Anda.**
