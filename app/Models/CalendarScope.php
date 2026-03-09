<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarScope extends BaseModel
{
    use HasUuids;

    protected $table = 'calendar_scopes';

    protected $fillable = [
        'calendar_id',
        'school_institution_id',
        'school_level_id',
        'class_room_id',
    ];

    /**
     * Get the calendar this scope belongs to
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * Get the school institution
     */
    public function schoolInstitution(): BelongsTo
    {
        return $this->belongsTo(SchoolInstitution::class);
    }

    /**
     * Get the school level
     */
    public function schoolLevel(): BelongsTo
    {
        return $this->belongsTo(SchoolLevel::class);
    }

    /**
     * Get the class room
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * Get scope description based on hierarchy
     */
    public function getScopeDescriptionAttribute(): string
    {
        if ($this->class_room_id) {
            return $this->classRoom->name ?? 'Class';
        }
        if ($this->school_level_id) {
            return $this->schoolLevel->name ?? 'Level';
        }
        if ($this->school_institution_id) {
            return $this->schoolInstitution->name ?? 'Institution';
        }
        return 'Global';
    }
}
