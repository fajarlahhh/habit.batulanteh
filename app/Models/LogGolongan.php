<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogGolongan extends Model
{
    use HasFactory, PenggunaTrait;
    
    protected $table = 'log_golongan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function golonganLama()
    {
        return $this->belongsTo(RekeningAir::class, 'golongan_id_lama');
    }

    public function golonganBaru()
    {
        return $this->belongsTo(RekeningAir::class, 'golongan_id_baru');
    }
}
