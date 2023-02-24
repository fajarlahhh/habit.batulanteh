<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jalan extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'jalan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function jalanLingkungan()
    {
        return $this->hasMany(JalanLingkungan::class, 'jalan_id');
    }
}
