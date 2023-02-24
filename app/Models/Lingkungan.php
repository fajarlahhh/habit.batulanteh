<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lingkungan extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'lingkungan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class)->withTrashed();
    }

    public function jalanLingkungan()
    {
        return $this->hasMany(JalanLingkungan::class);
    }
}
