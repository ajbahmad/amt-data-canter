<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * UUID Primary Key Configuration
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Boot method untuk auto-generate UUID saat create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'phone',
        'address',
        'last_login_at'
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
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * User belongs to a role
     */
    // public function role(): BelongsTo
    // {
    //     return $this->belongsTo(Role::class);
    // }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permissionName): bool
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->hasPermission($permissionName);
    }

    /**
     * Check if user has any of the specified permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->permissions()
            ->whereIn('name', $permissions)
            ->exists();
    }

    /**
     * Check if user has all of the specified permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        if (!$this->role) {
            return false;
        }
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get active users only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }
}
