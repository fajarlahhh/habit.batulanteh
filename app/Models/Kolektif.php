<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kolektif extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'kolektif';

    public function kolektifDetail()
    {
        return $this->hasMany(KolektifDetail::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class)->withTrashed();
    }
}
