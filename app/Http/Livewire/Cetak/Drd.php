<?php

namespace App\Http\Livewire\Cetak;

use Livewire\Component;
use App\Models\Regional;
use App\Models\RekeningAir;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;

class Drd extends Component
{   
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dataUnitPelayanan, $unitPelayanan, $rayon, $bulan, $tahun;

    public $queryString = ['bulan', 'tahun', 'unitPelayanan'];

    public function mount()
    {
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function cetak()
    {
        $cetak = view('cetak.ira', [
            'data' => RekeningAir::with('golongan')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->unitPelayanan, fn ($q) => $q->where('rayon_id', $this->rayon))->get()
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function render()
    {
        return view('livewire.cetak.drd', [
            'data' => RekeningAir::with('golongan')->with('tarifMeterAir.tarifMeterAirDetail')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->unitPelayanan, fn ($q) => $q->where('rayon_id', $this->rayon))->paginate(10)
        ]);
    }
}
