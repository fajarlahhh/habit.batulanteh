<?php

namespace App\Exports;

use App\Models\Regional;
use App\Models\RekeningAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DrdExport implements FromView
{
    public $unitPelayanan, $rayon, $tahun, $bulan;

    public function __construct($unitPelayanan, $rayon, $tahun, $bulan)
    {
        $this->unitPelayanan = $unitPelayanan;
        $this->rayon = $rayon;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        return view('cetak.drd', [
            'data' =>  RekeningAir::with('golongan')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->unitPelayanan, fn ($q) => $q->where('rayon_id', $this->rayon))->get()
        ]);
    }

}
