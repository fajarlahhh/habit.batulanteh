<?php

namespace App\Exports;

use App\Models\Regional;
use App\Models\Pelanggan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DsplExport implements FromView
{
    public $unitPelayanan, $rayon, $status, $golongan, $tahun, $bulan;

    public function __construct( $unitPelayanan, $rayon, $status, $golongan, $tahun, $bulan)
    {
        $this->unitPelayanan = $unitPelayanan;
        $this->rayon = $rayon;
        $this->status = $status;
        $this->golongan = $golongan;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        return view('cetak.dspl', [
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'rayon' => $this->rayon,
            'golongan' => $this->golongan,
            'status' => $this->status,
            'unitPelayanan' => $this->unitPelayanan,
            'data' =>  Pelanggan::whereHas('dspl')->with('dspl.golongan')->with(['dspl' => function ($q)
            {
                return $q->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->golongan, fn ($q) => $q->where('golongan_id', $this->golongan))->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon));
            }])->get()
        ]);
    }

}
