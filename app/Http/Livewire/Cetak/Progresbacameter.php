<?php

namespace App\Http\Livewire\Cetak;

use App\Models\BacaMeter;
use App\Models\Pengguna;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Regional;
use App\Models\UnitPelayanan;

class Progresbacameter extends Component
{
    public $dataUnitPelayanan, $unitPelayanan, $rayon, $bulan, $tahun;

    public $queryString = ['bulan', 'tahun', 'unitPelayanan'];
    public function mount()
    {
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->bulan = $this->bulan?:date('m');
        $this->tahun = $this->tahun?:date('Y');
    }

    public function cetak()
    {
        $cetak = view('cetak.progresbacameter', [
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'rayon' => $this->rayon,
            'tanggal' => Carbon::parse($this->tahun . '-' . $this->bulan . '-01')->daysInMonth,
            'unitPelayanan' => $this->unitPelayanan,
            'data' => Pengguna::whereIn('id', BacaMeter::where('periode', $this->tahun . '-' . $this->bulan . '-01')->get()->pluck('pembaca_id'))->when($this->unitPelayanan, fn ($q) => $q->whereHas('bacaMeter', fn ($r) => $r->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id'))))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->with(['bacaMeter' => function ($q) {
                return $q->where('periode', $this->tahun . '-' . $this->bulan . '-01');
            }])->get(),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.cetak.progresbacameter', [
            'tanggal' => Carbon::parse($this->tahun . '-' . $this->bulan . '-01')->daysInMonth,
            'data' => Pengguna::whereIn('id', BacaMeter::where('periode', $this->tahun . '-' . $this->bulan . '-01')->get()->pluck('pembaca_id'))->when($this->unitPelayanan, fn ($q) => $q->whereHas('bacaMeter', fn ($r) => $r->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id'))))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->with(['bacaMeter' => function ($q) {
                return $q->where('periode', $this->tahun . '-' . $this->bulan . '-01');
            }])->get()
        ]);
    }
}
