<?php

namespace App\Http\Livewire\Bacameter\Datatarget;

use Livewire\Component;
use App\Models\Pengguna;
use App\Models\Regional;
use App\Models\BacaMeter;
use App\Models\StatusBaca;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tahun, $bulan, $statusBaca, $tanggalBaca, $unitPelayanan, $rayon, $cari, $dataUnitPelayanan, $pemakaian, $pembaca, $pembacaUpdate, $dataPembaca, $terbaca, $dataStatusBaca;

    protected $queryString = ['tahun', 'bulan', 'statusBaca', 'tanggalBaca', 'unitPelayanan', 'rayon', 'cari', 'pemakaian', 'pembaca','terbaca'];

    public function setPembaca($key)
    {
        dd($this->pembacaUpdate);
        BacaMeter::where('id', $key)->update([
            'pembaca_id' => $this->pembaca
        ]);
    }

    public function mount()
    {
        $this->terbaca=$this->terbaca?:1;
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');
        $this->statusBaca = $this->statusBaca ?: null;
        $this->unitPelayanan = $this->unitPelayanan ?: null;
        $this->pemakaian = $this->pemakaian ?: null;
        $this->rayon = $this->rayon ?: null;
        $this->cari = $this->cari ?: null;
        $this->dataUnitPelayanan = UnitPelayanan::all();
        $this->dataPembaca= Pengguna::where('bacameter', 1)->get();
        $this->dataStatusBaca= StatusBaca::withTrashed()->get();
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        $data = BacaMeter::with('pengguna')->with('rayon')->where('periode', $this->tahun . '-' . $this->bulan . '-01')
            ->when($this->pembaca, fn ($q) => $q->where('pembaca_id', $this->pembaca))
            ->when($this->terbaca == 1, fn ($q) => $q->whereNull('tanggal_baca'))
            ->when($this->terbaca == 2, fn ($q) => $q->whereNotNull('tanggal_baca')->where('status_baca', '!=', 'SEGEL')->when($this->statusBaca, fn ($r) => $r->where('status_baca', $this->statusBaca))->when($this->tanggalBaca, fn ($r) => $r->where(DB::raw('date(tanggal_baca)'), date('Y-m-d', strtotime($this->tanggalBaca)))))
            ->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))
            ->where(fn ($q) => $q->whereHas('pelanggan', fn ($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%')));

        return view('livewire.bacameter.datatarget.index', [
            'i' => ($this->page - 1) * 10,
            'data' => $data->paginate(10),
        ])->extends('livewire.main', [
            'sidebarTwo' => true,
            'slot' => null,
        ])->section('subcontent');
    }
}
