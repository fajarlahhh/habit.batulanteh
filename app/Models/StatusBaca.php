<?php

namespace App\Models;

use App\Traits\PenggunaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusBaca extends Model
{
    use HasFactory, SoftDeletes, PenggunaTrait;

    protected $table = 'status_baca';
}
