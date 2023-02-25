<?php

namespace App\Http\Livewire\Masterpelanggan;

use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $cari, $status = '0', $key;

    protected $queryString = ['cari', 'status'];

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
        Pelanggan::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function render()
    {
        return view('livewire.masterpelanggan.index', [
            'data' => Pelanggan::with('pengguna')->with('jalanKelurahan.rayonDetail.rayon')->with('jalanKelurahan.jalan')->with('jalanKelurahan.kelurahan.kecamatan')->where(fn ($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%'))->when($this->status != '0', fn ($q) => $q->where('status', $this->status))->paginate(10),
        ]);
    }
}
