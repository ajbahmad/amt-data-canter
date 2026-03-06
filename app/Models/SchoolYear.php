<?php

namespace App\Models;

class SchoolYear extends BaseModel
{
    protected $table = 'school_years';

    protected $fillable = [
        'school_institution_id',
        'school_level_id',
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

    // public function getNameAttribute($value)
    // {
    //     return $value . ' : ' . ($this->schoolLevel->code ?? '-');
    // }

    /**
     * Relationships
     */

    // Relasi ke school_institution (many-to-one)
    public function schoolInstitution()
    {
        return $this->belongsTo(SchoolInstitution::class, 'school_institution_id');
    }

    // relasi ke school_level (many-to-one)
    public function schoolLevel()
    {
        return $this->belongsTo(SchoolLevel::class, 'school_level_id');
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
