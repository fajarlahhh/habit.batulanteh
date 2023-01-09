<?php

namespace App\Http\Livewire\Datamaster\Tarif\Progresif;

use App\Models\TarifProgresif;
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
        TarifProgresif::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        TarifProgresif::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.progresif.index', [
            'data' => TarifProgresif::with('pengguna')->with('tarifProgresifDetail')->where(fn($q) => $q->where('sk', 'like', '%' . $this->cari . '%')->orWhere('sk', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->orderBy('tanggal_berlaku', 'desc')->get(),
        ]);
    }
}
