<?php

namespace App\Http\Livewire\Cetak\Lpp;

use Livewire\Component;
use App\Models\Pengguna;
use App\Models\Regional;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use App\Models\RekeningNonAir;
use App\Exports\LPPNonairExport;
use Maatwebsite\Excel\Facades\Excel;

class Nonair extends Component
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
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        return Excel::download(new LPPNonairExport($this->unitPelayanan, $this->rayon, $this->kasir, $this->tanggal1, $this->tanggal2), 'lppnonair' . $this->unitPelayanan . $this->rayon . $this->kasir . $this->tanggal1 . $this->tanggal2 . '.xlsx');
    }
    
    public function render()
    {
        return view('livewire.cetak.lpp.nonair', [
            'data' => RekeningNonAir::whereBetween('created_at', [$this->tanggal1. ' 00:00:00', $this->tanggal2. ' 23:59:59'])->when($this->kasir, fn($q) => $q->where('kasir', $this->kasir))->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->whereNotNull('kasir')->orderBy('created_at')->paginate(10)
        ]);
    }
}
