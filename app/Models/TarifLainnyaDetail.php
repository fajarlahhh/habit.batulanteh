<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifMeterAirDetail extends Model
{
    use HasFactory;

    protected $table = 'tarif_lainnya_detail';

    protected $fillable = [
        'tarif_lainnya_id', 'jenis', 'nilai',
    ];
}
