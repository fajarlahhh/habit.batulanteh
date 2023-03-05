<?php

namespace App\Http\Livewire\Bacameter\Datatarget;

use Livewire\Component;
use App\Models\Regional;
use App\Models\BacaMeter;
use Livewire\WithPagination;
use App\Models\UnitPelayanan;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tahun, $bulan, $statusBaca, $tanggalBaca, $unitPelayanan, $rayon, $cari, $dataUnitPelayanan, $pemakaian;

    protected $queryString = ['tahun', 'bulan', 'statusBaca', 'tanggalBaca', 'unitPelayanan', 'rayon', 'cari', 'pemakaian'];

    public function mount()
    {
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');
        $this->statusBaca = $this->statusBaca ?: null;
        $this->unitPelayanan = $this->unitPelayanan ?: null;
        $this->pemakaian = $this->pemakaian ?: null;
        $this->rayon = $this->rayon ?: null;
        $this->cari = $this->cari ?: null;
        $this->dataUnitPelayanan = UnitPelayanan::all();
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        $data = BacaMeter::with('pengguna')->with('rayon')
            ->when($this->statusBaca == 0, fn ($q) => $q->whereNull('tanggal_baca'))
            ->when($this->unitPelayanan, fn ($q) => $q->whereIn('rayon_id', Regional::where('unit_pelayanan_id', $this->unitPelayanan)->get()->pluck('id')))
            ->when($this->statusBaca == 1, fn ($q) => $q->whereNotNull('tanggal_baca'))
            ->where('periode', $this->tahun . '-' . $this->bulan . '-01')
            ->where(fn ($q) => $q->orWhereHas('pelanggan', fn ($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->where('no_langganan', 'like', '%' . $this->cari . '%')))
            ->when($this->tanggalBaca, fn ($q) => $q->where(DB::raw('date(tanggal_baca)'), date('Y-m-d', strtotime($this->tanggalBaca))));

        return view('livewire.bacameter.datatarget.index', [
            'i' => ($this->page - 1) * 10,
            'data' => $data->paginate(10),
        ])->extends('livewire.main', [
            'sidebarTwo' => true,
            'slot' => null,
        ])->section('subcontent');
    }
}
