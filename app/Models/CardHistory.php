<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardHistory extends BaseModel
{
    protected $table = 'card_history';

    protected $fillable = [
        'id_card_id',
        'person_id',
        'action',
        'notes',
    ];

    /**
     * Relationships
     */
    public function idCard()
    {
        return $this->belongsTo(IdCard::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Accessors
     */
    public function getActionLabelAttribute()
    {
        $labels = [
            'issued' => 'Dikeluarkan',
            'blocked' => 'Diblokir',
            'lost' => 'Hilang',
            'replaced' => 'Diganti',
            'unblocked' => 'Deblokir',
            'expired' => 'Expired',
        ];

        return $labels[$this->action] ?? $this->action;
    }

    /**
     * Scopes
     */
    public function scopeByIdCard($query, $idCardId)
    {
        return $query->where('id_card_id', $idCardId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
