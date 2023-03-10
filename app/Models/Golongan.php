<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Golongan extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'golongan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function tarifProgresif()
    {
        return $this->hasOne(TarifProgresif::class)->orderBy('tanggal_berlaku', 'desc');
    }
}
