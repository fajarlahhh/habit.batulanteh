<?php

namespace App\Http\Livewire\Pengaturan\Pengguna;

use App\Models\Pengguna;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $cari, $exist = 1, $key;

    protected $queryString = ['cari', 'exist'];
    protected $paginationTheme = 'bootstrap';

    public function setKey($key = null)
    {
        $this->key = $key;
    }

    public function hapus()
    {
        if ($this->key != 1) {
            Pengguna::findOrFail($this->key)->delete();
            $this->reset(['key']);
        }
    }

    public function restore()
    {
        Pengguna::withTrashed()->findOrFail($this->key)->restore();
        $this->reset(['key']);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.pengaturan.pengguna.index', [
            'data' => Pengguna::with('unitPelayanan')->when($this->exist == '2', fn($q) => $q->onlyTrashed())->where(fn($q) => $q->where('uid', 'like', '%' . $this->cari . '%')->orWhere('nama', 'like', '%' . $this->cari . '%'))->orderBy('uid')->paginate(10),
            'no' => ($this->page - 1) * 10,
        ]);
    }
}
