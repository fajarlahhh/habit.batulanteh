<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ira extends Model
{
    use HasFactory;
    protected $table = 'ira';

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

}
