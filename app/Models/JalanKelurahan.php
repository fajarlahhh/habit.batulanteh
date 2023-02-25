<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JalanKelurahan extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'jalan_kelurahan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class)->withTrashed();
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class)->withTrashed();
    }

    public function rayonDetail()
    {
        return $this->hasOne(RayonDetail::class, 'jalan_kelurahan_id');
    }
}
