# ANALISA KOMPREHENSIF SISTEM ROLE & DATABASE - DESMOK

**Tanggal Analisis:** 5 April 2026  
**Status:** Analisis Mendalam - UI/UX & Fungsionalitas Role-Based

---

## 1. OVERVIEW SISTEM ROLE

### 1.1 Struktur Role Hierarchy

DESMOK menggunakan 4 peran (roles) utama, masing-masing dengan tanggung jawab dan akses yang berbeda:

```
┌─────────────────────────────────────────────────────────────┐
│                    SISTEM ROLE DESMOK                       │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌─────────────────┬─────────────────┬─────────────────┐  │
│  │     ADMIN       │      OWNER      │   BENDAHARA     │  │
│  │  Administrator  │  Pemilik/Manager│  Staff Keuangan │  │
│  │   Sistem        │  Operasional    │                 │  │
│  └─────────────────┴─────────────────┴─────────────────┘  │
│           ↓              ↓                 ↓                 │
│    [STAFF ROLES - Internal Users]                           │
│                                                             │
│  ┌────────────────────────────────────────────────────┐   │
│  │            PELANGGAN (Customer)                     │   │
│  │         Pengguna Akhir / Tourist / Guest           │   │
│  └────────────────────────────────────────────────────┘   │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### 1.2 Mapping Role - Database Values

| Database Value | Role Name | Deskripsi | Status |
|---|---|---|---|
| `admin` | Admin | Administrator Sistem | ✅ Aktif |
| `owner` | Pemilik | Pengelola Bisnis (formerly: manager) | ✅ Aktif |
| `bendahara` | Bendahara | Staff Keuangan (formerly: staff) | ✅ Aktif |
| `pelanggan` | Pelanggan | Customer/Wisatawan (formerly: customer) | ✅ Aktif |

**Migrasi DB (April 5, 2026):**
- `manager` → `owner`
- `staff` → `bendahara`
- `customer` → `pelanggan`

---

## 2. ANALISA STRUKTUR DATABASE & RELATIONSHIPS

### 2.1 Users Table Structure

```sql
users
├── id (PK)
├── name (VARCHAR)
├── email (UNIQUE)
├── password (HASHED)
├── role (ENUM: admin, owner, bendahara, pelanggan)
├── is_active (BOOLEAN) - untuk soft-delete atau aktif/non-aktif
├── akitf (BOOLEAN) - DB2 compatibility field
└── Timestamps (created_at, updated_at)
```

### 2.2 Model Relationships

```php
User (Primary Table)
├── hasOne(Pelanggan)           // untuk role = 'pelanggan'
├── hasOne(Karyawan)            // untuk role = 'admin', 'owner', 'bendahara'
└── hasMany(Berita)             // dapat membuat berita
```

**Detail Relationships:**

```
User (id: 1, role: 'admin')
  └─→ Karyawan (user_id: 1)
      ├── nomor_identitas: "1234567890123456"
      ├── departemen: "IT & Sistem"
      ├── posisi: "Administrator Sistem"
      ├── gaji: 7500000
      └── foto: null

User (id: 4, role: 'pelanggan')
  └─→ Pelanggan (user_id: 4)
      ├── nomor_identitas: "xxx"
      ├── jenis_identitas: "KTP"
      ├── alamat: "..."
      └── telepon: "..."
```

### 2.3 Associated Models untuk Setiap Role

#### Admin/Owner/Bendahara
```
User → Karyawan
     → Berita (jika membuat)
     → Reservasi (admin/owner dapat manage semua; bendahara view payments)
     → Payment (untuk verifikasi pembayaran)
```

#### Pelanggan
```
User → Pelanggan
     → Reservasi (hanya milik sendiri)
     → Payment (hanya milik sendiri)
```

---

## 3. AUDIT FITUR & AKSES PER ROLE

### 3.1 ADMIN - Administrator Sistem

**Database Role Value:** `admin`

**Tanggung Jawab Utama:**
- Kelola semua aspek sistem (Users, Content, Analytics)
- Verifikasi pembayaran reservasi
- Kelola HR (Karyawan data)
- Audit & morin sistem keseluruhan

#### Akses Fitur (READ)
| Fitur | Akses | URL Routes | Notes |
|-------|--------|-----------|-------|
| Dashboard Admin | ✅ | `/dashboard` | Stats lengkap: users, reservasi, revenue |
| Objek Wisata (View) | ✅ | `/objek-wisata` | Lihat semua + CRUD |
| Paket Wisata (View) | ✅ | `/paket-wisata` | Lihat semua + CRUD |
| Penginapan (View) | ✅ | `/penginapan` | Lihat semua + CRUD |
| Berita (View) | ✅ | `/berita` | Lihat semua + CRUD milik sendiri |
| Reservasi (View) | ✅ | `/admin/reservasi` | Lihat ALL + Admin detail view |
| Payment Verification | ✅ | `/admin/payments` | Buktikan/reject pembayaran |
| Profil | ✅ | `/profile` | Edit profil sendiri |

#### Akses Fitur (WRITE/CREATE)
| Fitur | Akses | Middleware | Batasan |
|-------|--------|-----------|---------|
| Create Objek Wisata | ✅ | `check.role:admin,manager` | Tidak ada |
| Edit Objek Wisata | ✅ | `check.role:admin,manager` | Tidak ada |
| Delete Objek Wisata | ✅ | `check.role:admin,manager` | Tidak ada |
| Create Paket Wisata | ✅ | `check.role:admin,manager` | Tidak ada |
| Edit Paket Wisata | ✅ | `check.role:admin,manager` | Tidak ada |
| Delete Paket Wisata | ✅ | `check.role:admin,manager` | Tidak ada |
| Create Penginapan | ✅ | `check.role:admin,manager` | Tidak ada |
| Edit Penginapan | ✅ | `check.role:admin,manager` | Tidak ada |
| Delete Penginapan | ✅ | `check.role:admin,manager` | Tidak ada |
| Create Berita | ✅ | `check.role:admin,manager,staff` | Mulai staff, admin bisa hapus semua |
| Edit Berita | ✅ | `check.role:admin,manager,staff` | Milik sendiri + admin bisa semua |
| Delete Berita | ✅ | `check.role:admin,manager,staff` | Milik sendiri + admin bisa semua |
| Verify Payment | ✅ | `check.role:admin,manager` | Approve/Reject |
| Delete Reservasi | ✅ | (Controller Logic) | Bisa delete any reservasi |

#### Middleware Implementasi
```php
// web.php - Route dengan middleware check.role
Route::middleware('check.role:admin,manager')->group(function () {
    Route::resource('objek-wisata', ObjekWisataController::class)
        ->except(['index', 'show']);
    Route::resource('paket-wisata', PaketWisataController::class)
        ->except(['index', 'show']);
    Route::resource('penginapan', PenginapanController::class)
        ->except(['index', 'show']);
});

Route::middleware('check.role:admin,manager')->group(function () {
    Route::get('/admin/payments', [PaymentController::class, 'adminIndex']);
    Route::get('/admin/payments/{payment}', [PaymentController::class, 'adminShow']);
    Route::post('/admin/payments/{payment}/verify', [PaymentController::class, 'verify']);
});
```

#### Navigation & UI
- **Dashboard Link:** Tampil ✅
- **Sidebar Menu:** Admin resources (Objek, Paket, Penginapan)
- **Management Buttons:** Create, Edit, Delete visible ✅
- **Payment Management:** Lihat di navbar/dashboard ✅
- **Staff Directory:** Dapat akses Karyawan list (TODO - bukan feature saat ini)

---

### 3.2 OWNER - Pemilik/Manager Operasional

**Database Role Value:** `owner` (sebelumnya `manager`)

**Tanggung Jawab Utama:**
- Manage operasional bisnis (Paket, Penginapan, Reservasi)
- Verifikasi pembayaran reservasi
- Monitor revenue dan occupancy

#### Akses Fitur (READ)
| Fitur | Akses | URL Routes | Notes |
|-------|--------|-----------|-------|
| Dashboard Owner | ✅ | `/dashboard` | Stats operasional: reservasi, revenue |
| Objek Wisata (View) | ✅ | `/objek-wisata` | Lihat semua + CRUD |
| Paket Wisata (View) | ✅ | `/paket-wisata` | Lihat semua + CRUD |
| Penginapan (View) | ✅ | `/penginapan` | Lihat semua + CRUD |
| Berita (View) | ✅ | `/berita` | Lihat umum + CRUD milik sendiri |
| Reservasi (View) | ✅ | `/admin/reservasi` | Lihat ALL + Admin detail view |
| Payment Verification | ✅ | `/admin/payments` | Approve/Reject pembayaran |
| Profil | ✅ | `/profile` | Edit profil sendiri |

#### Akses Fitur (WRITE/CREATE)
- **SAMA DENGAN ADMIN** - Shared middleware `check.role:admin,manager` → `check.role:admin,owner`
- Create/Edit/Delete semua resource (Objek, Paket, Penginapan, Berita, Reservasi)
- Verify Payment

#### Navigation & UI
- **Dashboard Link:** Tampil ✅
- **Sidebar Menu:** Operasional resources 
- **Management Buttons:** Create, Edit, Delete visible ✅
- **Payment Management:** Visible ✅

**⚠️ NOTE - Middleware MISMATCH:** 
Saat ini middleware masih gunakan `check.role:admin,manager` - belum update ke `check.role:admin,owner`! Lihat bagian 5 (Issues) untuk detail.

---

### 3.3 BENDAHARA - Staff Keuangan

**Database Role Value:** `bendahara` (sebelumnya `staff`)

**Tanggung Jawab Utama:**
- Kelola aspek keuangan (Payment, Invoice, Accounting)
- Buat & bahagikan berita/content
- Monitor cash flow

#### Akses Fitur (READ)
| Fitur | Akses | URL Routes | Notes |
|-------|----|-----------|---------|
| Dashboard Bendahara | ✅ | `/dashboard` | Stats keuangan: payments, revenue |
| Objek Wisata (View) | ❌ | `/objek-wisata` | Lihat umum, tidak bisa CRUD |
| Paket Wisata (View) | ❌ | `/paket-wisata` | Lihat umum, tidak bisa CRUD |
| Penginapan (View) | ❌ | `/penginapan` | Lihat umum, tidak bisa CRUD |
| Berita (View) | ✅ | `/berita` | Lihat umum + Create/Edit milik sendiri |
| Reservasi (View) | ❓ | `/reservasi` | **NEEDS CLARIFICATION** |
| Payment (View) | ✅ | `/admin/payments` | **ISSUE: masih guna check.role:admin,manager** |
| Profil | ✅ | `/profile` | Edit profil sendiri |

#### Akses Fitur (WRITE/CREATE)
| Fitur | Akses | Middleware | Notes |
|-------|--------|-----------|-------|
| Create Berita | ✅ | `check.role:admin,manager,staff` | ✅ Bendahara included |
| Edit Berita | ✅ | `check.role:admin,manager,staff` | ✅ Milik sendiri |
| Delete Berita | ✅ | `check.role:admin,manager,staff` | ✅ Milik sendiri |
| **Payment Verification** | ❌ | `check.role:admin,manager` | **LINE 1 ISSUE: bendahara tidak included** |
| View Payment Details | ❌ | (Controller) | **ISSUE: bendahara should see, but middleware blocks** |

#### Navigation & UI
- **Dashboard Link:** Tampil ✅ (Bendahara dashboard khusus)
- **Sidebar Menu:** Limited - hanya Berita + Profil
- **CRUD Buttons:** Hanya untuk Berita
- **Payment Management:** ❌ **BLOCKED oleh middleware**

**⚠️ CRITICAL ISSUES untuk Bendahara:**
1. **Middleware `/admin/payments` masih `check.role:admin,manager`** → Bendahara tidak bisa akses
2. **Bendahara seharusnya dapat:** Lihat daftar pembayaran, detail pembayaran (verification)
3. **Current Routes masih gunakan `manager` bukan `owner`**

---

### 3.4 PELANGGAN - Customer/Wisatawan

**Database Role Value:** `pelanggan` (sebelumnya `customer`)

**Tanggung Jawab Utama:**
- Buat reservasi paket wisata
- Upload bukti pembayaran
- Tracking reservasi & status pembayaran
- Edit profil pribadi

#### Akses Fitur (READ)
| Fitur | Akses | URL Routes | Notes |
|-------|--------|-----------|-------|
| Dashboard Pelanggan | ✅ | `/dashboard` | Stats personal: reservasi, spending |
| Objek Wisata (View) | ✅ | `/objek-wisata` | Telusuri destinasi |
| Paket Wisata (View) | ✅ | `/paket-wisata` | Telusuri & pesan paket |
| Penginapan (View) | ✅ | `/penginapan` | Telusuri penginapan |
| Berita (View) | ✅ | `/berita` | Baca artikel/info |
| Reservasi (Own) | ✅ | `/reservasi` | **HANYA reservasi milik sendiri** |
| Payment (Own) | ✅ | `/payments/{payment}` | **HANYA pembayaran milik sendiri** |
| Profil | ✅ | `/profile` | Edit profil pribadi |

#### Akses Fitur (WRITE/CREATE)
| Fitur | Akses | Middleware/Controller | Batasan |
|-------|--------|-----------|---------|
| Create Reservasi | ✅ | `auth` → Controller check | Paket apapun |
| Edit Reservasi | ✅ | `check.role:customer,admin,manager` | **Milik sendiri ONLY** |
| Delete Reservasi | ✅ | `check.role:customer,admin,manager` | **Milik sendiri ONLY** |
| Upload Payment Proof | ✅ | `auth` → Controller check | Reservasi milik sendiri |
| Create Berita | ❌ | `check.role:admin,manager,staff` | Tidak termasuk customer |
| Edit Berita | ❌ | `check.role:admin,manager,staff` | Tidak termasuk |
| Delete Berita | ❌ | `check.role:admin,manager,staff` | Tidak termasuk |

#### Navigation & UI
- **Dashboard Link:** Tampil ✅ (Pelanggan dashboard khusus: reservasi, tips, paket featured)
- **Public Features:** Objek, Paket, Penginapan, Berita - Full visible ✅
- **Reservasi Button:** Create, View own ✅
- **Admin/Management:** Hidden/Blocked ✅

#### Controller Logic Pelanggan
```php
// ReservasiController - Show method
public function show(Reservasi $reservasi)
{
    // Jika pelanggan, hanya bisa lihat reservasi milik sendiri
    if (auth()->user()->role === 'pelanggan') {
        if (auth()->user()->pelanggan->id !== $reservasi->pelanggan_id) {
            abort(403);
        }
    }
    
    return view('reservasi.show', ['reservasi' => $reservasi]);
}

// Untuk admin/owner, lihat admin detail view
if (in_array(auth()->user()->role, ['admin', 'owner'])) {
    return view('admin.reservasi.show', [...]);
}
```

---

## 4. UI/UX IMPLEMENTATION PER ROLE

### 4.1 Dashboard Layout Customization

#### Admin Dashboard Layout
```
┌──────────────────────────────────────────────────┐
│  👨‍💼 Dashboard Admin                              │
│  Welcome, Admin [Name]! - Akses penuh ke sistem │
├──────────────────────────────────────────────────┤
│                                                   │
│  StatsCards:                                      │
│  ┌─────────┬─────────┬─────────┬─────────┐      │
│  │ 👥      │ 📅      │ 🏞️      │ 🎒      │      │
│  │ Users   │ Reservasi│ Objek  │ Paket   │      │
│  │ [10]    │ [25]    │ [8]    │ [12]    │      │
│  └─────────┴─────────┴─────────┴─────────┘      │
│                                                   │
│  Management Sections:                             │
│  ┌──────────────────┬──────────────────┐        │
│  │ 🏞️ Objek Wisata  │ 🎒 Paket Wisata  │        │
│  │ [View] [Add]     │ [View] [Add]     │        │
│  ├──────────────────┼──────────────────┤        │
│  │ 🏨 Penginapan    │ 📰 Berita        │        │
│  │ [View] [Add]     │ [View] [Add]     │        │
│  └──────────────────┴──────────────────┘        │
│                                                   │
│  Recent Activities:                               │
│  - Latest Reservasi (5 items)                    │
│  - Latest Berita (5 items)                       │
│  - Revenue Analytics                             │
│                                                   │
└──────────────────────────────────────────────────┘
```

**File:** `resources/views/dashboard/admin.blade.php`

#### Owner Dashboard Layout
```
┌──────────────────────────────────────────────────┐
│  🏢 Dashboard Pemilik                             │
│  Welcome, Owner [Name]! - Kelola operasional    │
├──────────────────────────────────────────────────┤
│                                                   │
│  StatsCards:                                      │
│  ┌─────────┬─────────┬─────────┬─────────┐      │
│  │ 📅      │ ✅      │ 💰      │ 📈      │      │
│  │ Reservasi│Confirmed│Revenue │Growth   │      │
│  │ [25]    │ [18]    │ [Rp50M] │ [15%]   │      │
│  └─────────┴─────────┴─────────┴─────────┘      │
│                                                   │
│  Quick Actions:                                   │
│  ┌──────────────────┬──────────────────┐        │
│  │ 📦 Paket Wisata  │ 🏨 Penginapan    │        │
│  │ [Manage]         │ [Manage]         │        │
│  ├──────────────────┼──────────────────┤        │
│  │ 🔐 Pembayaran    │ 📊 Statistik     │        │
│  │ [Verify]         │ [View]           │        │
│  └──────────────────┴──────────────────┘        │
│                                                   │
└──────────────────────────────────────────────────┘
```

**File:** `resources/views/dashboard/manager.blade.php`

#### Bendahara Dashboard Layout
```
┌──────────────────────────────────────────────────┐
│  💰 Dashboard Bendahara                           │
│  Welcome, Bendahara [Name]! - Kelola Keuangan   │
├──────────────────────────────────────────────────┤
│                                                   │
│  StatsCards:                                      │
│  ┌─────────┬─────────┬─────────┬─────────┐      │
│  │ 💰      │ ✅      │ ❌      │ 📊      │      │
│  │ Revenue │ Verified│ Pending │ Growth  │      │
│  │ [50M]   │ [18]    │ [5]     │ [+12%]  │      │
│  └─────────┴─────────┴─────────┴─────────┘      │
│                                                   │
│  Finance Control:                                 │
│  ┌──────────────────┬──────────────────┐        │
│  │ 🔐 Pembayaran    │ 📰 Berita        │        │
│  │ [Manage]         │ [Create]         │        │
│  ├──────────────────┼──────────────────┤        │
│  │ 📊 Laporan       │ 👤 Profil        │        │
│  │ [View]           │ [Edit]           │        │
│  └──────────────────┴──────────────────┘        │
│                                                   │
└──────────────────────────────────────────────────┘
```

**File:** `resources/views/dashboard/staff.blade.php`

#### Pelanggan Dashboard Layout
```
┌──────────────────────────────────────────────────┐
│  👤 Dashboard Pelanggan                           │
│  Selamat Datang, [Name]! - Jelajahi wisata Anda │
├──────────────────────────────────────────────────┤
│                                                   │
│  My Reservations:                                 │
│  ┌─────────┬─────────┬─────────┬─────────┐      │
│  │ 📅      │ ⏳      │ ✅      │ 💰      │      │
│  │ Total   │ Pending │Confirmed│ Spent   │      │
│  │ [8]     │ [2]     │ [6]     │ [Rp15M] │      │
│  └─────────┴─────────┴─────────┴─────────┘      │
│                                                   │
│  Quick Actions:                                   │
│  ┌──────────────────┬──────────────────┐        │
│  │ 📝 Reservasi     │ 👤 Profil        │        │
│  │ [View Details]   │ [Edit Profile]   │        │
│  ├──────────────────┼──────────────────┤        │
│  │ 🎒 Paket Populer │ 🏨 Penginapan    │        │
│  │ [Browse]         │ [Browse]         │        │
│  └──────────────────┴──────────────────┘        │
│                                                   │
```

**File:** `resources/views/dashboard/customer.blade.php`

### 4.2 Navigation Bar Role-Based Hiding

**Current Implementation:**
```blade
<ul class="navbar-nav ms-auto gap-1">
    {{-- Public routes available for all --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('objek-wisata.index') }}">
            <span>📍</span> Objek
        </a>
    </li>
    {{-- ... paket, penginapan, berita ... --}}
    
    @if (auth()->check())
        {{-- Authenticated users --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reservasi.index') }}">
                🗳️ Reservasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                📊 Dashboard
            </a>
        </li>
    @endif
</ul>
```

**Issues:**
- ✅ Dashboard link visible untuk semua authenticated users
- ❓ **Tidak ada role indicator di navbar**
- ❓ **Tidak ada clear visual distinction per role**

---

## 5. ISSUES & GAPS IDENTIFIKASI

### 5.1 CRITICAL ISSUE #1 - Middleware Belum Update ke Role Baru

**Status:** 🔴 CRITICAL

**Problem:** Routes masih gunakan role lama (`manager`, `staff`) di middleware, padahal database sudah gunakan role baru (`owner`, `bendahara`).

**Lokasi:**
```php
// web.php - CURRENT (WRONG)
Route::middleware('check.role:admin,manager')->group(function () {
    // Ini termasuk OWNER (bukan manager)
    Route::resource('objek-wisata', ObjekWisataController::class)...
});

Route::middleware('check.role:admin,manager,staff')->group(function () {
    // STAFF sudah tidak ada, sekarang BENDAHARA
    Route::post('/berita', [BeritaController::class, 'store'])...
});
```

**Required Fix:**
```php
// web.php - CORRECTED
Route::middleware('check.role:admin,owner')->group(function () {
    Route::resource('objek-wisata', ObjekWisataController::class)...
});

Route::middleware('check.role:admin,owner,bendahara')->group(function () {
    Route::post('/berita', [BeritaController::class, 'store'])...
});

Route::middleware('check.role:admin,owner')->group(function () {
    Route::get('/admin/payments', [PaymentController::class, 'adminIndex']);
    Route::post('/admin/payments/{payment}/verify', [PaymentController::class, 'verify']);
});
```

**Impact:** 🔴 Bendahara TIDAK BISA AKSES FITUR yang seharusnya bisa (Berita Create, Payment Verify)

---

### 5.2 ISSUE #2 - Bendahara Tidak Bisa Akses Payment Management

**Status:** 🟠 HIGH

**Problem:** Payment verification route masih terbatas hanya `admin,manager` - tidak termasuk `bendahara`.

**Lokasi:** `routes/web.php` line ~40
```php
Route::middleware('check.role:admin,manager')->group(function () {
    Route::get('/admin/payments', [PaymentController::class, 'adminIndex']);
    Route::get('/admin/payments/{payment}', [PaymentController::class, 'adminShow']);
    Route::post('/admin/payments/{payment}/verify', [PaymentController::class, 'verify']);
});
```

**Current Behavior:**
- Bendahara login → Try akses `/admin/payments` → 403 Forbidden ❌

**Expected Behavior:**
- Bendahara harus bisa verify pembayaran (sesuai dengan role "Bendahara = Keuangan")
- Admin/Owner bisa delegate ke Bendahara untuk finalisasi pembayaran

**Solution:**
```php
Route::middleware('check.role:admin,owner,bendahara')->group(function () {
    Route::get('/admin/payments', [PaymentController::class, 'adminIndex']);
    Route::get('/admin/payments/{payment}', [PaymentController::class, 'adminShow']);
    Route::post('/admin/payments/{payment}/verify', [PaymentController::class, 'verify']);
});
```

---

### 5.3 ISSUE #3 - Pelanggan Reservasi Authorization Logic

**Status:** 🟡 MEDIUM

**Problem:** Edit & Delete Reservasi hanya di controller, tidak ada view-level checks untuk UX yang jelas.

**Current:**
```blade
<!-- reservasi/edit.blade.php -->
@if (in_array(auth()->user()->role, ['admin', 'manager']))
    {{-- Delete button for admin/manager --}}
@endif
```

**Issue:**
- Pelanggan tidak punya visual button untuk edit sendiri
- Tidak clear bahwa pelanggan BISA edit sampai try

**Better UX:**
```blade
@if (auth()->user()->role === 'pelanggan' && $reservasi->pelanggan->user_id === auth()->user()->id)
    <!-- Show Edit Button for Own Reservasi -->
    <a href="{{ route('reservasi.edit', $reservasi) }}" class="btn btn-primary">
        Edit Reservasi
    </a>
@elseif (in_array(auth()->user()->role, ['admin', 'owner']))
    <!-- Admin/Owner Actions -->
    <a href="#" class="btn btn-danger">Delete</a>
@endif
```

---

### 5.4 ISSUE #4 - Payment Proof Access Control

**Status:** 🟡 MEDIUM

**Problem:** Payment proof display logic terlalu kompleks di view (banyak ternary operators).

**Current Code (payments/show.blade.php):**
```blade
@if($payment->proof_path && auth()->check() && 
    (auth()->user()->role === 'customer' || 
     auth()->user()->pelanggan?->reservasi?->first()?->id === $payment->reservasi_id || 
     in_array(auth()->user()->role, ['admin', 'manager'])))
    <!-- Display proof -->
@endif
```

**Issues:**
- Sangat kompleks dan sulit maintain
- Kondisi `pelanggan?->reservasi?->first()` bisa return null
- 'manager' masih hardcoded (harus 'owner')

**Better Approach:**
```blade
@can('viewPaymentProof', $payment)
    <!-- Display proof -->
@endcan
```

Dengan Policy:
```php
// Policies/PaymentPolicy.php
public function viewPaymentProof(User $user, Payment $payment)
{
    if (in_array($user->role, ['admin', 'owner'])) {
        return true;
    }
    
    if ($user->role === 'pelanggan' && 
        $user->pelanggan && 
        $payment->reservasi->pelanggan_id === $user->pelanggan->id) {
        return true;
    }
    
    return false;
}
```

---

### 5.5 ISSUE #5 - Dashboard Routing di HomeController

**Status:** 🟡 MEDIUM

**Problem:** Dashboard routing masih gunakan role lama.

**Current (HomeController.php):**
```php
public function dashboard(Request $request)
{
    $user = $request->user();
    
    if ($user->role === 'customer') {
        return $this->customerDashboard($user);
    } elseif ($user->role === 'manager') {  // ❌ WRONG - harus 'owner'
        return $this->managerDashboard($user);
    } elseif ($user->role === 'staff') {     // ❌ WRONG - harus 'bendahara'
        return $this->staffDashboard($user);
    }
}
```

**Action Required:**
- Update role checks ke nilai baru (`owner`, `bendahara`, `pelanggan`)

---

### 5.6 ISSUE #6 - Role Display & Labeling Inkonsisten

**Status:** 🟡 MEDIUM

**Problem:** Role display di UI tidak konsisten - terkadang label berbeda dengan database.

**Current:**
```blade
<!-- profile/edit.blade.php -->
@switch(auth()->user()->role)
    @case('admin')
        Admin
    @case('owner')
        Pemilik
    @case('bendahara')
        Bendahara
    @case('pelanggan')
        Pelanggan
    @default
        Unknown
@endswitch
```

**Issues:**
- Hardcoded di berbagai view
- Tidak ada single source of truth
- Tricky untuk maintain konsistensi label

**Better Solution:**
```php
// Buat Role Enum atau Constant:
class UserRole {
    const ADMIN = 'admin';
    const OWNER = 'owner';
    const BENDAHARA = 'bendahara';
    const PELANGGAN = 'pelanggan';
    
    const LABELS = [
        self::ADMIN => 'Administrator',
        self::OWNER => 'Pemilik/Manager',
        self::BENDAHARA => 'Bendahara/Keuangan',
        self::PELANGGAN => 'Pelanggan/Wisatawan',
    ];
}

// Di view:
<span>{{ UserRole::LABELS[auth()->user()->role] }}</span>
```

---

### 5.7 ISSUE #7 - Tidak Ada Visual Role Indicator

**Status:** 🟠 HIGH (UX)

**Problem:** User tidak tahu role mereka hanya dengan lihat navbar.

**Current State:**
- Nama user terlihat di navbar
- Tetapi ROLE TIDAK visible

**Expected:**
```
Avatar: 👨‍💼 | Name: Admin Desmok | Role Badge: 👤 Admin
```

**Benefit:**
- Quick clarity untuk user apa akses mereka
- Reduce confusion saat context-switch antara akun

---

## 6. TESTING HASIL ROLE IMPLEMENTATION

### 6.1 Test Accounts yang Ada

| Role | Email | Password | Notes |
|------|-------|----------|-------|
| Admin | admin@desmok.com | password123 | Full access |
| Owner | manager@desmok.com* | password123 | *DB updated to 'owner' |
| Bendahara | staff@desmok.com* | password123 | *DB updated to 'bendahara' |
| Pelanggan | customer@desmok.com | password123 | Limited access |

*Note: Database sudah updated tapi email labels masih lama

---

## 7. REKOMENDASI & ACTION PLAN

### 7.1 Priority 1 - CRITICAL (Immediate Fix)

**Task 1.1:** Update Middleware di `routes/web.php`
```php
// BEFORE:
Route::middleware('check.role:admin,manager,staff')->group(...)

// AFTER:
Route::middleware('check.role:admin,owner,bendahara')->group(...)
```

**Task 1.2:** Update HomeController dashboard routing
```php
// Change all references:
// 'customer' → tetap (sudah benar)
// 'manager' → 'owner'
// 'staff' → 'bendahara'
```

**Impact:** ✅ Bendahara bisa akses fitur yang seharusnya
**Estimated Time:** 30 menit
**Files to Edit:** 
  - `routes/web.php`
  - `app/Http/Controllers/HomeController.php`

---

### 7.2 Priority 2 - HIGH (UX Enhancement)

**Task 2.1:** Add Role Badge di Navbar
```blade
@if (auth()->check())
    <span class="role-badge" style="...">
        {{ UserRole::LABELS[auth()->user()->role] }}
    </span>
@endif
```

**Task 2.2:** Implement Authorization Policies
```php
// Create Policies for:
// - PaymentPolicy
// - ReservasiPolicy
// - KaryawanPolicy (for future HR feature)
```

**Impact:** ✅ Better UX clarity, more maintainable authorization logic
**Estimated Time:** 2-3 hours
**Files to Create:**
  - `app/Policies/PaymentPolicy.php`
  - `app/Policies/ReservasiPolicy.php`

---

### 7.3 Priority 3 - MEDIUM (Code Quality)

**Task 3.1:** Create UserRole Constant/Enum
```php
// app/Enums/UserRole.php atau app/Constants/UserRole.php
```

**Task 3.2:** Standardize Role Display Labels
- Gunakan constant from UserRole class di semua views
- Remove hardcoded role labels

**Impact:** ✅ Single source of truth, easier maintenance
**Estimated Time:** 1 hour

---

## 8. TABEL RINGKAS - ROLE COMPARISON

| Fitur | Admin | Owner | Bendahara | Pelanggan |
|-------|-------|-------|-----------|-----------|
| **ACCESS LEVEL** | **Full** | **High (Operational)** | **Medium (Finance)** | **Low (Personal)** |
| Objek Wisata CRUD | ✅ | ✅ | ❌ | ❌ |
| Paket Wisata CRUD | ✅ | ✅ | ❌ | ❌ |
| Penginapan CRUD | ✅ | ✅ | ❌ | ❌ |
| Berita CRUD (own+all) | ✅ | ✅ | ✅ | ❌ |
| Reservasi View ALL | ✅ | ✅ | ❌ | ❌ |
| Reservasi View Own | ✅ | ✅ | ❌ | ✅ |
| Payment Verify | ✅ | ✅ | ⚠️ (BLOCKED) | ❌ |
| User Management | ✅ | ❌ | ❌ | ❌ |
| Dashboard Stats | ✅ | ✅ | ✅ | ✅ |
| Profile Edit | ✅ | ✅ | ✅ | ✅ |

---

## 9. KESIMPULAN

### 9.1 Role System Assessment

| Aspek | Status | Keterangan |
|-------|--------|-----------|
| **Struktur Role** | ✅ Well-Defined | 4 role jelas dengan tanggung jawab spesifik |
| **Database Model** | ✅ Properly Designed | Relationships dengan Karyawan & Pelanggan OK |
| **Route Protection** | 🔴 NEEDS FIX | Middleware masih gunakan role lama |
| **Authorization Logic** | 🟡 PARTIALLY OK | Ada di controller, tapi ada logic issues |
| **UI/UX Clarity** | 🟡 IMPROVABLE | Tidak ada visual role indicator |
| **Code Maintainability** | 🟡 MEDIUM | Authorization logic scattered, inkonsisten |

### 9.2 Overall State

✅ **Role system structure SOLID** - 4 role dengan tanggung jawab jelas dan relasi database established
🔴 **Implementation HAS CRITICAL BUGS** - Middleware belum update ke role baru, bendahara blocked
🟡 **UX needs improvement** - Role tidak visible, authorization logic perlu refactor

### 9.3 Next Steps (Priority Order)

1. ✅ **FIX CRITICAL:** Update middleware + HomeController (ASAP)
2. 🔧 **IMPLEMENT:** Role badge di navbar + Policies
3. 📝 **REFACTOR:** Create UserRole constant + standardize labels
4. 📊 **FUTURE:** Optional role-based menu sidebar customization

---

**Dianalisa oleh:** GitHub Copilot  
**Tanggal:** 5 April 2026  
**Versi:** 2.0 - Comprehensive Role & UX Analysis
