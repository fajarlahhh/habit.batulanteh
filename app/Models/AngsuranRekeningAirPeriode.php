<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngsuranRekeningAirPeriode extends Model
{
    use HasFactory;

    protected $table = 'angsuran_rekening_air_periode';

    protected $fillable = [
        'rekening_air_id', 'angsuran_rekening_air_id',
    ];

    public function rekeningAir()
    {
        return $this->belongsTo(RekeningAir::class);
    }
}
