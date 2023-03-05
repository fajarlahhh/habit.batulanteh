<?php

namespace App\Http\Livewire\Masterpelanggan;

use Livewire\Component;
use App\Models\Golongan;
use App\Models\Regional;
use App\Models\Pelanggan;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dataUnitPelayanan, $dataGolongan, $golongan, $cari, $unitPelayanan, $rayon, $status, $key;

    protected $queryString = ['unitPelayanan', 'rayon', 'cari', 'status'];


    public function mount()
    {
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->dataGolongan = Golongan::all();
        $this->cari = $this->cari ?: null;
        $this->unitPelayanan = $this->unitPelayanan ?: null;
        $this->rayon = $this->rayon ?: null;
        $this->golongan = $this->golongan ?: null;
        $this->status = $this->status ?: null;
    }

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
            'data' => Pelanggan::with('pengguna')->with('rayon.kelurahan.kecamatan')->where(fn ($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%'))->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->when($this->status, fn ($q) => $q->where('status', $this->status))->when($this->golongan, fn ($q) => $q->where('golongan_id', $this->golongan))->paginate(10),
        ]);
    }
}
