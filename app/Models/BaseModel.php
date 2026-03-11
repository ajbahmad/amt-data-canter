<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

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

        $instance = new static();
        $table = $instance->getTable();

        if (Schema::hasColumn($table, 'is_active')) {
            if (!app()->runningInConsole()) {
                static::creating(function ($model) {
                    $model->is_active = request()->is_active ? true : false;
                });
                static::updating(function ($model) {
                    $model->is_active = request()->is_active ? true : false;
                });
            }

            static::addGlobalScope('is_active', function ($query) {
                $query->where('is_active', true);
            });
        }

        // filter school_institution
        if (
            request()->school_institution_id &&
            Schema::hasColumn($table, 'school_institution_id')
        ) {
            $schoolInstitutionId = request()->school_institution_id;

            static::addGlobalScope('school_institution', function ($query) use ($schoolInstitutionId) {
                $query->where('school_institution_id', $schoolInstitutionId);
            });
        }

        // filter school_level
        if (
            request()->school_level_id &&
            Schema::hasColumn($table, 'school_level_id')
        ) {
            $schoolLevelId = request()->school_level_id;

            static::addGlobalScope('school_level', function ($query) use ($schoolLevelId) {
                $query->where('school_level_id', $schoolLevelId);
            });
        }
    }
    

    /**
     * Scope Active
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
