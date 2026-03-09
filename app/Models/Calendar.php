<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calendar extends BaseModel
{
    use HasUuids;

    protected $table = 'calendars';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'type',
        'is_holiday',
        'color',
    ];

    protected $casts = [
        'is_holiday' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get all calendar scopes for this calendar
     */
    public function scopes(): HasMany
    {
        return $this->hasMany(CalendarScope::class);
    }

    /**
     * Check if calendar is a holiday
     */
    public function isHoliday(): bool
    {
        return $this->is_holiday || $this->type === 'holiday';
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute(): string
    {
        if ($this->end_date && $this->end_date !== $this->start_date) {
            return $this->start_date->format('d/m/Y') . ' - ' . $this->end_date->format('d/m/Y');
        }
        return $this->start_date->format('d/m/Y');
    }
}
