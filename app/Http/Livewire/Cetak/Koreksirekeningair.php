<?php

namespace App\Http\Livewire\Cetak;

use Livewire\Component;
use App\Models\Regional;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KoreksirekeningairExport;
use App\Models\KoreksiRekeningAir as ModelsKoreksiRekeningAir;

class Koreksirekeningair extends Component
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
        return Excel::download(new KoreksirekeningairExport($this->unitPelayanan, $this->rayon, $this->tahun, $this->bulan), 'koreksirekeningair' . $this->unitPelayanan . $this->rayon . $this->tahun . $this->bulan . '.xlsx');
    }

    public function render()
    {
        return view('livewire.cetak.koreksirekeningair', [
            'data' => ModelsKoreksiRekeningAir::with('rekeningAir.pelanggan')->with('golonganLama')->with('golonganBaru')->with('rekeningAir.jalanKelurahan.kelurahan.kecamatan.unitPelayanan')->whereBetween('created_at',  [$this->tahun . '-' . $this->bulan . '-01 00:00:00', $this->tahun . '-' . $this->bulan . '-31 23:59:59'])->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->paginate(10)
        ]);
    }
}
