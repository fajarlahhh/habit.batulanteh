<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuteBaca extends Model
{
    use HasFactory, PenggunaTrait;

    protected $table = 'rute_baca';

    public function pembaca()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function rayon()
    {
        return $this->belongsTo(Rayon::class);
    }
}
