<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JalanLingkungan extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'jalan_lingkungan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function jalan()
    {
        return $this->belongsTo(Jalan::class)->withTrashed();
    }

    public function lingkungan()
    {
        return $this->belongsTo(Lingkungan::class)->withTrashed();
    }
}
