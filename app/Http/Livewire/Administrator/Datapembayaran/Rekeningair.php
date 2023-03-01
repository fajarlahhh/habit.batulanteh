<?php

namespace App\Http\Livewire\Administrator\Datapembayaran;

use App\Models\RekeningAir as ModelsRekeningAir;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Rekeningair extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tanggal, $key, $cari;

    protected $queryString = ['tanggal', 'cari'];

    public function cetak($id)
    {
        $cetak = view('cetak.nota-rekeningair', [
            'dataRekeningAir' => ModelsRekeningAir::with('bacaMeter')->where('id', $id)->sudahBayar()->get(),
            'dataAngsuranRekeningAir' => collect([]),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function mount()
    {
        $this->tanggal = $this->tanggal?:date('Y-m-d');
    }

    public function setKey($key = null)
    {
        $this->key = $key;
    }

    public function hapus()
    {
        ModelsRekeningAir::where('id', $this->key)->update([
            'waktu_bayar' => null,
            'kasir' => null,
        ]);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.administrator.datapembayaran.rekeningair', [
            'i' => ($this->page - 1) * 10,
            'data' => ModelsRekeningAir::withoutGlobalScopes()->whereBetween('waktu_bayar', [$this->tanggal.' 00:00:00', $this->tanggal.' 23:59:59'])->sudahBayar()->whereHas('pelanggan', fn($r) => $r->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%'))->paginate(10),
        ]);
    }
}
