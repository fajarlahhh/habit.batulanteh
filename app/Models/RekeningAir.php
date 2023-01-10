<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningAir extends Model
{
    use HasFactory;

    protected $table = 'rekening_air';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class)->withTrashed();
    }

    public function kasir()
    {
        return $this->belongsTo(Pengguna::class, 'kasir_id')->withTrashed();
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

    public function angsuranRekeningAirPeriode()
    {
        return $this->hasOne(AngsuranRekeningAirPeriode::class);
    }

    public function scopeSudahBayar($query)
    {
        return $query->whereNotNull('kasir_id')->whereNotNull('waktu_bayar');
    }

    public function scopeBelumBayar($query)
    {
        return $query->whereNull('kasir_id')->orWhereNull('waktu_bayar');
    }

    public function scopeBelumDiangsur($query)
    {
        return $query->whereDoesntHave('angsuranRekeningAirPeriode');
    }
}
