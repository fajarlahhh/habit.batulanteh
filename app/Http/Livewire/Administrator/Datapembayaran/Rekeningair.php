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

    protected $listeners = [
        'set:settanggal' => 'setTanggal',
    ];

    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function cetak($id)
    {
        $cetak = view('livewire.pembayaran.rekeningair.cetak', [
            'dataRekeningAir' => ModelsRekeningAir::with('bacaMeter')->where('id', $id)->sudahBayar()->get(),
            'dataAngsuranRekeningAir ' => ModelsRekeningAir::findOrFail($id),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function setKey($key = null)
    {
        $this->key = $key;
    }

    public function hapus()
    {
        ModelsRekeningAir::where('id', $this->key)->update([
            'waktu_bayar' => null,
            'kasir_id' => null,
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
            'data' => ModelsRekeningAir::where(DB::raw('date(waktu_bayar)'), $this->tanggal)->sudahBayar()->whereHas('bacaMeter', fn($q) => $q->whereHas('pelanggan', fn($r) => $r->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%')))->paginate(10),
        ]);
    }
}
