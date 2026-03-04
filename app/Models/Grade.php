<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends BaseModel
{
    protected $fillable = [
        'school_institution_id',
        'school_level_id',
        'name',
        'order_no',
        'is_active',
    ];

    protected $casts = [
        'order_no' => 'integer',
        'is_active' => 'boolean',
    ];

    public function schoolInstitution(): BelongsTo
    {
        return $this->belongsTo(SchoolInstitution::class);
    }

    public function schoolLevel(): BelongsTo
    {
        return $this->belongsTo(SchoolLevel::class);
    }

    public function classRooms(): HasMany
    {
        return $this->hasMany(ClassRoom::class);
    }
}
