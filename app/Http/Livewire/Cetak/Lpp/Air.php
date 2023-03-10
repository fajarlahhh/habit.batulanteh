<?php

namespace App\Http\Livewire\Cetak\Lpp;

use Livewire\Component;
use App\Models\Pengguna;
use App\Models\Regional;
use App\Models\RekeningAir;
use Livewire\WithPagination;
use App\Exports\LPPAirExport;
use App\Models\UnitPelayanan;
use Maatwebsite\Excel\Facades\Excel;

class Air extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dataUnitPelayanan, $unitPelayanan, $tanggal1, $tanggal2, $dataKasir, $kasir;

    public $queryString = ['unitPelayanan', 'tanggal1', 'tanggal2', 'kasir'];

    public function mount()
    {
        $this->dataKasir = Pengguna::where('penagih', '>', 0)->get();
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
        return Excel::download(new LPPAirExport($this->unitPelayanan, $this->kasir, $this->tanggal1, $this->tanggal2), 'lppair' . $this->unitPelayanan . $this->kasir . $this->tanggal1 . $this->tanggal2 . '.xlsx');
    }

    public function render()
    {
        $data = RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1 . ' 00:00:00', $this->tanggal2 . ' 23:59:59'])->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->whereNotNull('kasir')->orderBy('waktu_bayar');

        if ($this->kasir) {
            if (is_int((int)$this->kasir) && (int)$this->kasir > 0) {
                $data = $data->whereIn('kasir', \App\Models\Pengguna::where('unit_pelayanan_id', $this->kasir)->get()->pluck('uid'));
            } else {
                $data = $data->where('kasir', $this->kasir);
            }            
        }

        return view('livewire.cetak.lpp.air', [
            'no' => ($this->page - 1) * 10,
            'dataRaw' => $data->get(),
            'data' => $data->paginate(10),
        ]);
    }
}
