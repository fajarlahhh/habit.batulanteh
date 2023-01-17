<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifPelayananSangsi extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'tarif_pelayanan_sangsi';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function diameter()
    {
        return $this->belongsTo(Diameter::class)->withTrashed();
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class)->withTrashed();
    }
}
