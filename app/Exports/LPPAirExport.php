<?php

namespace App\Exports;

use App\Models\Regional;
use App\Models\RekeningAir;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LPPAirExport implements FromView
{
    public $unitPelayanan, $kasir, $tanggal1, $tanggal2;

    public function __construct($unitPelayanan,$kasir,  $tanggal1, $tanggal2)
    {
        $this->unitPelayanan = $unitPelayanan;
        $this->kasir = $kasir;
        $this->tanggal1 = $tanggal1;
        $this->tanggal2 = $tanggal2;
    }

    public function view(): View
    {
        $data = RekeningAir::whereBetween('waktu_bayar', [$this->tanggal1 . ' 00:00:00', $this->tanggal2 . ' 23:59:59'])->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->whereNotNull('kasir')->orderBy('waktu_bayar');

        if ($this->kasir) {
            if (is_int((int)$this->kasir) && (int)$this->kasir > 0) {
                $data = $data->whereIn('kasir', \App\Models\Pengguna::where('unit_pelayanan_id', $this->kasir)->get()->pluck('uid'));
            } else {
                $data = $data->where('kasir', $this->kasir);
            }            
        }
        return view('cetak.lppair', [
            'no' => 0,
            'tanggal1' => $this->tanggal1,
            'tanggal2' => $this->tanggal2,
            'kasir' => $this->kasir,
            'unitPelayanan' => $this->unitPelayanan,
            'dataRaw' => $data->get(),
            'data' => $data->get(),
        ]);
    }
}
