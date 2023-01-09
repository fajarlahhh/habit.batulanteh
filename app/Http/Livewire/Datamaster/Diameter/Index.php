<?php

namespace App\Http\Livewire\Datamaster\Diameter;

use App\Models\Diameter;
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
        Diameter::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function restore()
    {
        Diameter::withTrashed()->findOrFail($this->key)->restore();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.datamaster.diameter.index', [
            'data' => Diameter::with('pengguna')->where(fn($q) => $q->where('ukuran', 'like', '%' . $this->cari . '%'))->when($this->exist == '2', fn($q) => $q->onlyTrashed())->get(),
        ]);
    }
}
