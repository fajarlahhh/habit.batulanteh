<?php

namespace App\Http\Livewire\Cetak\Lpp;

use App\Exports\LPPAirExport;
use Livewire\Component;
use App\Models\Pengguna;
use App\Models\RekeningAir;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use Maatwebsite\Excel\Facades\Excel;

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
        $this->tanggal1 = $this->tanggal1 ?: date('Y-m-d');
        $this->tanggal2 = $this->tanggal2 ?: date('Y-m-d');
        // $this->data = $this->data ?: collect([]);
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
        return Excel::download(new LPPAirExport($this->unitPelayanan, $this->rayon, $this->kasir, $this->tanggal1, $this->tanggal2), 'drd' . $this->unitPelayanan . $this->rayon . $this->kasir . $this->tanggal1 . $this->tanggal2 . '.xlsx');
    }
    // public function load()
    // {
    //     $this->data = RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1 . ' 00:00:00', $this->tanggal2 . ' 23:59:59'])->when($this->kasir, fn ($q) => $q->where('kasir', $this->kasir))->whereNotNull('kasir')->orderBy('waktu_bayar')->get();
    // }

    public function render()
    {
        return view('livewire.cetak.lpp.air', [
            'no' => ($this->page - 1) * 10,
            'data' => RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1 . ' 00:00:00', $this->tanggal2 . ' 23:59:59'])->when($this->kasir, fn ($q) => $q->where('kasir', $this->kasir))->whereNotNull('kasir')->orderBy('waktu_bayar')->paginate(10)
        ]);
    }
}
