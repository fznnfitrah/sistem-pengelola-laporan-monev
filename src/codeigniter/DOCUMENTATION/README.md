# Dokumentasi Sistem Pengelolaan Laporan Monitoring dan Evaluasi Program Studi

## Daftar Isi

1. [Panduan Penggunaan](#panduan-penggunaan)
2. [Daftar Fitur](#daftar-fitur)
3. [Informasi Tambahan](#informasi-tambahan)

## Panduan Penggunaan

Folder `PANDUAN` berisi dokumentasi lengkap tentang cara menggunakan sistem ini, termasuk:

- Panduan instalasi dan setup
- Panduan pengguna untuk setiap role/peran
- Alur kerja dan prosedur penggunaan

Lihat file-file di dalam folder `PANDUAN` untuk detail lebih lanjut.

## Daftar Fitur

Folder `FITUR` berisi daftar lengkap semua fitur yang tersedia dalam sistem, terorganisir berdasarkan role/peran pengguna:

- Fitur Admin
- Fitur Universitas
- Fitur Fakultas
- Fitur Prodi
- Fitur Unit

Lihat file-file di dalam folder `FITUR` untuk detail lengkap fitur-fitur yang tersedia.

## Informasi Tambahan

**Teknologi yang Digunakan:**

- Framework: CodeIgniter 4
- Database: MySQL
- Backend: PHP
- Frontend: HTML, CSS, JavaScript
- Containerization: Docker

**Setup Awal:**

```bash
# Masuk ke bash container ci_app
docker exec -it ci_app bash

# Install composer
composer install

# Ubah kepemilikan folder writable
chown -R www-data:www-data /var/www/codeigniter/writable

# Set permission aman
chmod -R 775 /var/www/codeigniter/writable
```

---

_Dokumentasi ini dibuat untuk membantu pengembangan dan maintenance sistem._
