<?php

namespace App\Models;

class SchoolInstitution extends BaseModel
{
    protected $table = 'school_institutions';

    protected $fillable = [
        'code',
        'name',
        'npsn',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
