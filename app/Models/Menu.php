<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class Menu extends BaseModel
{
    /**
     * Tabel yang digunakan model
     */
    protected $table = 'menus';

    /**
     * Primary key menggunakan UUID
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Attributes yang bisa di-assign mass
     */
    protected $fillable = [
        'parent_id',
        'type',
        'title',
        'icon',
        'color',
        'menu_key',
        'route',
        'url',
        'order_no',
        'description',
        'badge',
        'badge_color',
        'is_active',
    ];

    /**
     * Casting untuk attributes
     */
    protected $casts = [
        'order_no' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * ============================================================
     * RELATIONSHIPS
     * ============================================================
     */

    /**
     * Menu parent (self-relation)
     * Untuk submenu, relasi ke parent menu
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    /**
     * Children menu (self-relation)
     * Untuk dropdown menu, menampilkan semua submenu
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')
            ->where('is_active', true)
            ->orderBy('order_no');
    }

    /**
     * Recursive children (untuk load seluruh tree)
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Menu permissions
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(MenuPermission::class, 'menu_id', 'id');
    }

    /**
     * ============================================================
     * SCOPES
     * ============================================================
     */

    /**
     * Scope untuk hanya active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk hanya root menus (no parent)
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope untuk hanya dropdown menus
     */
    public function scopeDropdowns($query)
    {
        return $query->where('type', 'dropdown');
    }

    /**
     * Scope untuk hanya item menus
     */
    public function scopeItems($query)
    {
        return $query->where('type', 'item');
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeForRole($query, $roleCode)
    {
        return $query->whereDoesntHave('permissions', function ($q) use ($roleCode) {
            $q->where('role_code', '!=', $roleCode);
        })->orWhereDoesntHave('permissions');
    }

    /**
     * ============================================================
     * ACCESSORS & MUTATORS
     * ============================================================
     */

    /**
     * Get URL dari route atau url manual
     */
    public function getUrlAttribute(): ?string
    {
        if ($this->route) {
            return route($this->route);
        }
        return $this->attributes['url'] ?? null;
    }

    /**
     * Check apakah menu adalah dropdown
     */
    public function isDropdown(): bool
    {
        return $this->type === 'dropdown';
    }

    /**
     * Check apakah menu adalah item
     */
    public function isItem(): bool
    {
        return $this->type === 'item';
    }

    /**
     * Check apakah menu punya children
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * ============================================================
     * METHODS
     * ============================================================
     */

    /**
     * Get menu tree dengan children (recursive)
     */
    public static function getMenuTree($activeOnly = true)
    {
        $query = self::roots();

        if ($activeOnly) {
            $query->active();
        }

        return $query->with('childrenRecursive')
            ->orderBy('order_no')
            ->get();
    }

    /**
     * Get menu tree dengan filtering berdasarkan role
     */
    public static function getMenuTreeForRole($roleCode, $activeOnly = true)
    {
        $query = self::roots();

        if ($activeOnly) {
            $query->active();
        }

        return $query->with([
            'childrenRecursive' => function ($q) {
                $q->where('is_active', true)
                    ->orderBy('order_no');
            }
        ])
        ->whereDoesntHave('permissions', function ($q) use ($roleCode) {
            $q->where('role_code', '!=', $roleCode)->where('can_view', false);
        })
        ->orderBy('order_no')
        ->get();
    }

    /**
     * Get semua menu (flat) untuk kebutuhan select dropdown
     */
    public static function getAllForSelect()
    {
        return self::active()
            ->orderBy('order_no')
            ->pluck('title', 'id');
    }

    /**
     * Format menu sebagai array untuk frontend
     */
    public function toMenuArray(): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'title' => $this->title,
            'icon' => $this->icon,
            'color' => $this->color,
            'menu_key' => $this->menu_key,
            'route' => $this->route,
            'url' => $this->url,
            'order_no' => $this->order_no,
            'description' => $this->description,
            'badge' => $this->badge,
            'badge_color' => $this->badge_color,
            'is_active' => $this->is_active,
            'children' => $this->children->map->toMenuArray()->toArray(),
        ];
    }
}
