<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngsuranRekeningAirDetail extends Model
{
    use HasFactory;

    protected $table = 'angsuran_rekening_air_detail';
    public $timestamps = false;

    protected $fillable = [
        'angsuran_rekening_air_id', 'urutan', 'nilai', 'kasir', 'waktu_bayar',
    ];

    public function angsuranRekeningAir()
    {
        return $this->belongsTo(AngsuranRekeningAir::class);
    }

    public function scopeBelumBayar($query)
    {
        return $query->whereNull('kasir')->orWhereNull('waktu_bayar');
    }

    public function scopeSudahBayar($query)
    {
        return $query->whereNotNull('kasir')->whereNotNull('waktu_bayar');
    }
}
