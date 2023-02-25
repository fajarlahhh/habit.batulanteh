<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory;

    protected $table = 'regional';

    public function rayonDetail()
    {
        return $this->hasOne(RayonDetail::class, 'jalan_kelurahan_id');
    }
}
