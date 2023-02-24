<?php

namespace App\Http\Livewire\Datamaster\Regional\Kelurahan;

use App\Models\Kelurahan;
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
        Kelurahan::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        Kelurahan::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.regional.kelurahan.index', [
            'data' => Kelurahan::with('pengguna')->with('jalanKelurahan.jalan')->with('kecamatan')->where(fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}
