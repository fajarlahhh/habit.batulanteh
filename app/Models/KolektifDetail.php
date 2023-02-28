<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolektifDetail extends Model
{
    use HasFactory;

    protected $table = 'kolektif_detail';

    protected $fillable = [
        'kolektif_id', 'pelanggan_id',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function kolektif()
    {
        return $this->belongsTo(Kolektif::class);
    }
}
