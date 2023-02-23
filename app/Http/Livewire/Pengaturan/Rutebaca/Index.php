<?php

namespace App\Http\Livewire\Pengaturan\Rutebaca;

use App\Models\Pengguna;
use Livewire\Component;
use App\Models\RuteBaca;

class Index extends Component
{
    public $cari, $exist = 1, $key;

    protected $queryString = ['cari', 'exist'];

    public function setKey($key = null)
    {
        $this->key = $key;
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function hapus()
    {
        RuteBaca::where('pembaca_id', $this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        RuteBaca::withTrashed()->where('pembaca_id', $this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.pengaturan.rutebaca.index', [
            'data' => Pengguna::pembaca()->with('ruteBaca')->with('ruteBaca')->where(fn ($q) => $q->where('uid', 'like', '%' . $this->cari . '%')->orWhere('nama', 'like', '%' . $this->cari . '%'))->get(),
        ]);
    }
}
