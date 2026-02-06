# PANDUAN INSTALASI DAN SETUP SISTEM

## 1. Prasyarat Sistem

Sebelum memulai, pastikan Anda memiliki:

- **Docker** dan **Docker Compose** terinstall
- **Git** untuk clone repository
- Minimal **1 GB RAM** dan **2 GB storage space**

---

## 2. Tahap Setup Lingkungan Docker

### Step 1: Clone Repository

```bash
git clone <repository-url>
cd sistem-pengelola-laporan-monev
```

### Step 2: Build dan Jalankan Docker Container

```bash
docker-compose up -d
```

Tunggu hingga semua container berjalan dengan baik. Anda dapat mengecek status dengan:

```bash
docker-compose ps
```

### Step 3: Install Dependencies PHP (Composer)

```bash
docker exec -it ci_app bash
```

Setelah masuk ke bash container, jalankan:

```bash
composer install
```

### Step 4: Setup Folder Writable Permissions

Masih di dalam bash container, jalankan:

```bash
chown -R www-data:www-data /var/www/codeigniter/writable
chmod -R 775 /var/www/codeigniter/writable
```

### Step 5: Setup Database

```bash
# Jalankan migration
php spark migrate

# (Optional) Jalankan seeder untuk data dummy
php spark db:seed
```

---

## 3. Konfigurasi Aplikasi

### File Konfigurasi Penting:

**`.env` file:**

```
CI_ENVIRONMENT = development
database.default.hostname = db
database.default.database = nama_database
database.default.username = user
database.default.password = password
```

**`app/Config/Database.php`:**

- Sesuaikan konfigurasi database Anda

**`app/Config/App.php`:**

- Sesuaikan base URL aplikasi

---

## 4. Akses Aplikasi

Setelah setup selesai, akses aplikasi melalui:

- **URL:** `http://localhost:8080`
- **Default Login:**
  - Username: `admin` (atau sesuai dengan data seeder)
  - Password: (lihat dokumentasi seeder)

---

## 5. Troubleshooting

### Masalah: Container tidak bisa diakses

**Solusi:**

```bash
# Restart container
docker-compose restart

# Cek logs
docker-compose logs ci_app
```

### Masalah: Permission denied pada folder writable

**Solusi:**

```bash
docker exec -it ci_app bash
chown -R www-data:www-data /var/www/codeigniter/writable
chmod -R 775 /var/www/codeigniter/writable
```

### Masalah: Database tidak connect

**Solusi:**

1. Pastikan service database sudah running
2. Cek konfigurasi di `.env` dan `app/Config/Database.php`
3. Verifikasi credentials database

---

## 6. Menghentikan & Membersihkan

### Hentikan Container:

```bash
docker-compose down
```

### Hapus Volume (Hati-hati: akan menghapus data database):

```bash
docker-compose down -v
```

---

**Untuk dokumentasi lebih lanjut, lihat panduan pengguna di folder `PANDUAN`.**
