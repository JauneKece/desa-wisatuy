# IMPLEMENTASI UI/UX ROLE-BASED - PANDUAN LENGKAP

**Tanggal:** 5 April 2026  
**Status:** ✅ Implementasi Selesai

---

## 📋 RINGKASAN IMPLEMENTASI

Telah dilakukan implementasi komprehensif untuk UI/UX role-based sistem DESMOK agar setiap user dapat bekerja sesuai dengan tugas dan tanggung jawab mereka.

### ✅ Deliverables

| Komponen | File | Status | Notes |
|----------|------|--------|-------|
| **UserRole Enum** | `app/Enums/UserRole.php` | ✅ DONE | Single source of truth untuk role values |
| **Route Middleware Fix** | `routes/web.php` | ✅ DONE | Update semua `check.role` ke role baru |
| **Controller Fix** | `app/Http/Controllers/HomeController.php` | ✅ DONE | Dashboard routing & role checks |
| **User Model Helpers** | `app/Models/User.php` | ✅ DONE | Role checking methods |
| **Authorization Policies** | `app/Policies/PaymentPolicy.php`, `app/Policies/ReservasiPolicy.php` | ✅ DONE | Fine-grained authorization |
| **Service Provider Policies** | `app/Providers/AppServiceProvider.php` | ✅ DONE | Register policies |
| **Navbar Role Badge** | `resources/views/layouts/navbar.blade.php` | ✅ DONE | Visual role indicator |

---

## 🔧 IMPLEMENTASI DETAIL

### 1. UserRole Enum (`app/Enums/UserRole.php`)

**Tujuan:** Centralized location untuk semua role-related constants, labels, icons

**Fitur:**
- ✅ Role values: ADMIN, OWNER, BENDAHARA, PELANGGAN
- ✅ Display labels dengan bahasa Indonesia
- ✅ Role icons (emoji)
- ✅ Role descriptions
- ✅ Helper methods untuk checking permissions

**Penggunaan:**
```php
use App\Enums\UserRole;

// Get label
$label = UserRole::getLabel('owner');  // "Pemilik/Manager"

// Get icon
$icon = UserRole::getIcon('bendahara');  // "💰"

// Check permissions
$canManage = UserRole::canManageResources('owner');  // true
$canPayments = UserRole::canManagePayments('bendahara');  // true
```

---

### 2. Routes Middleware Update (`routes/web.php`)

**Masalah yang diperbaiki:**
- ❌ Masih gunakan role lama: `admin,manager,staff,customer`
- ✅ Update ke role baru: `admin,owner,bendahara,pelanggan`

**Routes yang diperbaiki:**

```php
// BEFORE:
Route::middleware('check.role:customer,admin,manager')->group(...)
Route::middleware('check.role:admin,manager')->group(...)
Route::middleware('check.role:admin,manager,staff')->group(...)

// AFTER:
Route::middleware('check.role:pelanggan,admin,owner')->group(...)
Route::middleware('check.role:admin,owner')->group(...)
Route::middleware('check.role:admin,owner,bendahara')->group(...)
```

**Routes yang diupdate:**
1. Reservasi edit/delete: `check.role:pelanggan,admin,owner`
2. Resource CRUD (Objek, Paket, Penginapan): `check.role:admin,owner`
3. Berita CRUD: `check.role:admin,owner,bendahara`
4. Payment Management: `check.role:admin,owner,bendahara` ✅ **BENDAHARA KINI BISA AKSES**

---

### 3. HomeController Update

**Role routing:**
```php
$user->role === 'pelanggan'  // customer
$user->role === 'admin'      // admin
$user->role === 'owner'      // manager → owner
$user->role === 'bendahara'  // staff → bendahara
```

**User counts untuk Admin Dashboard:**
```php
$totalCustomers = User::where('role', 'pelanggan')->count();
$totalStaff = User::where('role', 'bendahara')->count();
$totalManagers = User::where('role', 'owner')->count();
```

---

### 4. User Model Helper Methods

**Tambahan methods di `app/Models/User.php`:**

```php
// Attributes (accessible via $user->attribute)
$user->role_label    // "Admin", "Pemilik/Manager", dll
$user->role_icon     // "👨‍💼", "🏢", "💰", "👤"

// Methods
$user->isAdmin()              // Check if admin
$user->isOwner()              // Check if owner
$user->isBendahara()          // Check if bendahara
$user->isPelanggan()          // Check if pelanggan
$user->isStaff()              // Check if staff (admin/owner/bendahara)
$user->canManageResources()   // Can CRUD Objek/Paket/Penginapan
$user->canManagePayments()    // Can verify pembayaran
$user->canCreateBerita()      // Can create berita
```

**Penggunaan di Controller/View:**
```blade
@if (auth()->user()->canCreateBerita())
    <!-- Show create berita button -->
@endif

@if (auth()->user()->canManagePayments())
    <!-- Show payment verification link -->
@endif
```

---

### 5. Authorization Policies

**PaymentPolicy (`app/Policies/PaymentPolicy.php`):**
- `viewProof()` - Siapa boleh lihat payment proof
  - Admin/Owner/Bendahara: semua
  - Pelanggan: hanya milik sendiri
- `verify()` - Siapa boleh approve pembayaran
  - Admin/Owner/Bendahara: yes
- `reject()` - Siapa boleh tolak pembayaran
  - Admin/Owner/Bendahara: yes

**ReservasiPolicy (`app/Policies/ReservasiPolicy.php`):**
- `view()` - Siapa boleh lihat
  - Admin/Owner: semua
  - Pelanggan: hanya milik sendiri
- `update()` - Siapa boleh edit
  - Admin/Owner: semua
  - Pelanggan: milik sendiri
- `delete()` - Siapa boleh hapus
  - Admin/Owner: semua
  - Pelanggan: milik sendiri

**Penggunaan (di Controller):**
```php
// Check before action
Gate::authorize('verify', $payment);  // throws 403 jika tidak boleh

// Or in Views
@can('verify', $payment)
    <form method="post" action="{{ route('admin.payments.verify', $payment) }}">
        ...
    </form>
@endcan
```

---

### 6. Navbar Role Badge

**Lokasi:** `resources/views/layouts/navbar.blade.php` (setelah Dashboard link)

**Display:**
- ✅ Role icon + label di navbar
- ✅ Hidden label pada mobile (hanya icon pada `d-none d-lg-inline`)
- ✅ Styled dengan warna coklat DESMOK theme
- ✅ Inline dengan nav items

**Contoh Tampilan:**
```
📍 Objek | 📦 Paket | 🏨 Penginapan | 📰 Berita | 🗳️ Reservasi | 📊 Dashboard | [💰 Bendahara] | [👤 User]
```

---

## 🎯 AKSES KONTROL PER ROLE (SETELAH IMPLEMENTASI)

### ADMIN 👨‍💼
```
Routes Protected:
✅ /admin/payments                (check.role:admin,owner,bendahara)
✅ /objek-wisata/* CRUD          (check.role:admin,owner)
✅ /paket-wisata/* CRUD          (check.role:admin,owner)
✅ /penginapan/* CRUD            (check.role:admin,owner)
✅ /berita/* CRUD                (check.role:admin,owner,bendahara)
✅ /reservasi/*/edit             (check.role:pelanggan,admin,owner)

Helper Methods:
✅ auth()->user()->isAdmin()
✅ auth()->user()->canManageResources()
✅ auth()->user()->canManagePayments()
✅ auth()->user()->canCreateBerita()
```

### OWNER 🏢
```
Routes Protected:
✅ /admin/payments                (check.role:admin,owner,bendahara)
✅ /objek-wisata/* CRUD          (check.role:admin,owner)
✅ /paket-wisata/* CRUD          (check.role:admin,owner)
✅ /penginapan/* CRUD            (check.role:admin,owner)
✅ /berita/* CRUD                (check.role:admin,owner,bendahara)
✅ /reservasi/*/edit             (check.role:pelanggan,admin,owner)

Helper Methods:
✅ auth()->user()->isOwner()
✅ auth()->user()->canManageResources()
✅ auth()->user()->canManagePayments()
✅ auth()->user()->canCreateBerita()
```

### BENDAHARA 💰
```
Routes Protected:
✅ /admin/payments                (check.role:admin,owner,bendahara) ← **FIXED!**
✅ /berita/* CRUD                (check.role:admin,owner,bendahara) ← **FIXED!**
❌ /objek-wisata/* CRUD          (check.role:admin,owner)
❌ /paket-wisata/* CRUD          (check.role:admin,owner)
❌ /penginapan/* CRUD            (check.role:admin,owner)

Helper Methods:
✅ auth()->user()->isBendahara()
✅ auth()->user()->canManagePayments()
✅ auth()->user()->canCreateBerita()
❌ auth()->user()->canManageResources()
```

### PELANGGAN 👤
```
Routes Protected:
✅ /reservasi                     (public untuk auth)
✅ /reservasi/create              (public untuk auth)
✅ /reservasi/*/edit              (check.role:pelanggan,admin,owner) - milik sendiri
✅ /payments/manual               (public untuk auth)
❌ /admin/payments                (check.role:admin,owner,bendahara)
❌ /berita/create                 (check.role:admin,owner,bendahara)
❌ /objek-wisata/* CRUD          (check.role:admin,owner)

Helper Methods:
✅ auth()->user()->isPelanggan()
❌ auth()->user()->canManageResources()
❌ auth()->user()->canManagePayments()
❌ auth()->user()->canCreateBerita()
```

---

## 📊 TESTING CHECKLIST

### Admin User (admin@desmok.com)
- [ ] Login
- [ ] Lihat dashboard admin dengan stats lengkap
- [ ] Lihat role badge "👨‍💼 Admin" di navbar
- [ ] Akses `/admin/payments` - verify pembayaran
- [ ] Create/Edit/Delete Objek Wisata
- [ ] Create/Edit/Delete Paket Wisata
- [ ] Create/Edit/Delete Penginapan
- [ ] Create/Edit/Delete Berita
- [ ] View semua Reservasi

### Owner User (manager@desmok.com → diupdate ke owner)
- [ ] Login
- [ ] Lihat dashboard owner dengan stats operasional
- [ ] Lihat role badge "🏢 Pemilik/Manager" di navbar
- [ ] Akses `/admin/payments` - verify pembayaran
- [ ] Create/Edit/Delete Paket Wisata
- [ ] Create/Edit/Delete Penginapan
- [ ] Create/Edit/Delete Berita
- [ ] Edit/Delete Reservasi

### Bendahara User (staff@desmok.com → diupdate ke bendahara)
- [ ] Login
- [ ] Lihat dashboard bendahara dengan stats keuangan
- [ ] Lihat role badge "💰 Bendahara" di navbar
- [ ] **Akses `/admin/payments` - verify pembayaran ✅ SEKARANG BISA**
- [ ] Create/Edit/Delete Berita
- [ ] **TIDAK BISA** akses Create Objek/Paket/Penginapan
- [ ] Dashboard hanya menampilkan Berita dan Payment stats

### Pelanggan User (customer@desmok.com → diupdate ke pelanggan)
- [ ] Login
- [ ] Lihat dashboard pelanggan dengan reservasi personal
- [ ] Lihat role badge "👤 Pelanggan" di navbar
- [ ] Browse Objek/Paket/Penginapan (read-only)
- [ ] Create Reservasi
- [ ] Edit own Reservasi (status pending)
- [ ] Upload payment proof
- [ ] View own Reservasi & Payments
- [ ] **TIDAK BISA** Create Objek/Paket/Penginapan
- [ ] **TIDAK BISA** Create/Edit/Delete Berita
- [ ] **TIDAK BISA** Verify Pembayaran

---

## 🚀 FITUR LANJUTAN (Optional Improvements)

### 1. Role-Based Sidebar Menu
```blade
<!-- resources/views/components/sidebar.blade.php -->
@if (auth()->user()->canManageResources())
    <!-- Management Menu -->
    - Objek Wisata
    - Paket Wisata
    - Penginapan
@endif

@if (auth()->user()->canManagePayments())
    <!-- Finance Menu -->
    - Verifikasi Pembayaran
    - Laporan Keuangan
@endif

@if (auth()->user()->canCreateBerita())
    <!-- Content Menu -->
    - Kelola Berita
@endif
```

### 2. Dashboard Customization per Role
Setiap role memiliki dashboard yang menampilkan widget relevan:
- Admin: Users, Revenue, All Stats
- Owner: Operasional, Reservasi, Resources
- Bendahara: Finance, Payments, Revenue
- Pelanggan: Personal Reservasi, Spending

### 3. Action Buttons yang Role-Aware
```blade
<!-- Only show buttons user is allowed to use -->
@can('update', $reservasi)
    <a href="{{ route('reservasi.edit', $reservasi) }}" class="btn btn-primary">Edit</a>
@endcan

@can('verify', $payment)
    <button class="btn btn-success">Approve Payment</button>
@endcan
```

### 4. Permission Indicator Badges
```blade
<!-- Show user apa saja yang bisa mereka akses -->
<div class="permissions-indicator">
    @if ($user->canManageResources())
        <span class="badge">Manage Resources</span>
    @endif
    @if ($user->canManagePayments())
        <span class="badge">Manage Payments</span>
    @endif
</div>
```

---

## 📝 CATATAN PENTING

### Database Migration Status
Telah dilakukan:
- ✅ Database migration April 5, 2026
- ✅ Role values updated: manager→owner, staff→bendahara, customer→pelanggan
- ✅ Seeding data dengan role values baru

### Files Modified ✅
1. `routes/web.php` - Middleware updates
2. `app/Http/Controllers/HomeController.php` - Role routing
3. `app/Models/User.php` - Helper methods
4. `app/Providers/AppServiceProvider.php` - Policy registration
5. `resources/views/layouts/navbar.blade.php` - Role badge

### Files Created ✅
1. `app/Enums/UserRole.php` - Role constants
2. `app/Policies/PaymentPolicy.php` - Payment authorization
3. `app/Policies/ReservasiPolicy.php` - Reservasi authorization

---

## 🔄 NEXT STEPS

### Phase 1: Testing & Validation (24 jam)
- [ ] Manual testing semua role dengan test accounts
- [ ] Verify middleware protection efektif
- [ ] Check payment verification untuk bendahara
- [ ] Verify navbar badge visible di semua pages
- [ ] Test policy restrictions

### Phase 2: Optional UI Enhancements (1-2 kali)
- [ ] Create sidebar menu component
- [ ] Add permission indicator badges
- [ ] Implement role-based widget dashboards
- [ ] Add action button authorization

### Phase 3: Documentation & FYI
- [ ] Staff training tentang role-based system
- [ ] Update API documentation jika ada API endpoints
- [ ] Create user manual per role

---

**Implementasi UI/UX Role-Based: ✅ COMPLETE**

Setiap user sekarang dapat bekerja sesuai dengan role dan tanggung jawab mereka!

---

**Diupdate oleh:** GitHub Copilot  
**Tanggal:** 5 April 2026  
**Status:** Ready for Testing
