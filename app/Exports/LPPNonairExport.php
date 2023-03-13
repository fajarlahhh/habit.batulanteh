<?php

namespace App\Exports;

use App\Models\Regional;
use App\Models\RekeningAir;
use App\Models\RekeningNonAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LPPNonairExport implements FromView
{
    public $unitPelayanan,$kasir, $tanggal1, $tanggal2;

    public function __construct($unitPelayanan, $kasir,  $tanggal1, $tanggal2)
    {
        $this->unitPelayanan = $unitPelayanan;
        $this->kasir = $kasir;
        $this->tanggal1 = $tanggal1;
        $this->tanggal2 = $tanggal2;
    }

    public function view(): View
    {
        $data = RekeningNonAir::whereBetween('created_at', [$this->tanggal1 . ' 00:00:00', $this->tanggal2 . ' 23:59:59'])->when($this->kasir, fn ($q) => $q->where('kasir', $this->kasir))->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->whereNotNull('kasir')->orderBy('created_at');
        return view('cetak.lppnonair', [
            'no' => 0,
            'tanggal1' => $this->tanggal1,
            'tanggal2' => $this->tanggal2,
            'kasir' => $this->kasir,
            'unitPelayanan' => $this->unitPelayanan,
            'total' => $data->count(),
            'dataRaw' => $data->get(),
            'data' => $data->paginate(10)
        ]);
    }
}
