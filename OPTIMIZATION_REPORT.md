# 📋 LAPORAN OPTIMASI CODE

## 🔍 ANALISIS REDUNDANSI & REKOMENDASI

---

## 1. ⚠️ SECURITY ISSUES (PRIORITAS TINGGI)

### Issue 1.1: Plain Text Password di Auth.php

**File:** [Auth.php](src/codeigniter/app/Controllers/Auth.php#L42)
**Masalah:** Password dibandingkan dengan plain text

```php
if ($user && $password == $user['password']) {  // ❌ SANGAT TIDAK AMAN
```

**Solusi:** Gunakan password_verify()

```php
if ($user && password_verify($password, $user['password'])) {  // ✅ AMAN
```

### Issue 1.2: No Validation pada Login

**File:** [Auth.php](src/codeigniter/app/Controllers/Auth.php#L29)
**Masalah:** Tidak ada validasi input POST
**Solusi:** Tambahkan validation

```php
if (!$this->validate([
    'email' => 'permit_empty|valid_email',
    'username' => 'permit_empty|required_without[email]',
    'password' => 'required'
])) {
    return redirect()->back()->with('errors', $this->validator->getErrors());
}
```

### Issue 1.3: No CSRF Protection

**File:** Semua form di Views
**Masalah:** Tidak ada CSRF token di form
**Solusi:** Tambahkan di setiap form

```php
<?= csrf_field() ?>
```

### Issue 1.4: No Rate Limiting pada Login

**File:** [Auth.php](src/codeigniter/app/Controllers/Auth.php#L28)
**Masalah:** Brute force attack tidak dicegah
**Solusi:** Implementasi rate limiting (library atau custom)

---

## 2. 🔄 REDUNDANSI CODE

### Redundansi 2.1: CRUD Pattern yang Sama di Multiple Controller

**Files:**

- [Roles.php](src/codeigniter/app/Controllers/Admin/Roles.php)
- [Users.php](src/codeigniter/app/Controllers/Admin/Users.php)
- [Master.php](src/codeigniter/app/Controllers/Univ/Master.php)

**Pattern Redundan:**

```php
// TIGA CONTROLLER MENGGUNAKAN POLA YANG SAMA:
public function save() {
    if (!$this->validate([...])) {
        return redirect()->back();
    }
    $this->model->save($data);
    return redirect()->with('message', 'Berhasil!');
}
```

**Solusi:** Buat Base CRUD Controller

```php
// Buat: app/Controllers/CrudController.php
abstract class CrudController extends BaseController {
    protected $model;
    protected $viewPath;
    protected $routePath;

    public function save() {
        if (!$this->validate($this->getValidationRules())) {
            return redirect()->back()->withInput();
        }
        $this->model->save($this->getDataFromRequest());
        return redirect()->to($this->routePath)
            ->with('message', ucfirst($this->getItemName()) . ' berhasil ditambahkan!');
    }

    // Template method pattern
    protected function getValidationRules() {}
    protected function getDataFromRequest() {}
    protected function getItemName() {}
}
```

### Redundansi 2.2: Validation Rules Duplikat

**Files:**

- [Roles.php](src/codeigniter/app/Controllers/Admin/Roles.php#L40)
- [Roles.php](src/codeigniter/app/Controllers/Admin/Roles.php#L95)

**Masalah:**

```php
// save() dan update() memiliki validasi yg sama
if (!$this->validate([
    'nama_roles' => [
        'rules'  => 'required|is_unique[roles.nama_roles]',  // Duplikat
        'errors' => [...]
    ]
])) { ... }

// update()
if (!$this->validate([
    'nama_roles' => [
        'rules'  => "required|is_unique[roles.nama_roles,id,{$id}]",  // Sama, hanya ID berbeda
        'errors' => [...]
    ]
])) { ... }
```

**Solusi:** Pindahkan ke method/class terpisah

```php
// app/Validation/RoleValidation.php
class RoleValidation {
    public static function getValidationRules($isUpdate = false, $id = null) {
        $uniqueRule = 'required|is_unique[roles.nama_roles]';
        if ($isUpdate) {
            $uniqueRule = "required|is_unique[roles.nama_roles,id,{$id}]";
        }

        return [
            'nama_roles' => [
                'rules'  => $uniqueRule,
                'errors' => [
                    'required'  => 'Nama Role wajib diisi.',
                    'is_unique' => 'Nama Role sudah ada, gunakan nama lain.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => ['max_length' => 'Deskripsi terlalu panjang.']
            ]
        ];
    }
}

// Di Controller:
use App\Validation\RoleValidation;

public function save() {
    if (!$this->validate(RoleValidation::getValidationRules())) {
        return redirect()->back()->withInput();
    }
    // ...
}

public function update($id) {
    if (!$this->validate(RoleValidation::getValidationRules(true, $id))) {
        return redirect()->back()->withInput();
    }
    // ...
}
```

### Redundansi 2.3: Null Safety Logic Duplikat

**File:** [Users.php](src/codeigniter/app/Controllers/Admin/Users.php#L62) dan [Users.php](src/codeigniter/app/Controllers/Admin/Users.php#L151)

**Masalah:**

```php
// Di save() baris 62
$fkFakultas = $this->request->getPost('fk_fakultas');
$fkProdi    = $this->request->getPost('fk_prodi');
$fkUnit     = $this->request->getPost('fk_unit');

$this->userModel->save([
    'fk_fakultas' => (empty($fkFakultas)) ? null : $fkFakultas,
    'fk_prodi'    => (empty($fkProdi))    ? null : $fkProdi,
    'fk_unit'     => (empty($fkUnit))     ? null : $fkUnit,
]);

// SAMA DI update() baris 151
```

**Solusi:** Buat Helper Method

```php
protected function getNullSafeValue($fieldName) {
    $value = $this->request->getPost($fieldName);
    return empty($value) ? null : $value;
}

// Usage:
$this->userModel->save([
    'fk_fakultas' => $this->getNullSafeValue('fk_fakultas'),
    'fk_prodi'    => $this->getNullSafeValue('fk_prodi'),
    'fk_unit'     => $this->getNullSafeValue('fk_unit'),
]);
```

### Redundansi 2.4: CRUD Operations di Master.php

**File:** [Master.php](src/codeigniter/app/Controllers/Univ/Master.php)

**Masalah:**

```php
// simpanFakultas()
$this->fakultasModel->insert([...]);
return redirect()->back()->with('success', 'Fakultas baru berhasil ditambahkan!');

// simpanProdi()
$this->prodiModel->insert([...]);
return redirect()->back()->with('success', 'Program Studi baru berhasil ditambahkan!');

// editFakultas()
$this->fakultasModel->update($id_lama, $data);
return redirect()->back()->with('success', 'Data Fakultas berhasil diperbarui!');

// editProdi()
$this->prodiModel->update($id_lama, $data);
return redirect()->back()->with('success', 'Data Program Studi berhasil diperbarui!');
```

**Solusi:** Gunakan Generic Method

```php
protected function handleSave($model, $entityName) {
    $model->insert($this->getInsertData());
    return redirect()->back()->with('success',
        "$entityName baru berhasil ditambahkan!");
}

protected function handleEdit($model, $idLama, $entityName) {
    $model->update($idLama, $this->getUpdateData());
    return redirect()->back()->with('success',
        "Data $entityName berhasil diperbarui!");
}

public function simpanFakultas() {
    return $this->handleSave($this->fakultasModel, 'Fakultas');
}

public function simpanProdi() {
    return $this->handleSave($this->prodiModel, 'Program Studi');
}
```

---

## 3. ✨ CODE QUALITY IMPROVEMENTS

### Issue 3.1: Inconsistent Error Handling

**Files:** Multiple Controllers
**Masalah:**

```php
// Ada yang cek data exist sebelum delete (Users.php)
$user = $this->userModel->find($id);
if (!$user) {
    return redirect()->back()->with('error', 'User tidak ditemukan.');
}

// Ada yang tidak (Master.php)
public function hapusFakultas($id) {
    $this->fakultasModel->delete($id);  // Langsung delete tanpa cek
    return redirect()->back()->with('success', 'Fakultas berhasil dihapus!');
}
```

**Solusi:** Standardisasi error checking

```php
protected function deleteWithCheck($model, $id, $entityName) {
    if (!$model->find($id)) {
        return redirect()->back()->with('error', "$entityName tidak ditemukan.");
    }
    $model->delete($id);
    return redirect()->back()->with('success', "$entityName berhasil dihapus!");
}
```

### Issue 3.2: No Input Validation di Master.php

**File:** [Master.php](src/codeigniter/app/Controllers/Univ/Master.php#L28)

**Masalah:**

```php
public function simpanFakultas() {
    $this->fakultasModel->insert([
        'id'            => strtoupper($this->request->getPost('id')),
        'nama_fakultas' => $this->request->getPost('nama_fakultas')
    ]);
    // Tidak ada validasi!
}
```

**Solusi:** Tambahkan validation

```php
public function simpanFakultas() {
    if (!$this->validate([
        'id' => 'required|alpha_dash|is_unique[mFakultas.id]',
        'nama_fakultas' => 'required|min_length[3]|max_length[100]'
    ])) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->fakultasModel->insert([
        'id'            => strtoupper($this->request->getPost('id')),
        'nama_fakultas' => $this->request->getPost('nama_fakultas')
    ]);
    return redirect()->back()->with('success', 'Fakultas baru berhasil ditambahkan!');
}
```

### Issue 3.3: Magic Number pada Dashboard

**File:** [Dashboard.php](src/codeigniter/app/Controllers/Dashboard.php#L18)

**Masalah:**

```php
switch ($roleId) {
    case 1: // ADMIN
    case 2: // FAKULTAS
    case 3: // PRODI
    case 4: // UNIT / LEMBAGA
    case 5: // UNIVERSITAS
}
```

**Solusi:** Gunakan Enum/Constant

```php
// app/Constants/RoleConstants.php
namespace App\Constants;

class RoleConstants {
    public const ADMIN = 1;
    public const FAKULTAS = 2;
    public const PRODI = 3;
    public const UNIT = 4;
    public const UNIVERSITAS = 5;

    public const VIEWS = [
        self::ADMIN       => 'admin/dashboard_view',
        self::FAKULTAS    => 'fakultas/dashboard_view',
        self::PRODI       => 'prodi/dashboard_view',
        self::UNIT        => 'unit/dashboard_view',
        self::UNIVERSITAS => 'univ/dashboard_view',
    ];

    public const SESSION_FIELDS = [
        self::ADMIN       => null,
        self::FAKULTAS    => 'fk_fakultas',
        self::PRODI       => 'fk_prodi',
        self::UNIT        => 'fk_unit',
        self::UNIVERSITAS => null,
    ];
}

// Di Dashboard.php:
use App\Constants\RoleConstants;

public function index() {
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

    $roleId = session()->get('fk_roles');
    $view = RoleConstants::VIEWS[$roleId] ?? 'dashboard/dashboard_view';
    $unitField = RoleConstants::SESSION_FIELDS[$roleId];

    $data = [
        'title'    => 'Dashboard',
        'username' => session()->get('username'),
        'roleId'   => $roleId
    ];

    if ($unitField) {
        $data['unitCode'] = session()->get($unitField);
    }

    return view($view, $data);
}
```

### Issue 3.4: Missing Type Hints

**Files:** Semua Controllers dan Models
**Masalah:**

```php
public function save() {  // Tidak ada return type
    // ...
}

public function index() {  // Tidak ada return type
    // ...
}
```

**Solusi:** Tambahkan type hints

```php
public function save(): ResponseInterface {
    // ...
}

public function index(): string {
    // ...
}
```

---

## 4. 📊 SUMMARY & PRIORITAS IMPLEMENTASI

### PRIORITAS 1 (SECURITY) - Lakukan SEGERA:

- [ ] Ganti password plain text dengan password_verify()
- [ ] Tambahkan CSRF token di semua form
- [ ] Implementasi validation di login (Auth.php)
- [ ] Implementasi rate limiting login

### PRIORITAS 2 (CODE QUALITY) - Lakukan Minggu Depan:

- [ ] Buat Validation classes terpisah
- [ ] Buat Base CRUD Controller
- [ ] Standardisasi error handling
- [ ] Implementasi RoleConstants

### PRIORITAS 3 (NICE TO HAVE) - Jika Ada Waktu:

- [ ] Tambahkan type hints ke semua method
- [ ] Implementasi logging system
- [ ] Buat API Helper utilities
- [ ] Optimization database query (eager loading)

---

## 5. 🛡️ SECURITY CHECKLIST

- [ ] Password menggunakan hash (password_hash/password_verify)
- [ ] CSRF token di semua form
- [ ] Input validation di semua endpoint
- [ ] Output escaping di views
- [ ] Rate limiting pada login
- [ ] Error handling tidak expose sensitive info
- [ ] SQL Injection protection (gunakan parameter binding)
- [ ] XSS protection (output encoding)
- [ ] HTTPS enforcement
- [ ] Session security settings
