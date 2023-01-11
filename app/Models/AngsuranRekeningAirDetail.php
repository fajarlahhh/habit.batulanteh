<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngsuranRekeningAirDetail extends Model
{
    use HasFactory;

    protected $table = 'angsuran_rekening_air_detail';

    protected $fillable = [
        'angsuran_rekening_air_id', 'urutan', 'nilai', 'kasir_id', 'waktu_bayar',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'kasir_id');
    }

    public function angsuranRekeningAir()
    {
        return $this->belongsTo(AngsuranRekeningAir::class);
    }

    public function scopeBelumBayar($query)
    {
        return $query->whereNull('kasir_id')->orWhereNull('waktu_bayar');
    }

    public function scopeSudahBayar($query)
    {
        return $query->whereNotNull('kasir_id')->whereNotNull('waktu_bayar');
    }
}
