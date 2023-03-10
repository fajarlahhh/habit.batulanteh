<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelurahan extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'kelurahan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class)->withTrashed();
    }

    public function rayon()
    {
        return $this->hasOne(Rayon::class);
    }
}
