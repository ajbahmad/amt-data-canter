<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'person_id',
        'school_institution_id',
        'teacher_id',
        'certification_number',
        'hire_date',
        'employment_type',
        'status',
        'specialization',
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

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function teacherSubjectAssignments(): HasMany
    {
        return $this->hasMany(TeacherSubjectAssignment::class);
    }

    /**
     * Get the school institution
     */
    public function schoolInstitution(): BelongsTo
    {
        return $this->belongsTo(SchoolInstitution::class);
    }
}
