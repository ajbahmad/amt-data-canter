<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'person_id',
        'school_institution_id',
        'student_id',
        'student_code',
        'enrollment_number',
        'enrollment_date',
        'major',
        'entry_year',
        'school_year',
        'status',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'enrollment_date' => 'date',
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
