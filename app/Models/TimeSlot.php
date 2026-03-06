<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeSlot extends BaseModel
{
    use HasUuids;

    protected $table = 'time_slots';

    protected $fillable = [
        'school_institution_id',
        'school_level_id',
        'name',
        'start_time',
        'end_time',
        'order_no',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
}
