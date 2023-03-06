<?php

namespace App\Http\Livewire\Cetak;

use Livewire\Component;
use App\Models\Regional;
use App\Exports\DrdExport;
use App\Models\Ira;
use App\Models\RekeningAir;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use Maatwebsite\Excel\Facades\Excel;

class Drd extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dataUnitPelayanan, $unitPelayanan, $rayon, $bulan, $tahun;

    public $queryString = ['bulan', 'tahun', 'unitPelayanan'];

    public function mount()
    {
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->bulan = $this->bulan?:date('m');
        $this->tahun = $this->tahun?:date('Y');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function cetak()
    {
        return Excel::download(new DrdExport($this->unitPelayanan, $this->rayon, $this->tahun, $this->bulan), 'drd' . $this->unitPelayanan . $this->rayon . $this->tahun . $this->bulan . '.xlsx');
    }

    public function render()
    {
        return view('livewire.cetak.drd', [
            'data' => Ira::with('golongan')->with('tarifMeterAir.tarifMeterAirDetail')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->paginate(10)
        ]);
    }
}
