<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RayonDetail extends Model
{
    use HasFactory;

    protected $table = 'rayon_detail';
    public $timestamps = false;

    protected $fillable = [
        'rayon_id', 'jalan_id'
    ];

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }
}
