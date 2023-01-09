<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifProgresif extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'tarif_progresif';

    public function tarifProgresifDetail()
    {
        return $this->hasMany(TarifProgresifDetail::class)->orderBy('min_pakai', 'asc');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
