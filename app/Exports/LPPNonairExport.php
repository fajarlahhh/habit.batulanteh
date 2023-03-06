<?php

namespace App\Exports;

use App\Models\RekeningAir;
use App\Models\RekeningNonAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LPPNonairExport implements FromView
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
            'data' =>  RekeningNonAir::whereBetween('created_at', [$this->tanggal1. ' 00:00:00', $this->tanggal2. ' 23:59:59'])->when($this->kasir, fn($q) => $q->where('kasir', $this->kasir))->whereNotNull('kasir')->orderBy('created_at')->get()
        ]);
    }
}
