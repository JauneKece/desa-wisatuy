# Implementasi Migrasi Database Users - Phase 1 ONLY

Tanggal: 2026-04-05  
Status: ✅ Implementasi Complete (Users Only - SIMPLIFIED)

**Scope:** Hanya migrasi Users table dari DB1 ke DB2 format.
- ✅ Ubah enum `role` dari `(admin|manager|staff|customer)` ke `(admin|owner|bendahara|pelanggan)`
- ✅ Tambah kolom `akitf` (tinyint) untuk sinkronisasi dengan `is_active`
- ✅ **TIDAK ada kolom `level`** - role dan akitf saja sudah cukup (role dan level adalah konsep yang sama)

**Fitur lain di database tetap sesuai DB1 - TIDAK DIUBAH**

## Executive Summary

Fase pertama migrasi database users table dari DB1 ke DB2 format telah dimulai dengan pendekatan backward-compatible dan simplified:
- Kolom baru ditambahkan (tidak ada penghapusan)
- Role enum values diubah langsung dalam migration via SQL CASE statement
- Accessor/Mutator memastikan sinkronisasi otomatis antara `akitf` dan `is_active`
- Script migrasi data disediakan dengan dry-run mode untuk safety

## Perubahan yang Dilakukan

### 1. Database Migration File
**File:** `database/migrations/2026_04_05_000001_update_users_table_for_db2_compatibility.php`

**Perubahan Schema:**

**A. Ubah Role Enum Values (Direct SQL Update)**
```
Mapping Langsung di Database:
- 'manager' → 'owner'
- 'staff' → 'bendahara'
- 'customer' → 'pelanggan'
- 'admin' → 'admin' (tetap)

Dilakukan via: DB::statement() dengan CASE statement untuk atomic update
```

**B. Tambah Kolom Akitf**
```
- Kolom: 'akitf' (tinyint)
- Default: 1
- Tujuan: Shorthand untuk is_active (DB2 convention)
- Synced: Dari is_active value di migration
```

**Kolom DB1 yang Tetap Dipertahankan:**
- `role` (enum dengan nilai BARU: admin|owner|bendahara|pelanggan)
- `is_active` (boolean) - tetap untuk backward-compatibility

### 2. Model Update
**File:** `app/Models/User.php`

**Perubahan:**
- `$fillable` ditambahkan: `akitf` (hanya akitf, TIDAK ada level)
- Helper methods:
  - `getRoleName($role)` - Mengembalikan nama tampilan role dalam bahasa Indonesia (Admin, Pemilik, Bendahara, Pelanggan)
  - `getAkitfAttribute()` - Accessor untuk akitf (fallback ke is_active jika null)
  - `setAkitfAttribute()` - Mutator untuk akitf (auto-sync ke is_active)

**Keuntungan:**
- Code existing yang pakai `$user->role` tetap berfungsi dengan nilai baru
- Code existing yang pakai `$user->is_active` tetap berfungsi
- Accessor/Mutator untuk `akitf` memastikan selalu sinkron dengan `is_active`
- Tidak ada kolom redundan (no level column)

**Kode Referensi:**
```php
// Helper untuk tampilan role
protected function getRoleName($role = null): string {
    return match($role ?? $this->role) {
        'admin' => 'Admin',
        'owner' => 'Pemilik',
        'bendahara' => 'Bendahara',
        'pelanggan' => 'Pelanggan',
        default => 'Unknown'
    };
}

// Accessor - fallback akitf dari is_active
public function getAkitfAttribute($value) {
    if ($value !== null) return (bool) $value;
    return (bool) $this->is_active;
}

// Mutator - sync akitf ke is_active
public function setAkitfAttribute($value) {
    $this->attributes['akitf'] = (int) $value;
    $this->attributes['is_active'] = (bool) $value;
}
```

### 3. Artisan Command untuk Migrasi Data
**File:** `app/Console/Commands/MigrateUsersToDb2Format.php`

Command: `php artisan db:migrate-users-db2`

**Fitur:**
- Sinkronisasi nilai `akitf` dengan `is_active` untuk semua users existing
- Support `--dry-run` flag untuk preview sebelum commit
- Progress reporting dengan detail setiap user
- Otomatis handle null values

**Usage:**
```bash
# Preview perubahan (dry run)
php artisan db:migrate-users-db2 --dry-run

# Apply perubahan
php artisan db:migrate-users-db2
```

**Mapping yang Dilakukan:**
```
is_active (boolean) → akitf (tinyint)
- true → 1
- false → 0

Role enum values:
- Sudah diubah di migration (manager→owner, staff→bendahara, customer→pelanggan)
- Command hanya memastikan akitf value sinkron dengan is_active
```

## Langkah Implementasi di Staging/Development

### Step 1: Jalankan Migration
```bash
php artisan migrate
```

Output:
```
Migrating: 2026_04_05_000001_update_users_table_for_db2_compatibility
Migrated:  2026_04_05_000001_update_users_table_for_db2_compatibility (X.XXXs)
```

**Apa yang terjadi:**
- Enum `role` values berubah: manager→owner, staff→bendahara, customer→pelanggan
- Kolom `akitf` ditambahkan dan di-populate dari `is_active`
- Semua data existing tetap aman

### Step 2: Preview Perubahan Data (Dry Run)
```bash
php artisan db:migrate-users-db2 --dry-run
```

Contoh output:
```
Starting migration of users to DB2 format...
[DRY RUN MODE - No changes will be saved]

Found 5 users to migrate.

User ID #1 (Admin User):
  is_active: 1 → akitf: 1
  [PREVIEW ONLY - Not saved]

User ID #2 (Manager User):
  is_active: 1 → akitf: 1
  Current role: owner (sudah diubah di migration)
  [PREVIEW ONLY - Not saved]

... [lebih banyak users]

=== Migration Summary ===
Updated: 5
Failed: 0

[DRY RUN] To apply these changes, run without --dry-run flag:
  php artisan db:migrate-users-db2
```

### Step 3: Apply Migrasi Data
```bash
php artisan db:migrate-users-db2
```

Output:
```
Starting migration of users to DB2 format...

User ID #1 (Admin User):
  is_active: 1 → akitf: 1
  ✓ Updated

... [lebih banyak users]

=== Migration Summary ===
Updated: 5
Failed: 0
✓ All users successfully migrated to DB2 format!
```

### Step 4: Verifikasi Data
```bash
# Via Tinker
php artisan tinker

# Cek role values berubah
>>> User::where('role', 'owner')->count()  // Should show count of users who were manager
>>> User::where('role', 'bendahara')->count()  // Should show count of users who were staff
>>> User::where('role', 'pelanggan')->count()  // Should show count of users who were customer

# Cek akitf dan is_active sinkron
>>> User::first()
// Display akan menunjukkan is_active dan akitf dengan nilai sama

# Test helper method
>>> User::first()->getRoleName()  // Return "Pemilik" untuk owner, "Bendahara" untuk bendahara, dll
```

## Testing Checklist

- [ ] Migration file berhasil di-run tanpa error
- [ ] Kolom `akitf` berhasil ditambahkan ke users table
- [ ] Enum `role` values berhasil diubah (manager→owner, staff→bendahara, customer→pelanggan)
- [ ] Artisan command berhasil melakukan dry-run tanpa error
- [ ] Artisan command berhasil melakukan migrasi data real
- [ ] Accessor: `$user->akitf` return benar (sinkron dengan is_active)
- [ ] Mutator: Set `$user->akitf = 1` juga update `$user->is_active = true`
- [ ] Boolean casting: `$user->is_active` dan `$user->akitf` return tipe yang benar
- [ ] Role helper: `$user->getRoleName()` return nama tampilan yang benar
- [ ] Backward compatibility: Code existing pakai role/is_active tetap jalan
- [ ] API response: JSON output include `role` dan `akitf` fields dengan nilai baru
- [ ] Database check: `SELECT * FROM users` menunjukkan role values BARU (owner, bendahara, pelanggan)

## Role Mapping Reference

| DB1 Role | DB2 Role | Tampilan |
|----------|----------|---------|
| `admin` | `admin` | Admin |
| `manager` | `owner` | Pemilik |
| `staff` | `bendahara` | Bendahara |
| `customer` | `pelanggan` | Pelanggan |

## SQL Manual (Jika diperlukan fallback)

```sql
-- Check status kolom dan role values
SELECT id, name, role, is_active, akitf FROM users LIMIT 5;

-- Verify role mapping berhasil (jika migration belum di-run)
UPDATE users SET role = CASE 
  WHEN role = 'manager' THEN 'owner'
  WHEN role = 'staff' THEN 'bendahara'
  WHEN role = 'customer' THEN 'pelanggan'
  ELSE role
END WHERE role IN ('manager', 'staff', 'customer');

-- Verify akitf sync dengan is_active (jika command belum di-run)
UPDATE users SET akitf = IF(is_active = 1, 1, 0);

-- Check hasil mapping
SELECT id, name, role, is_active, akitf 
FROM users 
WHERE role IN ('owner', 'bendahara', 'pelanggan') 
  AND is_active = akitf;
```

## Rollback Plan

Jika ada error atau ingin revert:

```bash
# Rollback migration
php artisan migrate:rollback

# Atau specific rollback
php artisan migrate:rollback --step=1
```

**Apa yang terjadi saat rollback:**
- Kolom `akitf` dihapus dari users table
- Enum `role` values dikembalikan ke nilai original (admin|manager|staff|customer)
- Data `is_active` tetap aman
- Semua user data tetap ada, hanya schema yang berubah

## Next Phase

**STOP - Migrasi hanya untuk Users table saja, tidak ada fase selanjutnya.**

Alasan simplifikasi:
- Kolom `role` dan `level` adalah konsep yang sama, jadi cukup ubah enum values
- Akitf adalah shorthand dari is_active, tidak perlu kolom terpisah yang kompleks
- User model tidak perlu banyak mapping methods

Jika di masa depan ingin migrasi tabel lain (Pelanggan, Reservasi, dll), buat plan dan implementation terpisah sesuai requirements saat itu.

---

## Referensi: Struktur Users Table Setelah Migrasi

```
users (DB1 + DB2 Compatible - SIMPLIFIED)
├── id (bigint, primary)
├── name (varchar)
├── email (varchar, unique)
├── email_verified_at (timestamp, nullable)
├── password (varchar)
├── remember_token (varchar, nullable)
├── role (enum: admin|owner|bendahara|pelanggan) [UPDATED VALUES]
├── is_active (boolean) [DB1 Legacy - tetap untuk backward-compat]
├── akitf (tinyint) [DB2 New - shorthand is_active]
├── created_at (timestamp)
└── updated_at (timestamp)

Relationships (Unchanged):
- pelanggan (1:1 HasOne)
- karyawan (1:1 HasOne) 
- berita (1:Many HasMany)

Key Points:
- Tidak ada kolom 'level' (redundan dengan role)
- Hanya ada 'akitf' (untuk DB2 convention)
- Semua role mapping dilakukan via direct SQL di migration
- Accessor/Mutator untuk akitf ↔ is_active sync
```
