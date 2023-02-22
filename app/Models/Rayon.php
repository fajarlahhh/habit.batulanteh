<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rayon extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'rayon';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function rayonDetail()
    {
        return $this->hasMany(RayonDetail::class);
    }

    public function ruteBaca()
    {
        return $this->hasONe(RuteBaca::class);
    }
}
