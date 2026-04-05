<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'akitf',      // DB2 compatibility (shorthand: aktif)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'akitf' => 'boolean',
        ];
    }

    /**
     * Map role dari DB1 ke nilai baru DB2
     * Conversion: 
     * - admin → admin (tetap)
     * - manager → owner (diubah)
     * - staff → bendahara (diubah)
     * - customer → pelanggan (diubah)
     */
    protected function getRoleName($role = null): string
    {
        $role = $role ?? $this->role;
        return match($role) {
            'admin' => 'Admin',
            'owner' => 'Pemilik',
            'bendahara' => 'Bendahara',
            'pelanggan' => 'Pelanggan',
            default => 'Unknown'
        };
    }

    /**
     * Accessor: Get akitf dari is_active jika akitf belum diset
     */
    public function getAkitfAttribute($value)
    {
        if ($value !== null) {
            return (bool) $value;
        }
        // Fallback ke is_active
        return (bool) $this->is_active;
    }

    /**
     * Mutator: Set akitf dan auto-update is_active untuk backward compatibility
     */
    public function setAkitfAttribute($value)
    {
        $this->attributes['akitf'] = (int) $value;
        // Update is_active juga untuk backward compatibility
        $this->attributes['is_active'] = (bool) $value;
    }

    /**
     * Get the pelanggan associated with the user.
     */
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class);
    }

    /**
     * Get the karyawan associated with the user.
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    /**
     * Get the berita associated with the user.
     */
    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * ==========================================
     * ROLE CHECKING HELPER METHODS
     * ==========================================
     */

    /**
     * Get role label display name
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'owner' => 'Pemilik/Manager',
            'bendahara' => 'Bendahara/Keuangan',
            'pelanggan' => 'Pelanggan/Wisatawan',
            default => 'Unknown'
        };
    }

    /**
     * Get role icon emoji
     */
    public function getRoleIconAttribute(): string
    {
        return match($this->role) {
            'admin' => '👨‍💼',
            'owner' => '🏢',
            'bendahara' => '💰',
            'pelanggan' => '👤',
            default => '❓'
        };
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is owner (manager operasional)
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user is bendahara (financial staff)
     */
    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    /**
     * Check if user is pelanggan (customer/tourist)
     */
    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    /**
     * Check if user is staff (admin, owner, or bendahara)
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'owner', 'bendahara']);
    }

    /**
     * Check if user can manage resources (create/edit/delete Objek, Paket, Penginapan)
     */
    public function canManageResources(): bool
    {
        return in_array($this->role, ['admin', 'owner']);
    }

    /**
     * Check if user can manage payments (verify pembayaran)
     */
    public function canManagePayments(): bool
    {
        return in_array($this->role, ['admin', 'owner', 'bendahara']);
    }

    /**
     * Check if user can create berita
     */
    public function canCreateBerita(): bool
    {
        return in_array($this->role, ['admin', 'owner', 'bendahara']);
    }
}
