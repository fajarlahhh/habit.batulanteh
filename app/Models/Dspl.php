<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dspl extends Model
{
    use HasFactory;

    protected $table = 'dspl';

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function jalanKelurahan()
    {
        return $this->belongsTo(JalanKelurahan::class);
    }

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }
}
