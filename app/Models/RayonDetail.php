<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RayonDetail extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'rayon_detail';

    protected $fillable = [
        'rayon_id', 'jalan_id'
    ];

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }

    public function jalanKelurahan()
    {
        return $this->belongsTo(JalanKelurahan::class);
    }
}
