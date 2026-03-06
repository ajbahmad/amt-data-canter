<?php

namespace App\Models;

class SchoolLevel extends BaseModel
{
    protected $table = 'school_levels';

    protected $fillable = [
        'school_institution_id',
        'code',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    
    // Relasi ke school_institution (many-to-one)
    public function schoolInstitution()
    {
        return $this->belongsTo(SchoolInstitution::class, 'school_institution_id');
    }

    // Relasi ke grades (tingkat kelas)
    public function grades()
    {
        return $this->hasMany(Grade::class, 'school_level_id');
    }

    // Relasi ke subjects (mata pelajaran)
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'school_level_id');
    }
}
