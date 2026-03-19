<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'person_id',
        'is_active',
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

    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_roles',
            'user_id',
            'role_id'
        )->withPivot('school_institution_id', 'school_level_id', 'assigned_at', 'expires_at')
          ->withTimestamps();
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(
            SchoolInstitution::class,
            'institution_users',
            'user_id',
            'school_institution_id'
        )->withPivot('role_code', 'joined_at', 'left_at', 'is_active');
    }

    public function schoolLevels(): BelongsToMany
    {
        return $this->belongsToMany(
            SchoolLevel::class,
            'school_level_users',
            'user_id',
            'school_level_id'
        )->withPivot('role_code', 'assigned_at', 'unassigned_at', 'is_active');
    }

    // ============================================================
    // METHODS
    // ============================================================

    /**
     * Get roles for specific application
     */
    public function getRolesForApplication($application): \Illuminate\Support\Collection
    {
        $appId = $application instanceof Application ? $application->id : $application;

        return $this->roles()
            ->where('roles.application_id', $appId)
            ->select('roles.id', 'roles.name', 'roles.slug')
            ->get();
    }

    public function person()
    {
        return $this->belongsTo(Person::class);    
    }

    /**
     * Check if user has any of the specified permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if (!isset($this->role)) {
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
        if (!isset($this->role)) {
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
