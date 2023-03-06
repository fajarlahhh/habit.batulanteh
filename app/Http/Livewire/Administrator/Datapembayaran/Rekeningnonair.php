<?php

namespace App\Http\Livewire\Administrator\Datapembayaran;

use App\Models\RekeningNonAir as ModelsRekeningNonAir;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Rekeningnonair extends Component
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
        $cetak = view('cetak.nota-rekeningnonair', [
            'dataRekeningNonAir' => ModelsRekeningNonAir::findOrFail($id),
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
        ModelsRekeningNonAir::findOrFail($this->key)->delete();
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.administrator.datapembayaran.rekeningnonair', [
            'i' => ($this->page - 1) * 10,
            'data' => ModelsRekeningNonAir::whereBetween('created_at', [$this->tanggal.' 00:00:00', $this->tanggal.' 23:59:59'])->where(fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->where('alamat', 'like', '%' . $this->cari . '%'))->orderBy('created_at')->paginate(10),
        ]);
    }
}
