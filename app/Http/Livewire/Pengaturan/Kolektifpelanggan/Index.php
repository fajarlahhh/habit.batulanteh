<?php

namespace App\Http\Livewire\Pengaturan\Kolektifpelanggan;

use App\Models\Kolektif;
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
        Kolektif::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        Kolektif::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.pengaturan.kolektifpelanggan.index', [
            'data' => Kolektif::with('kolektifDetail.pelanggan')->where(fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}
