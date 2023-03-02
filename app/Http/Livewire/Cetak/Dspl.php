<?php

namespace App\Http\Livewire\Cetak;

use Livewire\Component;
use App\Models\Golongan;
use App\Models\Regional;
use App\Models\Pelanggan;
use App\Exports\DsplExport;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use App\Models\Dspl as ModelsDspl;
use Maatwebsite\Excel\Facades\Excel;

class Dspl extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $dataUnitPelayanan, $unitPelayanan, $rayon, $status, $tahun, $bulan, $dataGolongan, $golongan;

    public $queryString = ['status', 'bulan', 'tahun', 'golongan', 'unitPelayanan'];

    public function mount()
    {
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->dataGolongan = Golongan::all();
        $this->tahun = $this->tahun ?: date('Y');
        $this->bulan = $this->bulan ?: date('m');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function cetak()
    {
        return Excel::download(new DsplExport($this->unitPelayanan, $this->rayon, $this->status, $this->golongan, $this->tahun, $this->bulan), 'dspl' . $this->unitPelayanan . $this->rayon . $this->status . $this->golongan . $this->tahun . $this->bulan . '.xlsx');
    }

    public function render()
    {
        return view('livewire.cetak.dspl', [
            'data' => ModelsDspl::with('golongan')->with('pelanggan')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->golongan, fn ($q) => $q->where('golongan_id', $this->golongan))->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->orderBy('pelanggan_id')->orderBy('periode_rekening')->paginate(10)
        ]);
    }
}
