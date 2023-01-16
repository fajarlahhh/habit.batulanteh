<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BacaMeter extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'baca_meter';

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function rekeningAir()
    {
        return $this->hasOne(RekeningAir::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('periode', function (Builder $builder) {
            $builder->where('periode', '<=', date('Y-m-01'));
        });
    }
}
