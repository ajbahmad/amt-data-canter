<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends BaseModel
{
    use HasUuids;

    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postal_code',
        'gender',
        'birth_date',
        'birth_place',
        'identity_number',
        'photo',
        'school_institution_id',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Get age from birth date
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }
        return $this->birth_date->diffInYears(now());
    }

    /**
     * Get all person type memberships
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(PersonTypeMembership::class);
    }

    /**
     * Get school institution
     */
    public function schoolInstitution()
    {
        return $this->belongsTo(SchoolInstitution::class);
    }

    /**
     * Get all person types through memberships
     */
    public function personTypes(): BelongsToMany
    {
        return $this->belongsToMany(PersonType::class, 'person_type_memberships')
                    ->withPivot('joined_date', 'left_date', 'is_active')
                    ->withTimestamps();
    }

    /**
     * Get student record if exists
     */
    public function student(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get teacher record if exists
     */
    public function teacher(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Get staff record if exists
     */
    public function staff(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Staff::class);
    }
}
