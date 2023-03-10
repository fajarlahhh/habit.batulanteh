<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngsuranRekeningAir extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'angsuran_rekening_air';

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function angsuranRekeningAirDetail()
    {
        return $this->hasMany(AngsuranRekeningAirDetail::class);
    }

    public function angsuranRekeningAirPeriode()
    {
        return $this->hasMany(AngsuranRekeningAirPeriode::class);
    }

    public function scopeBelumLunas($query)
    {
        return $query->whereRaw("(select count(*) from angsuran_rekening_air_detail where angsuran_rekening_air.id=angsuran_rekening_air_id and kasir is not null and waktu_bayar is not null) != (select count(*) from angsuran_rekening_air_detail where angsuran_rekening_air.id=angsuran_rekening_air_id)");
    }

    public function scopeLunas($query)
    {
        return $query->whereRaw("(select count(*) from angsuran_rekening_air_detail where angsuran_rekening_air.id=angsuran_rekening_air_id and kasir is not null and waktu_bayar is not null) = (select count(*) from angsuran_rekening_air_detail where angsuran_rekening_air.id=angsuran_rekening_air_id)");
    }

    public function angsuranRekeningAirDetailTerbayar()
    {
        return $this->hasMany(AngsuranRekeningAirDetail::class)->whereNotNull('kasir')->whereNotNull('waktu_bayar');
    }
}
