<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class Pengguna extends Authenticatable
{
    use SoftDeletes, Notifiable, HasRoles;

    protected $table = 'pengguna';
    protected $rememberTokenName = 'remember_token';

    protected $fillable = [
        'uid', 'kata_sandi',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    public function scopePembaca($query)
    {
        return $query->where('bacameter', 1);
    }

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }


    public function bacaMeter()
    {
        return $this->hasMany(BacaMeter::class, 'pembaca_id')->select('id', 'pembaca_id', DB::raw('date(tanggal_baca) tanggal_baca'));
    }

    public function unitPelayanan()
    {
        return $this->belongsTo(UnitPelayanan::class);
    }
}
