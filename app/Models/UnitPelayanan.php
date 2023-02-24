<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitPelayanan extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'unit_pelayanan';

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
}
