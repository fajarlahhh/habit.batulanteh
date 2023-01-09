<?php

namespace App\Http\Livewire\Datamaster\Tarif\Meterair;

use App\Models\TarifMeterAir;
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
        TarifMeterAir::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        TarifMeterAir::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.meterair.index', [
            'data' => TarifMeterAir::with('pengguna')->with('tarifMeterAirDetail')->where(fn($q) => $q->where('keterangan', 'like', '%' . $this->cari . '%')->orWhere('sk', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->orderBy('tanggal_berlaku', 'desc')->get(),
        ]);
    }
}
