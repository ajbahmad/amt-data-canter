<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Base Model Class
 * 
 * Semua model di aplikasi ini sebaiknya inherit dari class ini
 * untuk konsistensi penggunaan UUID sebagai primary key
 */
class BaseModel extends Model
{
    /**
     * UUID Primary Key Configuration
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Boot method untuk auto-generate UUID saat create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
