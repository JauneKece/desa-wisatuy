# 🔧 QUICK REFERENCE GUIDE - ROLE-BASED SYSTEM

**For Developers & Maintainers**

---

## 📍 FILE LOCATIONS

### Core Implementation
```
app/Enums/UserRole.php                    → Role constants & helpers
app/Models/User.php                        → User model + helpers
app/Policies/PaymentPolicy.php             → Payment authorization
app/Policies/ReservasiPolicy.php           → Reservasi authorization
app/Providers/AppServiceProvider.php       → Policy registration
routes/web.php                             → Route protection middleware
```

### Views
```
resources/views/layouts/navbar.blade.php   → Role badge indicator
resources/views/dashboard/admin.blade.php  → Admin dashboard
resources/views/dashboard/manager.blade.php → Owner dashboard
resources/views/dashboard/staff.blade.php  → Bendahara dashboard
resources/views/dashboard/customer.blade.php → Pelanggan dashboard
```

### Documentation
```
ANALISA_SISTEM_ROLE_COMPREHENSIVE.md      → Full analysis (issues + solutions)
IMPLEMENTASI_ROLE_BASED_UI_UX.md          → Implementation guide + testing
SUMMARY_IMPLEMENTASI_ROLE_BASED.md        → Executive summary
HASIL_IMPLEMENTASI_FINAL.md               → Final results & visual summary
```

---

## 🎯 QUICK CHECKLISTS

### When Checking User Role

```php
// Option 1: Direct check (SIMPLEST)
if (auth()->user()->isAdmin()) {
    // allow
}

// Option 2: Permission check (RECOMMENDED)
if (auth()->user()->canManagePayments()) {
    // allow
}

// Option 3: Using policies (MOST POWERFUL)
if (auth()->user()->can('verify', $payment)) {
    // allow
}

// Option 4: Using Gate (FOR COMPLEX LOGIC)
Gate::authorize('verify', $payment);  // throws 403 if not authorized
```

### When Protecting a Route

```php
// Single role
Route::middleware('check.role:admin')->group(function () {
    // ...
});

// Multiple roles
Route::middleware('check.role:admin,owner,bendahara')->group(function () {
    // ...
});
```

### When Using in Blade

```blade
{{-- Option 1: Direct condition --}}
@if (auth()->user()->isAdmin())
    Admin content
@endif

{{-- Option 2: Permission helper method --}}
@if (auth()->user()->canCreateBerita())
    <a href="{{ route('berita.create') }}">Create</a>
@endif

{{-- Option 3: Using @can directive with policy --}}
@can('verify', $payment)
    <button>Verify Payment</button>
@endcan
```

---

## 📋 ROLE VALUES & HELPERS

### Available Roles
```
'admin'      → Administrator
'owner'      → Pemilik/Manager Operasional
'bendahara'  → Bendahara/Keuangan
'pelanggan'  → Pelanggan/Wisatawan
```

### Quick Permission Matrix

|  | Admin | Owner | Bendahara | Pelanggan |
|---|-------|-------|-----------|-----------|
| **canManageResources()** | ✅ | ✅ | ❌ | ❌ |
| **canManagePayments()** | ✅ | ✅ | ✅ | ❌ |
| **canCreateBerita()** | ✅ | ✅ | ✅ | ❌ |
| **canViewAll()** | ✅ | ✅ | ❌ | ❌ |

---

## 🔐 PROTECTED ROUTES

### Admin/Owner Only
```
/objek-wisata/*             → Create/Edit/Delete
/paket-wisata/*             → Create/Edit/Delete
/penginapan/*               → Create/Edit/Delete
```

### Admin/Owner/Bendahara
```
/admin/payments             → View all
/admin/payments/*           → View detail
/admin/payments/*/verify    → Approve
/berita/*                   → Create/Edit/Delete
```

### Pelanggan/Admin/Owner
```
/reservasi/*/edit           → Edit own or all
/reservasi/*/delete         → Delete own or all
```

---

## 🛠️ COMMON TASKS

### Add New Role-Based Feature

1. **Define the permission:**
   ```php
   // In User model or UserRole enum
   public static function canFeatureName($role) {
       return in_array($role, ['admin', 'owner']);
   }
   ```

2. **Protect the route:**
   ```php
   Route::middleware('check.role:admin,owner')->group(function () {
       Route::get('/feature', [FeatureController::class, 'index']);
   });
   ```

3. **Create policy (optional):**
   ```php
   class FeaturePolicy {
       public function view(User $user) { ... }
       public function create(User $user) { ... }
   }
   ```

4. **Use in controller/view:**
   ```blade
   @if (auth()->user()->canFeatureName())
       {{ route('feature.index') }}
   @endif
   ```

### Debug Role Issues

```php
// In tinker or controller
$user = auth()->user();
echo "Role: " . $user->role;
echo "Label: " . $user->role_label;
echo "Icon: " . $user->role_icon;
echo "isAdmin: " . $user->isAdmin();
echo "canManagePayments: " . $user->canManagePayments();
```

### Add New Dashboard Widget

```php
// In HomeController - e.g., bendaharaDashboard()
private function staffDashboard($user)
{
    $pendingPayments = Payment::where('status', 'pending')->count();
    
    return view('dashboard.staff', compact('pendingPayments'));
}
```

---

## ✅ COMMON PATTERNS

### Check if user can edit own resource

```blade
@if (auth()->user()->id === $item->user_id || auth()->user()->canManageResources())
    <a href="{{ route('item.edit', $item) }}">Edit</a>
@endif
```

### Show admin controls for certain roles

```blade
@if (auth()->check() && in_array(auth()->user()->role, ['admin', 'owner']))
    <div class="admin-controls">
        ...
    </div>
@endif
```

### Use policy for fine-grained control

```php
// Controller
if (auth()->user()->can('update', $payment)) {
    // Update payment
}

// Blade
@can('update', $payment)
    <button>Update</button>
@endcan
```

---

## 🐛 TROUBLESHOOTING

### "Unauthorized" Error
```
Check:
1. Is user logged in? → auth()->check()
2. What's their role? → auth()->user()->role
3. Is route middleware correct? → check.role:...
4. Is policy method defined? → Policies/...Policy.php
```

### Role Badge Not Showing
```
Check:
1. Is navbar condition correct? → @if (auth()->check())
2. View helpers loaded? → php artisan config:cache
3. Syntax in blade file? → Check navbar.blade.php
```

### Permission Denied on Route
```
Check:
1. Middleware check.role includes user's role?
2. User's database role value matches?
3. Database migration ran? → php artisan migrate
```

---

## 📞 REFERENCES

### Key Classes
- `App\Enums\UserRole` - Role constants
- `App\Models\User` - User model with helpers
- `App\Policies\PaymentPolicy` - Payment auth
- `App\Policies\ReservasiPolicy` - Reservasi auth

### Key Methods
- `User::isAdmin()`, `isOwner()`, `isBendahara()`, `isPelanggan()`
- `User::canManageResources()`, `canManagePayments()`, `canCreateBerita()`
- `UserRole::getLabel()`, `getIcon()`, `getDescription()`

### Key Files
- `routes/web.php` - Route protection
- `app/Providers/AppServiceProvider.php` - Policy registration
- `resources/views/layouts/navbar.blade.php` - UI role indicator

---

## 🚀 PERFORMANCE TIPS

1. **Cache role checks:**
   ```php
   // Create route cache for faster startup
   php artisan route:cache
   
   // Cache config
   php artisan config:cache
   ```

2. **Use early exit in views:**
   ```blade
   @unless (auth()->user()->canManagePayments())
       @return
   @endunless
   ```

3. **Eager load relations:**
   ```php
   User::with('pelanggan', 'karyawan')->find($id)
   ```

---

## 🎓 LEARNING RESOURCES

See documentation files:
1. `ANALISA_SISTEM_ROLE_COMPREHENSIVE.md` - Deep dive analysis
2. `IMPLEMENTASI_ROLE_BASED_UI_UX.md` - Full implementation guide
3. `SUMMARY_IMPLEMENTASI_ROLE_BASED.md` - High-level overview

---

**Keep this guide bookmarked for quick reference!**

*Last updated: 5 April 2026*
