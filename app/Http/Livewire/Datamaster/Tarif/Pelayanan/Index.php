<?php

namespace App\Http\Livewire\Datamaster\Tarif\Pelayanan;

use App\Models\TarifPelayananSangsi;
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
        TarifPelayananSangsi::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        TarifPelayananSangsi::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.pelayanan.index', [
            'data' => TarifPelayananSangsi::with('pengguna')->where(fn($q) => $q->where('jenis', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->orderBy('jenis', 'asc')->get(),
        ]);
    }
}
