<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifDenda extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'tarif_denda';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }
}
