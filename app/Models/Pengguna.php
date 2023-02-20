<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    public function ruteBaca()
    {
        return $this->hasMany(RuteBaca::class, 'pembaca_id');
    }

    public function scopePembaca($query)
    {
        return $query->whereHas('ruteBaca');
    }

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}
