<?php

namespace App\Exports;

use App\Models\Regional;
use App\Models\RekeningAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LPPAirExport implements FromView
{
    public $unitPelayanan, $rayon, $kasir, $tanggal1, $tanggal2;

    public function __construct($unitPelayanan, $rayon, $kasir,  $tanggal1, $tanggal2)
    {
        $this->unitPelayanan = $unitPelayanan;
        $this->rayon = $rayon;
        $this->kasir = $kasir;
        $this->tanggal1 = $tanggal1;
        $this->tanggal2 = $tanggal2;
    }

    public function view(): View
    {
        return view('cetak.lppair', [
            'no' => 0,
            'tanggal1' => $this->tanggal1,
            'tanggal2' => $this->tanggal2,
            'rayon' => $this->rayon,
            'kasir' => $this->kasir,
            'unitPelayanan' => $this->unitPelayanan,
            'data' =>  RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1 . ' 00:00:00', $this->tanggal2 . ' 23:59:59'])->when($this->kasir, fn ($q) => $q->where('kasir', $this->kasir))->whereNotNull('kasir')->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->orderBy('waktu_bayar')->get()
        ]);
    }
}
