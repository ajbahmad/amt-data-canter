<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends BaseModel
{
    protected $table = 'roles';

    protected $fillable = [
        'application_id',
        'name',
        'slug',
        'description',
        'scope',
        'school_institution_id',
        'school_level_id',
        'priority',
        'is_system',
        'is_active',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
        'priority' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(SchoolInstitution::class, 'school_institution_id');
    }

    public function schoolLevel(): BelongsTo
    {
        return $this->belongsTo(SchoolLevel::class, 'school_level_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_roles',
            'role_id',
            'user_id'
        )->withPivot('school_institution_id', 'school_level_id', 'assigned_at', 'expires_at')
         ->withTimestamps();
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            Menu::class,
            'menu_permissions',
            'role_id',
            'menu_id'
        )->withPivot('can_view', 'can_create', 'can_edit', 'can_delete', 'can_export', 'can_import');
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    // ============================================================
    // SCOPES
    // ============================================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeGlobal($query)
    {
        return $query->where('scope', 'global');
    }

    public function scopeInstitution($query)
    {
        return $query->where('scope', 'institution');
    }

    public function scopeSchool($query)
    {
        return $query->where('scope', 'school');
    }

    public function scopeForApplication($query, $applicationId)
    {
        return $query->where('application_id', $applicationId);
    }

    public function scopeByInstitution($query, $institutionId)
    {
        return $query->where('school_institution_id', $institutionId);
    }

    public function scopeBySchoolLevel($query, $schoolLevelId)
    {
        return $query->where('school_level_id', $schoolLevelId);
    }
}
