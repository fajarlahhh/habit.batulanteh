<?php

namespace App\Http\Livewire\Datamaster\MerkWaterMeter;

use App\Models\MerkWaterMeter;
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
        MerkWaterMeter::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        MerkWaterMeter::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.merkwatermeter.index', [
            'data' => MerkWaterMeter::with('pengguna')->where(fn($q) => $q->where('merk', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}
