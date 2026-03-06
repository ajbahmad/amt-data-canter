<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonTypeMembership extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'person_id',
        'person_type_id',
        'joined_date',
        'left_date',
        'is_active'
    ];

    protected $casts = [
        'joined_date' => 'date',
        'left_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the person
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the person type
     */
    public function personType(): BelongsTo
    {
        return $this->belongsTo(PersonType::class);
    }
}
