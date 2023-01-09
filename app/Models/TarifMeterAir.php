<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifMeterAir extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'tarif_meter_air';

    public function tarifMeterAirDetail()
    {
        return $this->hasMany(TarifMeterAirDetail::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function diameter()
    {
        return $this->belongsTo(Diameter::class);
    }
}
