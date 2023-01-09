<?php

namespace App\Http\Livewire\Datamaster\Golongan;

use App\Models\Golongan;
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
        Golongan::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        Golongan::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.golongan.index', [
            'data' => Golongan::with('pengguna')->where(fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}
