<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerbitanRekAirManual extends Model
{
   use HasFactory, HasEagerLimit;

    protected $table = 'penerbitan_rek_air_manual';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id')->withTrashed();
    }

    public function tarifDenda()
    {
        return $this->belongsTo(TarifDenda::class)->withTrashed();
    }

    public function tarifLainnya()
    {
        return $this->belongsTo(TarifLainnya::class)->withTrashed();
    }

    public function tarifMeterAir()
    {
        return $this->belongsTo(TarifMeterAir::class)->withTrashed();
    }

    public function tarifProgresif()
    {
        return $this->belongsTo(TarifProgresif::class)->withTrashed();
    }

    public function bacaMeter()
    {
        return $this->belongsTo(BacaMeter::class);
    }
}
