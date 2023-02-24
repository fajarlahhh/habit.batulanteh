<?php

namespace App\Http\Livewire\Datamaster\Regional\Rayon;

use App\Models\Rayon;
use Livewire\Component;

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
        Rayon::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        Rayon::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.regional.rayon.index', [
            'data' => Rayon::with('pengguna')->with('rayonDetail.jalanKelurahan.kelurahan')->with('rayonDetail.jalanKelurahan.jalan')->where(fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}