<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diameter extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'diameter';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function tarifMeterAir()
    {
        return $this->hasOne(TarifMeterAir::class)->orderBy('tanggal_berlaku', 'desc');
    }
}
