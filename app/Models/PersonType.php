<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonType extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'school_institution_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the school institution that owns this person type
     */
    public function schoolInstitution(): BelongsTo
    {
        return $this->belongsTo(SchoolInstitution::class);
    }

    /**
     * Get all person type memberships for this type
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(PersonTypeMembership::class);
    }

    /**
     * Get all persons through memberships
     */
    public function persons(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_type_memberships')
                    ->withPivot('joined_date', 'left_date', 'is_active')
                    ->withTimestamps();
    }
}
