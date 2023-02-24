<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'kecamatan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function unitPelayanan()
    {
        return $this->belongsTo(UnitPelayanan::class)->withTrashed();
    }

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class);
    }
}
