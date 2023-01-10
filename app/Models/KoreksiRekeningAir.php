<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoreksiRekeningAir extends Model
{
    use HasFactory;

    protected $table = 'koreksi_rekening_air';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function rekeningAir()
    {
        return $this->belongsTo(RekeningAir::class);
    }

    public function golonganLama()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id_lama');
    }

    public function golonganBaru()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id_baru');
    }
}
