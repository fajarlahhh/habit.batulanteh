<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogPembatalanRekAir extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;
    
    protected $table = 'log_pembatalan_rek_air';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function rekeningAir()
    {
        return $this->belongsTo(RekeningAir::class);
    }
}