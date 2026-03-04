<?php

namespace App\Models;

class SchoolYear extends BaseModel
{
    protected $table = 'school_years';

    protected $fillable = [
        'school_institution_id',
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getNameAttribute($value)
    {
        return $value . ' : ' . ($this->schoolInstitution->name ?? '-');
    }

    /**
     * Relationships
     */

    // Relasi ke school_institution (many-to-one)
    public function schoolInstitution()
    {
        return $this->belongsTo(SchoolInstitution::class, 'school_institution_id');
    }

    // Relasi ke semesters (one-to-many)
    public function semesters()
    {
        return $this->hasMany(Semester::class, 'school_year_id');
    }

    // Relasi ke classrooms (one-to-many)
    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'school_year_id');
    }
}
