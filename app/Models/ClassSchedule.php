<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassSchedule extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'school_institution_id',
        'school_level_id',
        'class_room_id',
        'teacher_id',
        'subject_id',
        'semester_id',
        'day_of_week',
        'start_time_slot_id',
        'end_time_slot_id',
    ];

    protected static function booted()
    {
        parent::boot();
        if ($school_institution_id = request()->school_institution_id) {
            static::addGlobalScope('school_institution', function ($query) use ($school_institution_id) {
                $query->where('school_institution_id', $school_institution_id);
            });
        }
        if ($school_level_id = request()->school_level_id) {
            static::addGlobalScope('school_level', function ($query) use ($school_level_id) {
                $query->where('school_level_id', $school_level_id);
            });
        }
    }

    protected $casts = [
        'day_of_week' => 'integer',
    ];

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
     * Get the classroom
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * Get the teacher
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the start time slot
     */
    public function startTimeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class, 'start_time_slot_id');
    }

    /**
     * Get the end time slot
     */
    public function endTimeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class, 'end_time_slot_id');
    }

    /**
     * Get the semester
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get day name
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        return $days[$this->day_of_week] ?? '';
    }
}
