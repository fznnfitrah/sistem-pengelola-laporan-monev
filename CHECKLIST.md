# ✅ MASTER CHECKLIST - CODE OPTIMIZATION

## 📋 FILE ALLOCATION

### Documentation Files (Di Project Root)

- [x] **START_HERE.md** - Ringkasan keseluruhan
- [x] **INDEX.md** - Master navigation
- [x] **QUICK_START.md** - 5-minute overview
- [x] **SUMMARY.md** - Executive summary
- [x] **ANALYSIS_RESULTS.md** - Full analysis report
- [x] **OPTIMIZATION_REPORT.md** - Technical details
- [x] **IMPLEMENTATION_GUIDE.md** - Step-by-step guide
- [x] **RECOMMENDED_STRUCTURE.md** - Architecture guide
- [x] **THIS FILE** - Master checklist

### Template Files

**Lokasi: `app/Controllers/CrudController.php`** (BUAT BARU)

```
✅ CrudController.php
   - 100+ lines of reusable CRUD code
   - Eliminates boilerplate
   - Standardized error handling
```

**Lokasi: `app/Constants/RoleConstants.php`** (BUAT BARU)

```
✅ RoleConstants.php
   - Role ID constants (ADMIN, FAKULTAS, PRODI, UNIT, UNIVERSITAS)
   - View mapping
   - Unit code field mapping
   - Role names
```

**Lokasi: `app/Validation/RoleValidation.php`** (BUAT BARU)

```
✅ RoleValidation.php
   - Centralized validation rules for Role
   - createRules() untuk save
   - updateRules($id) untuk update
```

**Lokasi: `app/Validation/UserValidation.php`** (BUAT BARU)

```
✅ UserValidation.php
   - Centralized validation rules for User
   - createRules() untuk save
   - updateRules($id) untuk update
```

**Lokasi: `app/Filters/SecurityFilter.php`** (BUAT BARU)

```
✅ SecurityFilter.php
   - CSRF token validation
   - Rate limiting (5 attempts / 15 mins)
   - Security headers
   - Login protection
```

**Reference Files (Di Root - untuk referensi)**

```
✅ AuthRefactored.php - Example secure implementation
✅ DashboardRefactored.php - Example using RoleConstants
✅ RolesRefactored.php - Example using CrudController
```

---

## 🔴 SECURITY FIXES - PRIORITY 1 (URGENT!)

### Task 1.1: Fix Password Verification

**File:** `app/Controllers/Auth.php`
**Line:** 42
**Status:** ⭕ TODO

```
❌ BEFORE:
if ($user && $password == $user['password']) {

✅ AFTER:
if ($user && password_verify($password, $user['password'])) {
```

**Checklist:**

- [ ] Open Auth.php
- [ ] Locate line 42
- [ ] Replace == with password_verify()
- [ ] Save file
- [ ] Test login with correct password
- [ ] Test login with wrong password
- [ ] ✅ DONE

---

### Task 1.2: Add Input Validation to Login

**File:** `app/Controllers/Auth.php`
**Method:** `login()`
**Status:** ⭕ TODO

Add at the beginning of login method:

```php
if (!$this->validate([
    'email' => 'permit_empty|valid_email',
    'username' => 'permit_empty|required_without[email]',
    'password' => 'required|min_length[6]'
])) {
    return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
}
```

**Checklist:**

- [ ] Open Auth.php
- [ ] Find login() method
- [ ] Add validation at the top
- [ ] Save file
- [ ] Test with empty password
- [ ] Test with short password
- [ ] Test with empty email & username
- [ ] ✅ DONE

---

### Task 1.3: Add CSRF Tokens to All Forms

**Files:** All view files with form
**Pattern:** `<form ... >`
**Status:** ⭕ TODO

Add after opening form tag:

```html
<form action="..." method="post">
  <?= csrf_field() ?>
  <!-- form fields -->
</form>
```

**Checklist:**

- [ ] Find all <form> tags in Views
- [ ] Add <?= csrf_field() ?> inside each
- [ ] Check: admin/roles/add_roles_view
- [ ] Check: admin/roles/edit_roles_view
- [ ] Check: admin/users/add_users_view
- [ ] Check: admin/users/edit_users_view
- [ ] Check: univ/master views
- [ ] Check: prodi views
- [ ] Check: login form
- [ ] ✅ DONE

---

### Task 1.4: Add Validation to Master.php

**File:** `app/Controllers/Univ/Master.php`
**Methods:** simpanFakultas(), simpanProdi(), simpanUnit()
**Status:** ⭕ TODO

Add validation for each save method (example for Fakultas):

```php
public function simpanFakultas() {
    if (!$this->validate([
        'id' => 'required|alpha_dash|is_unique[mFakultas.id]|min_length[3]',
        'nama_fakultas' => 'required|min_length[3]|max_length[100]'
    ])) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }
    // ... rest of code
}
```

**Checklist:**

- [ ] Add validation to simpanFakultas()
- [ ] Add validation to editFakultas()
- [ ] Add validation to simpanProdi()
- [ ] Add validation to editProdi()
- [ ] Add validation to simpan() for Unit
- [ ] Add validation to edit() for Unit
- [ ] Test each method
- [ ] ✅ DONE

---

### Task 1.5: Register & Implement SecurityFilter

**File:** `app/Config/Filters.php`
**Status:** ⭕ TODO

**Checklist:**

- [ ] Create SecurityFilter.php (already provided)
- [ ] Copy to app/Filters/
- [ ] Open app/Config/Filters.php
- [ ] Add SecurityFilter to $filters array
- [ ] Test rate limiting (try 6 login attempts)
- [ ] Test CSRF protection (remove CSRF token from form)
- [ ] ✅ DONE

---

## 🟠 CODE QUALITY FIXES - PRIORITY 2 (IMPORTANT)

### Task 2.1: Create Required Folders

**Status:** ⭕ TODO

```bash
mkdir -p app/Constants
mkdir -p app/Validation
```

**Checklist:**

- [ ] Create app/Constants/ folder
- [ ] Create app/Validation/ folder
- [ ] ✅ DONE

---

### Task 2.2: Copy Template Files

**Status:** ⭕ TODO

Copy these files to your project:

1. CrudController.php → app/Controllers/
2. RoleConstants.php → app/Constants/
3. RoleValidation.php → app/Validation/
4. UserValidation.php → app/Validation/
5. SecurityFilter.php → app/Filters/

**Checklist:**

- [ ] Copy CrudController.php
- [ ] Copy RoleConstants.php
- [ ] Copy RoleValidation.php
- [ ] Copy UserValidation.php
- [ ] Copy SecurityFilter.php
- [ ] Verify all files are in correct locations
- [ ] ✅ DONE

---

### Task 2.3: Refactor Roles.php

**File:** `app/Controllers/Admin/Roles.php`
**Reference:** `RolesRefactored.php`
**Status:** ⭕ TODO

Replace entire file with:

```php
<?php

namespace App\Controllers\Admin;

use App\Controllers\CrudController;
use App\Models\RoleModel;
use App\Validation\RoleValidation;

class Roles extends CrudController
{
    protected $model;
    protected $routePath = '/admin/roles';
    protected $listViewPath = 'admin/roles/index_roles_view';
    protected $addViewPath = 'admin/roles/add_roles_view';
    protected $editViewPath = 'admin/roles/edit_roles_view';
    protected $entityName = 'Role';

    public function __construct()
    {
        $this->model = new RoleModel();
    }

    protected function getCreateValidationRules(): array
    {
        return RoleValidation::createRules();
    }

    protected function getUpdateValidationRules($id): array
    {
        return RoleValidation::updateRules($id);
    }

    protected function getDataFromRequest(): array
    {
        return [
            'nama_roles' => $this->request->getPost('nama_roles'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ];
    }

    public function delete($id = null)
    {
        if ($id == 1) {
            return redirect()->back()
                ->with('error', 'Role Admin Utama tidak boleh dihapus!');
        }
        return parent::delete($id);
    }
}
```

**Checklist:**

- [ ] Backup original Roles.php
- [ ] Replace with refactored version
- [ ] Save file
- [ ] Test index page (should show all roles)
- [ ] Test add role
- [ ] Test edit role
- [ ] Test delete role
- [ ] Test delete protection on role ID 1
- [ ] ✅ DONE

---

### Task 2.4: Update Dashboard.php

**File:** `app/Controllers/Dashboard.php`
**Reference:** `DashboardRefactored.php`
**Status:** ⭕ TODO

Replace entire file with refactored version using RoleConstants.

**Checklist:**

- [ ] Backup original Dashboard.php
- [ ] Replace with refactored version
- [ ] Save file
- [ ] Test dashboard loads correctly
- [ ] Test for each role (1, 2, 3, 4, 5)
- [ ] Verify correct view is loaded
- [ ] Verify unit code is set correctly
- [ ] ✅ DONE

---

### Task 2.5: Refactor Users.php (Optional)

**File:** `app/Controllers/Admin/Users.php`
**Status:** ⭕ TODO (Optional - Time permitting)

Refactor to use CrudController:

- Extend CrudController
- Use UserValidation class
- Use getNullSafeValue() helper

**Checklist:**

- [ ] Backup original Users.php
- [ ] Extend CrudController
- [ ] Use UserValidation
- [ ] Use getNullSafeValue() helper
- [ ] Test all CRUD operations
- [ ] Verify validation works
- [ ] ✅ DONE

---

### Task 2.6: Update Master.php

**File:** `app/Controllers/Univ/Master.php`
**Status:** ⭕ TODO

Make all CRUD methods private except index, add proper error handling.

**Checklist:**

- [ ] Make simpanFakultas() private
- [ ] Make simpanProdi() private
- [ ] Make editFakultas() private
- [ ] Make editProdi() private
- [ ] Add existence checks before delete
- [ ] Test all operations still work
- [ ] ✅ DONE

---

## 🧪 TESTING - PRIORITY 3

### Task 3.1: Test Security Fixes

**Status:** ⭕ TODO

**Checklist:**

- [ ] Test password_verify() works
  - [ ] Correct password should login
  - [ ] Wrong password should reject
- [ ] Test input validation
  - [ ] Empty password should error
  - [ ] Short password should error
  - [ ] Invalid email should error
- [ ] Test CSRF protection
  - [ ] Valid CSRF token should work
  - [ ] Invalid/missing CSRF token should reject
- [ ] Test rate limiting
  - [ ] 5 login attempts should work
  - [ ] 6th attempt should be blocked
- [ ] ✅ DONE

---

### Task 3.2: Test Code Quality Improvements

**Status:** ⭕ TODO

**Checklist:**

- [ ] Roles CRUD works (create, read, update, delete)
- [ ] Users CRUD works
- [ ] Dashboard renders correct view per role
- [ ] No magic numbers visible in code
- [ ] No duplicate validation rules
- [ ] Error messages are consistent
- [ ] ✅ DONE

---

### Task 3.3: Full Integration Test

**Status:** ⭕ TODO

```bash
php spark serve
```

**Checklist:**

- [ ] Login page loads
- [ ] Login with credentials works
- [ ] Login with wrong password fails
- [ ] Dashboard shows correct content
- [ ] Admin can create Role
- [ ] Admin can edit Role
- [ ] Admin can delete Role
- [ ] Admin can create User
- [ ] Admin can edit User
- [ ] Admin can delete User
- [ ] Univ can add Fakultas
- [ ] Univ can edit Fakultas
- [ ] Univ can delete Fakultas
- [ ] All validation errors show correctly
- [ ] ✅ DONE

---

## 📝 DOCUMENTATION - PRIORITY 4

### Task 4.1: Update README.md

**Status:** ⭕ TODO

Add section about security & code structure improvements.

**Checklist:**

- [ ] Document password requirements
- [ ] Document CSRF token requirement
- [ ] Document rate limiting behavior
- [ ] Document new architecture
- [ ] ✅ DONE

---

### Task 4.2: Update Code Comments

**Status:** ⭕ TODO

Add comments to explain:

- CrudController usage
- RoleConstants usage
- SecurityFilter behavior

**Checklist:**

- [ ] Add comments to CrudController
- [ ] Add comments to RoleConstants
- [ ] Add comments to SecurityFilter
- [ ] ✅ DONE

---

## 🎯 OVERALL PROGRESS

### Phase 1: Security (Estimated 2-3 hours)

- [ ] Task 1.1: Fix password verification
- [ ] Task 1.2: Add login validation
- [ ] Task 1.3: Add CSRF tokens
- [ ] Task 1.4: Add Master validation
- [ ] Task 1.5: Register SecurityFilter
- [ ] **SUBTOTAL PHASE 1:** ⭕ NOT STARTED

### Phase 2: Code Refactoring (Estimated 1-2 days)

- [ ] Task 2.1: Create folders
- [ ] Task 2.2: Copy template files
- [ ] Task 2.3: Refactor Roles.php
- [ ] Task 2.4: Update Dashboard.php
- [ ] Task 2.5: Refactor Users.php
- [ ] Task 2.6: Update Master.php
- [ ] **SUBTOTAL PHASE 2:** ⭕ NOT STARTED

### Phase 3: Testing (Estimated 1-2 hours)

- [ ] Task 3.1: Test security fixes
- [ ] Task 3.2: Test code quality improvements
- [ ] Task 3.3: Full integration test
- [ ] **SUBTOTAL PHASE 3:** ⭕ NOT STARTED

### Phase 4: Documentation (Estimated 1 hour)

- [ ] Task 4.1: Update README.md
- [ ] Task 4.2: Update code comments
- [ ] **SUBTOTAL PHASE 4:** ⭕ NOT STARTED

---

## 📊 SUMMARY

```
Total Tasks:        26
Completed:          0
In Progress:        0
Not Started:        26

Phase 1 Progress:   0% (0/5)
Phase 2 Progress:   0% (0/6)
Phase 3 Progress:   0% (0/3)
Phase 4 Progress:   0% (0/2)

Overall Progress:   0% (0/26)

Estimated Time:     3-4 days
Priority:           URGENT (Security fixes first!)
Status:             ⭕ READY TO START
```

---

## 🚀 NEXT STEPS

1. **Read START_HERE.md** - Get overview (5 mins)
2. **Read QUICK_START.md** - Understand priorities (5 mins)
3. **Read IMPLEMENTATION_GUIDE.md** - Learn how to fix (30 mins)
4. **Start Task 1.1** - Fix password verification (10 mins)
5. **Continue with Phase 1** - Complete security fixes (2-3 hours)
6. **Move to Phase 2** - Code refactoring (1-2 days)
7. **Do Phase 3** - Testing (1-2 hours)
8. **Finish with Phase 4** - Documentation (1 hour)

---

**Analysis Status:** ✅ COMPLETE
**Deliverables Status:** ✅ READY
**Implementation Status:** ⭕ READY TO START
**Your Turn:** 👉 START_HERE.md or QUICK_START.md

**Good luck! 💪**

---

_Created: January 21, 2026_
_Type: Master Implementation Checklist_
_Scope: Full code optimization project_
_Estimated Duration: 3-4 days_
