<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifProgresifDetail extends Model
{
    use HasFactory;

    protected $table = 'tarif_progresif_detail';

    protected $fillable = [
        'tarif_progresif_id', 'min_pakai', 'max_pakai', 'nilai',
    ];
}
