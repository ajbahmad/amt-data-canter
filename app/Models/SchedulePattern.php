<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchedulePattern extends BaseModel
{
    use SoftDeletes;

    protected $table = 'schedule_patterns';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'school_institution_id',
        'school_level_id',
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function schoolInstitution()
    {
        return $this->belongsTo(SchoolInstitution::class);
    }

    public function schoolLevel()
    {
        return $this->belongsTo(SchoolLevel::class);
    }

    public function schoolDaySchedules()
    {
        return $this->hasMany(SchoolDaySchedule::class);
    }
}
