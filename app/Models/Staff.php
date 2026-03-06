<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Staff extends BaseModel
{
    use HasUuids;

    protected $table = 'staffs';

    protected $fillable = [
        'person_id',
        'school_institution_id',
        'staff_id',
        'position',
        'department',
        'hire_date',
        'employment_type',
        'status',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the person
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the school institution
     */
    public function schoolInstitution(): BelongsTo
    {
        return $this->belongsTo(SchoolInstitution::class);
    }
}
