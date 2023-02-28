<?php

namespace App\Http\Livewire\Datamaster\Statusbaca;

use App\Models\StatusBaca;
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
        StatusBaca::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        StatusBaca::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.statusbaca.index', [
            'data' => StatusBaca::where(fn($q) => $q->where('keterangan', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}
