<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifMeterAirDetail extends Model
{
    use HasFactory;

    protected $table = 'tarif_meter_air_detail';

    protected $fillable = [
        'tarif_meter_air_id', 'jenis', 'nilai',
    ];
}
