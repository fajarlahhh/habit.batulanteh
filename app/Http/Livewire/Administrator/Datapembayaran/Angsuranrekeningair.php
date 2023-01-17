<?php

namespace App\Http\Livewire\Administrator\Datapembayaran;

use App\Models\AngsuranRekeningAirDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Angsuranrekeningair extends Component
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
            'dataRekeningAir' => collect([]),
            'dataAngsuranRekeningAir' => AngsuranRekeningAirDetail::with('angsuranRekeningAir')->where('id', $id)->get(),
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
        AngsuranRekeningAirDetail::where('id', $this->key)->update([
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
        return view('livewire.administrator.datapembayaran.angsuranrekeningair', [
            'i' => ($this->page - 1) * 10,
            'data' => AngsuranRekeningAirDetail::sudahBayar()->where(DB::raw('date(waktu_bayar)'), $this->tanggal)->whereHas('angsuranRekeningAir', fn($q) => $q->whereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%')))->paginate(10),
        ]);
    }
}
