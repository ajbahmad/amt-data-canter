<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class IdCard extends BaseModel
{
    use SoftDeletes;

    protected $table = 'id_cards';

    protected $fillable = [
        'card_uid',
        'card_number',
        'person_id',
        'status',
        'issued_at',
        'expired_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function history()
    {
        return $this->hasMany(CardHistory::class);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => 'Aktif',
            'lost' => 'Hilang',
            'blocked' => 'Diblokir',
            'expired' => 'Expired',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => 'badge-success',
            'lost' => 'badge-danger',
            'blocked' => 'badge-warning',
            'expired' => 'badge-secondary',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByPerson($query, $personId)
    {
        return $query->where('person_id', $personId);
    }
}
