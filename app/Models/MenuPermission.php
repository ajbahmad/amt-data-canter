<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuPermission extends BaseModel
{
    /**
     * Tabel yang digunakan model
     */
    protected $table = 'menu_permissions';

    /**
     * Primary key menggunakan UUID
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Attributes yang bisa di-assign mass
     */
    protected $fillable = [
        'menu_id',
        'role_code',
        'can_view',
        'can_create',
        'can_edit',
        'can_delete',
    ];

    /**
     * Casting untuk attributes
     */
    protected $casts = [
        'can_view' => 'boolean',
        'can_create' => 'boolean',
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
    ];

    /**
     * ============================================================
     * RELATIONSHIPS
     * ============================================================
     */

    /**
     * Relasi ke Menu
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    /**
     * ============================================================
     * SCOPES
     * ============================================================
     */

    /**
     * Scope untuk filter berdasarkan role code
     */
    public function scopeForRole($query, $roleCode)
    {
        return $query->where('role_code', $roleCode);
    }

    /**
     * Scope untuk hanya permission yang bisa view
     */
    public function scopeCanView($query)
    {
        return $query->where('can_view', true);
    }

    /**
     * Scope untuk hanya permission yang bisa create
     */
    public function scopeCanCreate($query)
    {
        return $query->where('can_create', true);
    }

    /**
     * Scope untuk hanya permission yang bisa edit
     */
    public function scopeCanEdit($query)
    {
        return $query->where('can_edit', true);
    }

    /**
     * Scope untuk hanya permission yang bisa delete
     */
    public function scopeCanDelete($query)
    {
        return $query->where('can_delete', true);
    }

    /**
     * ============================================================
     * METHODS
     * ============================================================
     */

    /**
     * Check apakah role memiliki akses view
     */
    public function canView(): bool
    {
        return $this->can_view;
    }

    /**
     * Check apakah role memiliki akses create
     */
    public function canCreate(): bool
    {
        return $this->can_create;
    }

    /**
     * Check apakah role memiliki akses edit
     */
    public function canEdit(): bool
    {
        return $this->can_edit;
    }

    /**
     * Check apakah role memiliki akses delete
     */
    public function canDelete(): bool
    {
        return $this->can_delete;
    }
}
