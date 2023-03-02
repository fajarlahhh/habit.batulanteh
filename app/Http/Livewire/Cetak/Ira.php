<?php

namespace App\Http\Livewire\Cetak;

use App\Models\Golongan;
use Livewire\Component;
use App\Models\Regional;
use App\Models\UnitPelayanan;

class Ira extends Component
{
    public $dataUnitPelayanan, $unitPelayanan, $rayon, $bulan, $tahun;

    public $queryString = ['bulan', 'tahun', 'unitPelayanan'];
    public function mount()
    {
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->bulan = $this->bulan?:date('m');
        $this->tahun = $this->tahun?:date('Y');
    }

    public function cetak()
    {
        $cetak = view('cetak.ira', [
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'rayon' => $this->rayon,
            'unitPelayanan' => $this->unitPelayanan,
            'data' => Golongan::selectRaw('golongan.nama nama_golongan,
            golongan.deskripsi deskripsi_golongan,
            count(harga_air) jumlah_pelanggan,
            if(count(harga_air) = 0, 0, sum(if(stand_ini is null and stand_lalu is null, 0, 1))) pelanggan_aktif,
            if(count(harga_air) = 0, 0, sum(if(stand_ini is null and stand_lalu is null, 1, 0))) pelanggan_pasif,
            ifnull(sum(if(stand_angkat > 0, stand_ini - stand_pasang + stand_angkat- stand_lalu, stand_ini-stand_lalu)),0) pakai,
            ifnull(sum(harga_air),0) harga_air,
            ifnull(sum(biaya_meter_air),0) administrasi,
            ifnull(sum(biaya_materai),0) materai')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->leftJoin('ira', 'golongan.id', '=', 'ira.golongan_id')->groupBy('golongan.id')->get(),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.cetak.ira', [
            'data' => Golongan::selectRaw('golongan.nama nama_golongan,
            golongan.deskripsi deskripsi_golongan,
            count(harga_air) jumlah_pelanggan,
            if(count(harga_air) = 0, 0, sum(if(stand_ini is null and stand_lalu is null, 0, 1))) pelanggan_aktif,
            if(count(harga_air) = 0, 0, sum(if(stand_ini is null and stand_lalu is null, 1, 0))) pelanggan_pasif,
            ifnull(sum(if(stand_angkat > 0, stand_ini - stand_pasang + stand_angkat- stand_lalu, stand_ini-stand_lalu)),0) pakai,
            ifnull(sum(harga_air),0) harga_air,
            ifnull(sum(biaya_meter_air),0) administrasi,
            ifnull(sum(biaya_materai),0) materai')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->when($this->unitPelayanan, fn ($q) => $q->whereIn('jalan_kelurahan_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))->when($this->rayon, fn ($q) => $q->where('rayon_id', $this->rayon))->leftJoin('ira', 'golongan.id', '=', 'ira.golongan_id')->groupBy('golongan.id')->get()
        ]);
    }
}
