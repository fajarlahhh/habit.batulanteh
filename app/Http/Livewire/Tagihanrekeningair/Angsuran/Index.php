<?php

namespace App\Http\Livewire\Tagihanrekeningair\Angsuran;

use App\Models\AngsuranRekeningAir;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $lunas, $key, $cari;

    protected $queryString = ['lunas', 'cari'];

    public function setKey($key = null)
    {
        if (AngsuranRekeningAir::findOrFail($this->key)->angsuranRekeningAirDetailTerbayar->count() > 0) {
            session()->flash('warning', 'Tidak dapat menghapus data. Data angsuran sudah pernah dibayar');
        } else {
            $this->key = $key;
        }
    }

    public function hapus()
    {
        AngsuranRekeningAir::findOrFail($this->key)->delete();
        $this->key = null;
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        $data = AngsuranRekeningAir::where(fn($q) => $q->where('nomor', 'like', '%' . $this->cari . '%')->orWhereHas('pelanggan', fn($q) => $q->where('no_langganan', 'like', '%' . $this->cari . '%')))->select('*', DB::raw('(select sum(nilai) from angsuran_rekening_air_detail where angsuran_rekening_air.id=angsuran_rekening_air_id) total'), DB::raw('(select sum(nilai) from angsuran_rekening_air_detail where angsuran_rekening_air.id=angsuran_rekening_air_id and kasir_id is not null and waktu_bayar is not null) terbayar'));

        if ($this->lunas == 1) {
            $data = $data->lunas();
        } else {
            $data = $data->belumLunas();
        }

        return view('livewire.tagihanrekeningair.angsuran.index', [
            'i' => ($this->page - 1) * 10,
            'data' => $data->paginate(10),
        ]);
    }
}
