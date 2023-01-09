<?php

namespace App\Traits;

/**
 *
 */
trait PenggunaTrait
{
    public static function bootPenggunaTrait()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->pengguna_id = auth()->id();
            });
            static::updating(function ($model) {
                $model->pengguna_id = auth()->id();
            });
        }
    }
}
