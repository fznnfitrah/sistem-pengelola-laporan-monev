# RINGKASAN FITUR PER ROLE - UNTUK PEMBUATAN PROMPT

Dokumen ini berisi ringkasan fitur-fitur yang tersedia per role/peran pengguna. Format ini dirancang untuk memudahkan Anda membuat prompt atau dokumentasi lebih lanjut.

---

## ROLE: ADMIN

**Deskripsi Singkat:**
Admin bertanggung jawab mengelola pengguna dan role dalam sistem. Memiliki akses penuh terhadap manajemen user dan permission.

**Fitur Utama:**

1. Kelola Pengguna (CRUD: Create, Read, Update, Delete)
2. Kelola Role (CRUD: Create, Read, Update, Delete)
3. Dashboard Admin dengan statistik sistem

**API Endpoints:**

```
[ADMIN USERS]
GET    /admin/users                 - View all users
GET    /admin/users/add             - Add user form
POST   /admin/users/save            - Save new user
GET    /admin/users/edit/:id        - Edit user form
PUT    /admin/users/:id             - Update user
DELETE /admin/users/:id             - Delete user

[ADMIN ROLES]
GET    /admin/roles                 - View all roles
GET    /admin/roles/add             - Add role form
POST   /admin/roles/save            - Save new role
GET    /admin/roles/edit/:id        - Edit role form
PUT    /admin/roles/:id             - Update role
DELETE /admin/roles/:id             - Delete role
```

**Database Tables:**

- `user` - Data pengguna
- `role` - Data role
- `permission` - Data permission
- `role_permission` - Mapping role dan permission

**Permission Related:**

- Create, Read, Update, Delete Users
- Create, Read, Update, Delete Roles
- Assign roles to users
- Manage permissions

---

## ROLE: UNIVERSITAS (UNIV)

**Deskripsi Singkat:**
Role Universitas mengelola master data universitas, mengatur parameter sistem (monev, kinerja), dan memonitor laporan dari seluruh organisasi. Bertanggung jawab atas struktur akademik dan pengaturan periode.

**Fitur Utama:**

1. Master Data Universitas (Fakultas, Prodi, Unit, Lembaga)
2. Pengaturan Periode Akademik
3. Master Data Monev dan Kinerja
4. Jenjang Program Studi
5. Lembaga Akreditasi
6. Monitoring Laporan dari semua unit
7. Monitoring Akreditasi Program Studi

**API Endpoints:**

```
[MASTER - FAKULTAS & PRODI]
GET    /univ/master                      - Master data page
POST   /univ/master/simpanFakultas       - Save fakultas
POST   /univ/master/editFakultas         - Edit fakultas
GET    /univ/master/hapusFakultas/:id    - Delete fakultas
POST   /univ/master/simpanProdi          - Save prodi
POST   /univ/master/editProdi            - Edit prodi
GET    /univ/master/hapusProdi/:id       - Delete prodi

[UNIT & LEMBAGA]
GET    /univ/unit                    - Unit page
POST   /univ/unit/simpan             - Save unit
POST   /univ/unit/edit               - Edit unit
GET    /univ/unit/hapus/:id          - Delete unit

[PERIODE AKADEMIK]
GET    /univ/periode                  - Periode page
POST   /univ/periode/simpan           - Save periode
GET    /univ/periode/setAktif/:id     - Set active periode
GET    /univ/periode/hapus/:id        - Delete periode

[MASTER MONEV]
GET    /univ/monev                    - Monev page
POST   /univ/monev/simpan             - Save monev
POST   /univ/monev/update             - Update monev
GET    /univ/monev/hapus/:id          - Delete monev
POST   /univ/monev/copy               - Copy monev from previous period

[MASTER KINERJA]
GET    /univ/kinerja                  - Kinerja page
POST   /univ/kinerja/simpan           - Save kinerja
POST   /univ/kinerja/edit             - Edit kinerja
GET    /univ/kinerja/hapus/:id        - Delete kinerja

[JENJANG]
GET    /univ/jenjang                  - Jenjang page
POST   /univ/jenjang/simpan           - Save jenjang
POST   /univ/jenjang/edit             - Edit jenjang
GET    /univ/jenjang/hapus/:id        - Delete jenjang

[LEMBAGA AKREDITASI]
GET    /univ/lembaga_akreditasi               - Lembaga page
POST   /univ/lembaga_akreditasi/simpan        - Save lembaga
POST   /univ/lembaga_akreditasi/edit          - Edit lembaga
GET    /univ/lembaga_akreditasi/hapus/:id     - Delete lembaga

[INPUT AKREDITASI]
GET    /univ/akreditasi/input         - Akreditasi input form
POST   /univ/akreditasi/simpan        - Save akreditasi

[MONITORING]
GET    /univ/monitoring               - Monitoring laporan
GET    /univ/monitoring/akreditasi    - Monitoring akreditasi
GET    /univ/monitoring/rekap         - Rekap akreditasi
```

**Database Tables:**

- `mFakultas` - Data fakultas
- `mProdi` - Data program studi
- `mUnit` - Data unit kerja
- `mJenjang` - Jenjang program studi
- `mLembagaAkreditasi` - Lembaga akreditasi
- `setting_periode` - Periode akademik
- `mMonev` - Master monev
- `mKinerja` - Master kinerja
- `akreditasi` - Data akreditasi program studi
- `laporan_monev` - Laporan monev dari unit

**Key Responsibilities:**

- Set up periode akademik aktif
- Maintain struktur akademik (fakultas, prodi, unit)
- Define parameter monev dan kinerja
- Monitor pengumpulan laporan
- Monitor status akreditasi

---

## ROLE: FAKULTAS

**Deskripsi Singkat:**
Role Fakultas melihat dan memonitor laporan dari semua program studi yang ada dalam fakultasnya. Berperan sebagai level menengah antara universitas dan prodi.

**Fitur Utama:**

1. Dashboard Fakultas dengan statistik prodi
2. Melihat semua laporan dari prodi dalam fakultas
3. Monitoring status pengumpulan laporan
4. Analisa data menggunakan filter dan cari

**API Endpoints:**

```
[DASHBOARD]
GET    /fakultas/dashboard           - Fakultas dashboard

[LAPORAN]
GET    /fakultas/laporan/input       - Input laporan form
POST   /fakultas/laporan/simpan      - Save laporan
GET    /fakultas/laporan/history     - View laporan history

[MONITORING]
GET    /fakultas/monitoring          - Monitoring laporan
```

**Database Tables:**

- `laporan_monev` - Access to all reports from prodi in faculty
- `mProdi` - Program studi info
- `mMonev` - Monev parameter reference
- `setting_periode` - Periode reference

**Key Responsibilities:**

- Monitor pengumpulan laporan dari prodi
- Analyze laporan prodi
- Report to universitas tentang status prodi

---

## ROLE: PRODI (PROGRAM STUDI)

**Deskripsi Singkat:**
Role Prodi mengisi laporan monitoring dan evaluasi, menginput data kinerja, dan mengelola data akreditasi program studi. Level paling bawah dalam hierarki pelaporan.

**Fitur Utama:**

1. Input Laporan Monitoring dan Evaluasi
2. Input Data Kinerja Program Studi
3. Kelola Data Akreditasi (BAN-PT, ASIC, FIBAA, dst)
4. Melihat Riwayat Laporan yang sudah dikumpulkan
5. Edit dan Hapus laporan (sebelum deadline)

**API Endpoints:**

```
[LAPORAN MONEV]
GET    /prodi/laporan/input          - Input form
POST   /prodi/laporan/save           - Save laporan
GET    /prodi/laporan/history        - View history

[KINERJA]
GET    /prodi/kinerja/input          - Input form
POST   /prodi/kinerja/save           - Save kinerja

[AKREDITASI]
GET    /prodi/akreditasi/index       - View akreditasi list
GET    /prodi/akreditasi/new         - Add akreditasi form
POST   /prodi/akreditasi/simpan      - Save akreditasi
```

**Database Tables:**

- `laporan_monev` - Laporan monev dari prodi
- `kinerja` - Data kinerja prodi
- `akreditasi` - Data akreditasi prodi
- `mMonev` - Reference monev parameter
- `mKinerja` - Reference kinerja parameter
- `mProdi` - Program studi info
- `setting_periode` - Active periode reference

**Form Fields untuk Input Laporan:**

```
Periode Akademik (required)
Program Studi (auto-filled)
Monev Parameters (dynamic based on master monev):
  - Nama Monev 1: [input nilai]
  - Nama Monev 2: [input nilai]
  - ... (sesuai jumlah monev)
Link Bukti Pendukung (optional)
Keterangan (optional textarea)
```

**Form Fields untuk Input Kinerja:**

```
Periode Akademik (required)
Program Studi (auto-filled)
Kinerja Parameters (dynamic):
  - Nama Kinerja 1: [input nilai]
  - Nama Kinerja 2: [input nilai]
  - ... (sesuai jumlah kinerja)
Target (optional)
Bukti Pendukung (optional)
Keterangan (optional)
```

**Key Responsibilities:**

- Input laporan monev secara berkala
- Memastikan data kinerja selalu up-to-date
- Maintain data akreditasi
- Memenuhi deadline pengumpulan laporan

---

## ROLE: UNIT (UNIT KERJA / LEMBAGA)

**Deskripsi Singkat:**
Role Unit mengisi laporan monitoring dan evaluasi unit, menginput data kinerja unit, serta melihat riwayat laporan. Mirip dengan Prodi tetapi untuk unit kerja/lembaga.

**Fitur Utama:**

1. Input Laporan Monitoring dan Evaluasi Unit
2. Input Data Kinerja Unit
3. Melihat Riwayat Laporan yang sudah dikumpulkan
4. Edit dan Hapus laporan (sebelum deadline)

**API Endpoints:**

```
[LAPORAN MONEV]
GET    /unit/laporan/input           - Input form
POST   /unit/laporan/save            - Save laporan
GET    /unit/laporan/history         - View history

[KINERJA]
GET    /unit/kinerja/input           - Input form
POST   /unit/kinerja/save            - Save kinerja
```

**Database Tables:**

- `laporan_monev` - Laporan monev dari unit (filtered by unit)
- `kinerja` - Data kinerja unit
- `mMonev` - Reference monev parameter
- `mKinerja` - Reference kinerja parameter
- `mUnit` - Unit info
- `setting_periode` - Active periode reference

**Form Fields sama dengan Prodi:**

```
Periode Akademik (required)
Unit (auto-filled)
Monev/Kinerja Parameters (dynamic)
Bukti Pendukung (optional)
Keterangan (optional)
```

**Key Responsibilities:**

- Input laporan monev unit secara berkala
- Memastikan data kinerja unit selalu up-to-date
- Memenuhi deadline pengumpulan laporan

---

## FITUR UMUM (SEMUA ROLE)

### Authentication

```
GET    /login                    - Login page
POST   /auth/login               - Process login
GET    /auth/logout              - Logout
GET    /auth/switch/:id          - Switch ke role lain (jika user punya multiple role)
```

### Profile

```
GET    /profile                  - View profil
GET    /profile/edit             - Edit profil form
POST   /profile/update           - Save profil changes
```

### Dashboard

```
GET    /                          - Root (redirect ke dashboard)
GET    /dashboard                 - General dashboard
```

---

## CONTROLLERS YANG TERSEDIA

### Admin Controllers

- `app/Controllers/Admin/Roles.php` - Manajemen role
- `app/Controllers/Admin/Users.php` - Manajemen pengguna

### Universitas Controllers

- `app/Controllers/Univ/Master.php` - Master data fakultas & prodi
- `app/Controllers/Univ/Unit.php` - Manajemen unit
- `app/Controllers/Univ/Periode.php` - Manajemen periode
- `app/Controllers/Univ/Monev.php` - Master monev
- `app/Controllers/Univ/Kinerja.php` - Master kinerja
- `app/Controllers/Univ/Jenjang.php` - Master jenjang
- `app/Controllers/Univ/LembagaAkreditasi.php` - Master lembaga akreditasi
- `app/Controllers/Univ/Akreditasi.php` - Input akreditasi
- `app/Controllers/Univ/Monitoring.php` - Monitoring laporan
- `app/Controllers/Univ/MonitoringAkreditasi.php` - Monitoring akreditasi

### Fakultas Controllers

- `app/Controllers/Fakultas/Dashboard.php` - Dashboard fakultas
- `app/Controllers/Fakultas/Laporan.php` - Laporan fakultas
- `app/Controllers/Fakultas/Monitoring.php` - Monitoring fakultas

### Prodi Controllers

- `app/Controllers/Prodi/Laporan.php` - Input/view laporan prodi
- `app/Controllers/Prodi/KinerjaProdiUnit.php` - Input kinerja prodi
- `app/Controllers/Prodi/Akreditasi.php` - Manajemen akreditasi prodi

### Unit Controllers

- `app/Controllers/Unit/Laporan.php` - Input/view laporan unit
- `app/Controllers/Unit/KinerjaProdiUnit.php` - Input kinerja unit

### Umum Controllers

- `app/Controllers/Auth.php` - Authentication (login, logout, switch)
- `app/Controllers/Dashboard.php` - Dashboard umum
- `app/Controllers/Profile.php` - Profil pengguna

---

## MODELS YANG TERSEDIA

**Key Models:**

- `UserModel.php` - Data pengguna
- `RoleModel.php` - Data role
- `FakultasModel.php` - Data fakultas
- `ProdiModel.php` - Data program studi
- `UnitModel.php` - Data unit
- `PeriodeModel.php` - Data periode akademik
- `MonevModel.php` - Master monev
- `KinerjaModel.php` - Master kinerja
- `JenjangModel.php` - Master jenjang
- `LembagaAkreditasiModel.php` - Lembaga akreditasi
- `AkreditasiModel.php` - Data akreditasi
- `LaporanMonevModel.php` - Laporan monev
- `KinerjaProdiUnitModel.php` - Data kinerja prodi/unit

---

## DATABASE SCHEMA SUMMARY

**Tables:**

- `user` (id, username, email, password, role_id)
- `role` (id, nama_role, deskripsi)
- `permission` (id, nama_permission)
- `role_permission` (role_id, permission_id)
- `mFakultas` (id, nama_fakultas, kode_fakultas, deskripsi)
- `mProdi` (id, nama_prodi, kode_prodi, fk_fakultas, fk_jenjang)
- `mUnit` (id, nama_unit, kode_unit)
- `mJenjang` (id, nama_jenjang, kode_jenjang)
- `mLembagaAkreditasi` (id, nama_lembaga, singkatan)
- `setting_periode` (id, tahun_akademik, semester, status_aktif)
- `mMonev` (id, nama_monev, fk_setting_periode, status)
- `mKinerja` (id, nama_kinerja, target, satuan)
- `akreditasi` (id, fk_prodi, fk_lembaga_akreditasi, status, nilai, tgl_sertifikat, masa_berlaku)
- `laporan_monev` (id, fk_prodi/fk_unit, fk_setting_periode, fk_monev, keterangan, link_bukti)
- `kinerja_prodi_unit` (id, fk_prodi/fk_unit, fk_kinerja, nilai, link_bukti)

---

**Catatan:** Dokumen ini dirancang untuk membantu Anda membuat prompt atau dokumentasi lebih lanjut. Sesuaikan dengan kebutuhan spesifik Anda.
