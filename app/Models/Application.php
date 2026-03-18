<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Application extends BaseModel
{
    protected $table = 'applications';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_url',
        'website_url',
        'api_base_url',
        'api_client_id',
        'api_client_secret_hash',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================================
    // RELATIONSHIPS
    // ============================================================

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    // public function permissions(): HasMany
    // {
    //     return $this->hasMany(MenuPermission::class);
    // }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    // ============================================================
    // SCOPES
    // ============================================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
