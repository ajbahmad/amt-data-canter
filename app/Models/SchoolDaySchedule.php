<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolDaySchedule extends BaseModel
{
    use SoftDeletes;

    protected $table = 'school_day_schedules';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'schedule_pattern_id',
        'school_institution_id',
        'school_level_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_holiday',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_holiday' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function schedulePattern()
    {
        return $this->belongsTo(SchedulePattern::class);
    }

    public function schoolInstitution()
    {
        return $this->belongsTo(SchoolInstitution::class);
    }

    public function schoolLevel()
    {
        return $this->belongsTo(SchoolLevel::class);
    }

    // Accessors
    public function getDayNameAttribute()
    {
        $days = [
            0 => 'Senin',
            1 => 'Selasa',
            2 => 'Rabu',
            3 => 'Kamis',
            4 => 'Jumat',
            5 => 'Sabtu',
            6 => 'Minggu',
        ];

        return $days[$this->day_of_week] ?? 'Unknown';
    }
}
