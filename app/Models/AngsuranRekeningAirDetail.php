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
}
