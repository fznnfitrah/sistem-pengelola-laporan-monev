# INDEX DOKUMENTASI

Halaman ini berisi daftar lengkap semua dokumentasi yang tersedia. Gunakan link di bawah untuk mengakses file yang Anda butuhkan.

---

## 📚 FOLDER PANDUAN (User Guides)

Dokumentasi lengkap tentang cara menggunakan sistem untuk setiap role pengguna.

### Instalasi & Setup

- [**01 - Panduan Instalasi**](PANDUAN/01_PANDUAN_INSTALASI.md)
  - Prasyarat sistem
  - Setup Docker
  - Konfigurasi aplikasi
  - Troubleshooting

### Panduan Per Role

1. [**02 - Panduan Admin**](PANDUAN/02_PANDUAN_ADMIN.md)
   - Login sebagai admin
   - Kelola pengguna
   - Kelola role
   - Dashboard admin

2. [**03 - Panduan Universitas**](PANDUAN/03_PANDUAN_UNIVERSITAS.md)
   - Master data universitas
   - Kelola fakultas dan prodi
   - Periode akademik
   - Master monev dan kinerja
   - Monitoring laporan
   - Monitoring akreditasi

3. [**04 - Panduan Fakultas**](PANDUAN/04_PANDUAN_FAKULTAS.md)
   - Dashboard fakultas
   - Melihat laporan dari prodi
   - Monitoring laporan
   - Tips dan tricks

4. [**05 - Panduan Prodi**](PANDUAN/05_PANDUAN_PRODI.md)
   - Input laporan monev
   - Input data kinerja
   - Input data akreditasi
   - Riwayat laporan

5. [**06 - Panduan Unit**](PANDUAN/06_PANDUAN_UNIT.md)
   - Input laporan unit
   - Input kinerja unit
   - Riwayat laporan
   - Troubleshooting

---

## ✨ FOLDER FITUR (Feature Documentation)

Dokumentasi lengkap tentang fitur-fitur yang tersedia dalam sistem.

1. [**Daftar Fitur Lengkap**](FITUR/DAFTAR_FITUR_LENGKAP.md)
   - Fitur per role (Admin, Universitas, Fakultas, Prodi, Unit)
   - API endpoints
   - Database tables
   - Ringkasan fitur dalam tabel

2. [**Ringkasan Fitur Per Role**](FITUR/RINGKASAN_FITUR_PER_ROLE.md)
   - Deskripsi detail setiap role
   - API endpoints lengkap
   - Database tables yang digunakan
   - Controllers dan models
   - Untuk pembuatan prompt dokumentasi

---

## 🔍 CARA MENGGUNAKAN DOKUMENTASI INI

### Jika Anda adalah Pengguna Baru

1. Baca [Panduan Instalasi](PANDUAN/01_PANDUAN_INSTALASI.md) untuk setup awal
2. Baca panduan sesuai dengan role Anda:
   - Admin → [Panduan Admin](PANDUAN/02_PANDUAN_ADMIN.md)
   - Universitas → [Panduan Universitas](PANDUAN/03_PANDUAN_UNIVERSITAS.md)
   - Fakultas → [Panduan Fakultas](PANDUAN/04_PANDUAN_FAKULTAS.md)
   - Prodi → [Panduan Prodi](PANDUAN/05_PANDUAN_PRODI.md)
   - Unit → [Panduan Unit](PANDUAN/06_PANDUAN_UNIT.md)

### Jika Anda adalah Developer

1. Baca [Ringkasan Fitur Per Role](FITUR/RINGKASAN_FITUR_PER_ROLE.md) untuk gambaran teknis
2. Baca [Daftar Fitur Lengkap](FITUR/DAFTAR_FITUR_LENGKAP.md) untuk detail setiap fitur
3. Lihat struktur controllers dan models yang dijelaskan

### Jika Anda Membutuhkan Fitur Spesifik

1. Cari di [Daftar Fitur Lengkap](FITUR/DAFTAR_FITUR_LENGKAP.md)
2. Cari role yang terkait
3. Baca API endpoints dan database tables
4. Lihat panduan pengguna untuk instruksi penggunaan

---

## 📋 STRUKTUR DOKUMENTASI

```
DOCUMENTATION/
├── README.md (file ini)
├── PANDUAN/
│   ├── 01_PANDUAN_INSTALASI.md
│   ├── 02_PANDUAN_ADMIN.md
│   ├── 03_PANDUAN_UNIVERSITAS.md
│   ├── 04_PANDUAN_FAKULTAS.md
│   ├── 05_PANDUAN_PRODI.md
│   └── 06_PANDUAN_UNIT.md
└── FITUR/
    ├── DAFTAR_FITUR_LENGKAP.md
    └── RINGKASAN_FITUR_PER_ROLE.md
```

---

## 🎯 QUICK START

**Untuk Setup Cepat:**

```bash
# 1. Setup Docker
docker-compose up -d

# 2. Install dependencies
docker exec -it ci_app bash
composer install

# 3. Setup permissions
chown -R www-data:www-data /var/www/codeigniter/writable
chmod -R 775 /var/www/codeigniter/writable

# 4. Run migrations
php spark migrate

# 5. Akses aplikasi
# Buka browser: http://localhost:8080
```

---

## 📞 DUKUNGAN & HELP

### Troubleshooting

- Lihat bagian "Troubleshooting" di setiap panduan pengguna
- Lihat [Panduan Instalasi](PANDUAN/01_PANDUAN_INSTALASI.md) untuk masalah setup

### Pertanyaan Teknis

- Lihat [Ringkasan Fitur Per Role](FITUR/RINGKASAN_FITUR_PER_ROLE.md) untuk detail teknis
- Lihat [Daftar Fitur Lengkap](FITUR/DAFTAR_FITUR_LENGKAP.md) untuk API endpoints

### Kontak

Hubungi administrator sistem Anda jika mengalami masalah.

---

## 📝 VERSI DAN PERUBAHAN

**Versi Dokumentasi:** 1.0  
**Tanggal:** Februari 2026  
**Status:** Active

Dokumentasi ini akan terus diperbarui seiring dengan pengembangan aplikasi.

---

**© 2026 Sistem Pengelolaan Laporan Monitoring dan Evaluasi Program Studi**
