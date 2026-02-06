# PANDUAN MEMBUAT PROMPT UNTUK AI

Dokumen ini memberikan tips dan contoh prompts yang dapat Anda gunakan ketika berinteraksi dengan AI (seperti ChatGPT, Claude, GitHub Copilot, dll) untuk mengembangkan atau memperbaiki aplikasi ini.

---

## 📌 TIPS UMUM MEMBUAT PROMPT YANG BAIK

### 1. Berikan Konteks yang Jelas

Sertakan informasi tentang:

- Framework yang digunakan (CodeIgniter 4)
- Language (PHP)
- Database yang digunakan (MySQL)
- Role atau modul yang akan diubah

**Contoh:**

```
Saya menggunakan CodeIgniter 4 dengan PHP dan MySQL.
Saya ingin menambahkan fitur [deskripsi fitur] untuk role [nama role].
```

### 2. Spesifik dan Detail

Jelaskan dengan detail apa yang ingin Anda lakukan:

- Apa yang ingin ditambahkan/diubah
- Alasan mengapa perlu dilakukan
- Expected outcome/hasil yang inginkan

### 3. Referensikan Dokumentasi Fitur

Selalu referensikan dokumen fitur yang ada:

- [DAFTAR_FITUR_LENGKAP.md](FITUR/DAFTAR_FITUR_LENGKAP.md)
- [RINGKASAN_FITUR_PER_ROLE.md](FITUR/RINGKASAN_FITUR_PER_ROLE.md)

### 4. Sertakan Struktur Database/Model

Jika relevan, sertakan informasi:

- Field apa yang ada di model/database
- Relationship antar table
- Validasi yang diperlukan

### 5. Tunjukkan Kode yang Sudah Ada

Jika ada kode yang ingin diperbaiki, copy-paste kode tersebut dalam prompt.

---

## 📋 CONTOH PROMPTS PER KATEGORI TASK

### A. MEMBUAT FITUR BARU

#### Template Prompt:

```
Saya menggunakan CodeIgniter 4 dan ingin menambahkan fitur [nama fitur] untuk role [nama role].

Konteks:
[Jelaskan konteks atau alasan mengapa fitur ini diperlukan]

Spesifikasi:
- [Spesifikasi 1]
- [Spesifikasi 2]
- [Spesifikasi 3]

Yang saya butuhkan:
- [Kebutuhan 1 - contoh: Controller method]
- [Kebutuhan 2 - contoh: Database migration]
- [Kebutuhan 3 - contoh: View template]

Lihat dokumentasi fitur di [reference ke file dokumentasi]
```

#### Contoh Konkret:

```
Saya menggunakan CodeIgniter 4 dan ingin menambahkan fitur "Export Laporan ke Excel"
untuk role Universitas di halaman monitoring laporan.

Konteks:
User universitas ingin dapat mengunduh data semua laporan dalam format Excel
untuk analisis lebih lanjut dan presentasi.

Spesifikasi:
- Tombol "Export to Excel" di halaman monitoring laporan (/univ/monitoring)
- Export harus include: Unit, Periode, Parameter Monev, Nilai, Tanggal
- User harus bisa filter sebelum export (periode, unit, status)
- File Excel harus terstruktur dengan baik dengan format yang rapi
- Format filename: laporan_monev_[tgl]_[jam].xlsx

Yang saya butuhkan:
1. Method di Controller UnivMonitoring untuk handle export
2. Integrasi library PhpSpreadsheet atau sejenisnya
3. Contoh kode untuk membuat file Excel dengan format
4. Update di view untuk menambah tombol export

Lihat: RINGKASAN_FITUR_PER_ROLE.md section "ROLE: UNIVERSITAS"
```

---

### B. MEMPERBAIKI BUG

#### Template Prompt:

```
Ada bug di [lokasi file/modul].

Deskripsi bug:
[Deskripsikan bug secara detail]

Expected behavior:
[Apa yang seharusnya terjadi]

Actual behavior:
[Apa yang benar-benar terjadi]

Error message (jika ada):
[Copy-paste error message]

Kode yang bermasalah:
[Copy-paste kode yang bermasalah]

Context:
[Jelaskan context/latar belakang]
```

#### Contoh Konkret:

```
Ada bug di fitur input laporan monev untuk role Prodi.

Deskripsi bug:
Ketika user prodi menginput laporan monev dan menambahkan file bukti,
file tidak ter-upload ke folder writable.

Expected behavior:
File harus tersimpan di folder /writable/uploads/ dan database
harus menyimpan path file.

Actual behavior:
File tidak tersimpan, dan di form hanya tersimpan link kosong.

Error message:
Tidak ada error di browser, tapi data di database hanya menyimpan
nilai null untuk kolom link_bukti.

Konteks:
Model yang digunakan adalah LaporanMonevModel.php
Form ada di views/prodi/laporan_input.php
Controller yang handle ini adalah Prodi/Laporan.php - method save()

Lihat dokumentasi di RINGKASAN_FITUR_PER_ROLE.md section "ROLE: PRODI"
```

---

### C. REFACTORING/IMPROVEMENT KODE

#### Template Prompt:

```
Saya ingin merefactor [deskripsi bagian kode] untuk [tujuan improvement].

Current situation:
[Jelaskan kode saat ini, bisa include copy-paste kode]

Goal/Improvement yang ingin dicapai:
[Jelaskan improvement yang diinginkan - contoh: lebih readable,
 lebih efficient, follow best practice, dll]

Constraints:
- [Constraint 1 - contoh: tidak boleh mengubah API endpoint]
- [Constraint 2]

Tools/Library yang boleh digunakan:
- [Library 1]
- [Library 2]
```

#### Contoh Konkret:

```
Saya ingin merefactor method save() di Prodi/Laporan Controller
untuk membuat kode lebih clean dan maintainable.

Current situation:
Method save() saat ini punya 50+ baris dengan nested if-else yang dalam.
Validasi, insert, upload file, dan response semua dicampur dalam satu method.

Goal/Improvement yang ingin dicapai:
- Separated concerns (validasi, insert, upload dalam method terpisah)
- Lebih readable dan mudah di-maintain
- Follow CodeIgniter 4 best practices
- Tetap maintain functionality yang sama

Constraints:
- Tidak boleh mengubah endpoint route yang sudah ada
- Backward compatible dengan database dan model yang ada
- Request/Response format harus tetap sama

Tools yang boleh digunakan:
- Traits untuk helper methods
- Service layer jika diperlukan
- Built-in CodeIgniter validators
```

---

### D. MENAMBAH VALIDASI/SECURITY

#### Template Prompt:

```
Saya ingin menambahkan validasi/security check untuk [deskripsi].

Lokasi:
[Tuliskan lokasi file yang akan diubah]

Current validation:
[Jelaskan validasi yang sudah ada, atau "belum ada"]

Validasi yang ingin ditambahkan:
- [Validasi 1]
- [Validasi 2]
- [Validasi 3]

Security concern:
[Jelaskan concern security yang ingin diatasi -
 contoh: SQL injection, unauthorized access, data validation, dll]
```

#### Contoh Konkret:

```
Saya ingin menambahkan validasi dan security check
untuk method hapusProdi() di Univ/Master controller.

Lokasi:
app/Controllers/Univ/Master.php - method hapusProdi($id)

Current validation:
Hanya check apakah $id parameter ada.

Validasi yang ingin ditambahkan:
- Validasi bahwa user yang login adalah role UNIVERSITAS
- Validasi bahwa prodi dengan ID tersebut benar-benar ada
- Validasi bahwa tidak boleh menghapus prodi yang masih punya laporan monev
- Validasi CSRF token
- Return proper error response jika validasi gagal

Security concern:
- Prevent unauthorized role menghapus data
- Prevent orphan records (prodi dihapus tapi laporan masih ada)
- Prevent direct API call tanpa CSRF token
```

---

### E. MENAMBAH FITUR UNTUK ROLE YANG SAMA

#### Template Prompt:

```
Role [nama role] saat ini punya fitur [daftar fitur yang ada].

Saya ingin menambahkan fitur baru: [nama fitur baru].

Detail fitur baru:
[Penjelasan detail tentang fitur]

Form fields yang diperlukan:
- [Field 1]
- [Field 2]
- [Field 3]

Data yang akan diakses:
[Model dan table apa yang akan digunakan]

Expected flow:
1. [Step 1]
2. [Step 2]
3. [Step 3]

Lihat dokumentasi di [reference file dokumentasi]
```

#### Contoh Konkret:

```
Role Prodi saat ini punya fitur input laporan, input kinerja, dan input akreditasi.

Saya ingin menambahkan fitur baru: "Dashboard Analytics" yang menampilkan
grafik dan statistik dari laporan dan kinerja prodi.

Detail fitur baru:
- Dashboard yang menampilkan chart trend laporan monev dari multiple periode
- Bar chart untuk perbandingan kinerja antar prodi (jika ada)
- Summary card yang menampilkan KPI terbaru
- Table riwayat dengan pagination

Form fields yang diperlukan:
(Tidak ada form - hanya view dengan data dari database)

Data yang akan diakses:
- Model: LaporanMonevModel, KinerjaProdiUnitModel, ProdiModel
- Table: laporan_monev, kinerja_prodi_unit, mProdi, setting_periode, mMonev, mKinerja

Expected flow:
1. User Prodi click "Dashboard Analytics" di menu
2. Controller fetch data dari 3-5 periode terakhir
3. Process data untuk dibuat chart
4. Pass ke view dan render chart menggunakan library Chart.js atau Apex Charts
5. Display summary statistics
6. Display history table dengan filter

Requirement:
- Use existing styling (sudah ada di public/css/master.css)
- Use Chart library yang already available (atau recommend library baru)
- Responsive design untuk mobile
- Performance: query harus optimized

Lihat dokumentasi di RINGKASAN_FITUR_PER_ROLE.md section "ROLE: PRODI"
```

---

### F. PERTANYAAN STRUKTUR/ARCHITECTURE

#### Template Prompt:

```
Saya punya pertanyaan tentang architecture/struktur aplikasi [deskripsi].

Konteks:
[Jelaskan konteks pertanyaannya]

Pertanyaan spesifik:
1. [Pertanyaan 1]
2. [Pertanyaan 2]
3. [Pertanyaan 3]

Constraints/Limitations yang ada:
[Jelaskan constraint yang perlu dipertimbangkan]

Goal bisnis yang ingin dicapai:
[Jelaskan tujuan bisnis]
```

#### Contoh Konkret:

```
Saya punya pertanyaan tentang relationship antara Prodi dan Laporan Monev.

Konteks:
Saat ini, satu Prodi bisa punya banyak Laporan Monev (setiap periode ada laporan baru).
Saat menampilkan laporan, saya perlu join dengan multiple tables (mMonev, mProdi,
mFakultas, setting_periode).

Pertanyaan spesifik:
1. Apakah perlu membuat separate table untuk "laporan summary" atau
   query dengan join itu OK?
2. Apakah struktur database yang sekarang sudah optimal untuk reporting kebutuhan?
3. Apakah perlu menambah index di kolom mana untuk optimize query performance?

Constraints:
- Database sudah production (tidak bisa major migration)
- Query response time harus < 2 detik untuk halaman monitoring
- Existing code harus remain backward compatible

Goal bisnis:
- Laporan harus load cepat (< 2 detik)
- User universitas harus bisa filter/search laporan dengan berbagai criteria
- Export laporan ke Excel harus bisa handle 1000+ records

Lihat:
- Model: app/Models/LaporanMonevModel.php
- Database: Dokumentasi tables di RINGKASAN_FITUR_PER_ROLE.md
```

---

## 🎯 PROMPT TEMPLATE UMUM

### Template 1: Feature Request

```
Framework: [Framework]
Language: [Language]
Database: [Database]

Fitur yang ingin dibuat: [Nama fitur]
Role/Module: [Role yang akan menggunakan fitur]

Deskripsi:
[Deskripsi lengkap fitur]

Requirement:
- [Req 1]
- [Req 2]
- [Req 3]

Yang saya butuhkan:
- [Deliverable 1 - contoh: Controller method]
- [Deliverable 2 - contoh: Database migration]
- [Deliverable 3 - contoh: View template]

Referensi dokumentasi:
[Link ke file dokumentasi yang relevan]
```

### Template 2: Bug Fix

```
Framework: [Framework]
Language: [Language]

File yang bermasalah: [Path file]

Deskripsi problem:
[Jelaskan secara detail apa masalahnya]

Expected result:
[Apa yang seharusnya terjadi]

Actual result:
[Apa yang benar-benar terjadi]

Kode yang bermasalah:
[Code snippet]

Sudah diketahui ada error message: [Ya/Tidak]
Error message: [Jika ada]
```

### Template 3: Code Review / Improvement

```
Framework: [Framework]
Language: [Language]

Tujuan improvement:
[Jelaskan tujuan improvement - contoh: performance, maintainability, security, dll]

Kode sekarang:
[Code snippet]

Concern/Issues saat ini:
- [Issue 1]
- [Issue 2]

Constraints:
- [Constraint 1]
- [Constraint 2]

Yang diharapkan:
[Jelaskan hasil yang diharapkan]
```

---

## 📚 REFERENSI DOKUMENTASI YANG SERING DIGUNAKAN

Dalam membuat prompt, selalu reference dokumentasi berikut:

1. **Untuk membuat fitur baru atau memahami struktur:**
   - [RINGKASAN_FITUR_PER_ROLE.md](FITUR/RINGKASAN_FITUR_PER_ROLE.md)
   - Section: "ROLE: [nama role]"
   - Section: "DATABASE SCHEMA SUMMARY"

2. **Untuk memahami fitur yang sudah ada:**
   - [DAFTAR_FITUR_LENGKAP.md](FITUR/DAFTAR_FITUR_LENGKAP.md)
   - Section: "FITUR UNTUK ROLE [nama role]"

3. **Untuk user-facing documentation:**
   - [PANDUAN\_(nama role).md](PANDUAN/)
   - Lihat alur kerja dan menu yang tersedia

4. **Untuk architecture/structure:**
   - [RINGKASAN_FITUR_PER_ROLE.md](FITUR/RINGKASAN_FITUR_PER_ROLE.md)
   - Section: "CONTROLLERS YANG TERSEDIA"
   - Section: "MODELS YANG TERSEDIA"

---

## ✅ CHECKLIST SEBELUM MENGIRIM PROMPT

Sebelum mengirim prompt ke AI, pastikan:

- [ ] Saya sudah membaca dokumentasi yang relevan
- [ ] Saya sudah clear tentang apa yang ingin saya capai
- [ ] Saya sudah provide konteks yang cukup (framework, language, db, role)
- [ ] Saya sudah spesifik tentang requirement/deliverable
- [ ] Saya sudah include kode yang relevan (jika ada)
- [ ] Saya sudah mention constraints/limitations
- [ ] Saya sudah reference file dokumentasi yang relevan
- [ ] Prompt saya sudah jelas dan tidak ambiguous

---

## 💡 TIPS IMPLEMENTASI AFTER GETTING RESPONSE

Setelah mendapatkan response dari AI:

1. **Review code/hasil yang diberikan:**
   - Pastikan sesuai dengan requirement
   - Pastikan follow coding style yang ada
   - Pastikan tidak break existing functionality

2. **Test sebelum commit:**
   - Test di local environment
   - Test berbagai scenario/edge case
   - Check untuk error handling

3. **Update dokumentasi jika perlu:**
   - Update file fitur jika ada feature baru
   - Update panduan pengguna jika UI berubah

4. **Ask follow-up questions jika ada yang kurang:**
   - AI tidak selalu sempurna
   - Jangan ragu untuk ask clarification atau improvement

---

**Happy prompting! 🚀**

Semoga dokumentasi ini membantu Anda dalam mengembangkan aplikasi lebih efektif dengan bantuan AI.
