<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'pelanggan';

    protected $fillable = [
        'no_body_water_meter',
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function tarifLainnya()
    {
        return $this->belongsTo(TarifLainnya::class);
    }

    public function diameter()
    {
        return $this->belongsTo(Diameter::class);
    }

    public function angsuranRekeningAir()
    {
        return $this->hasMany(AngsuranRekeningAir::class);
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }

    public function merkWaterMeter()
    {
        return $this->belongsTo(MerkWaterMeter::class);
    }

    public function pembaca()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function bacaMeter()
    {
        return $this->hasMany(BacaMeter::class)->orderBy('periode', 'asc');
    }

    public function bacaMeterTerakhir()
    {
        return $this->hasOne(BacaMeter::class)->orderBy('periode', 'desc');
    }
}
