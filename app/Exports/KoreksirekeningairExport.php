<?php

namespace App\Exports;

use App\Models\Regional;
use App\Models\KoreksiRekeningAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KoreksirekeningairExport implements FromView
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
        return view('cetak.koreksirekeningair', [
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'rayon' => $this->rayon,
            'unitPelayanan' => $this->unitPelayanan,
            'data' =>  KoreksiRekeningAir::with('rekeningAir.pelanggan')->with('golonganLama')->with('golonganBaru')->with('rekeningAir.rayon.kelurahan.kecamatan.unitPelayanan')->whereBetween('created_at',  [$this->tahun . '-' . $this->bulan . '-01 00:00:00', $this->tahun . '-' . $this->bulan . '-31 23:59:59'])->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->get()
        ]);
    }
    public function collection()
    {
        //
    }
}
