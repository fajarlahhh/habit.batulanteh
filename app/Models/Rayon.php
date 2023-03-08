<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rayon extends Model
{
    use HasFactory, PenggunaTrait, SoftDeletes;

    protected $table = 'rayon';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function pembaca()
    {
        return $this->belongsTo(Pengguna::class, 'pembaca_id');
    }
}
