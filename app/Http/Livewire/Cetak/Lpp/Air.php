<?php

namespace App\Http\Livewire\Cetak\Lpp;

use App\Models\Pengguna;
use App\Models\RekeningAir;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;

class Air extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dataUnitPelayanan, $unitPelayanan, $rayon, $tanggal1, $tanggal2, $dataKasir, $kasir;

    public $queryString = ['unitPelayanan', 'tanggal1', 'tanggal2', 'kasir'];

    public function mount()
    {
        $this->dataKasir = Pengguna::all();
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->tanggal1 = $this->tanggal1?:date('Y-m-d');
        $this->tanggal2 = $this->tanggal2?:date('Y-m-d');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function cetak()
    {
        $cetak = view('cetak.lppair', [
            'data' => RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1. ' 00:00:00', $this->tanggal2. ' 23:59:59'])->when($this->kasir, fn($q) => $q->where('kasir', $this->kasir))->whereNotNull('kasir')->orderBy('waktu_bayar')->get()
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }
    
    public function render()
    {
        return view('livewire.cetak.lpp.air', [
            'data' => RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1. ' 00:00:00', $this->tanggal2. ' 23:59:59'])->when($this->kasir, fn($q) => $q->where('kasir', $this->kasir))->whereNotNull('kasir')->orderBy('waktu_bayar')->get()
        ]);
    }
}
