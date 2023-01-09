<?php

namespace App\Http\Livewire\Datamaster\Tarif\Denda;

use App\Models\TarifDenda;
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
        TarifDenda::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        TarifDenda::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.denda.index', [
            'data' => TarifDenda::with('pengguna')->where(fn($q) => $q->where('sk', 'like', '%' . $this->cari . '%')->orWhere('keterangan', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->orderBy('tanggal_berlaku', 'desc')->get(),
        ]);
    }
}
