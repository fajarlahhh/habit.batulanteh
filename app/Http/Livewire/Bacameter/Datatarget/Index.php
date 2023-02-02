<?php

namespace App\Http\Livewire\Bacameter\Datatarget;

use App\Models\BacaMeter;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tahun, $bulan, $statusBaca, $tanggalBaca, $cari;

    protected $queryString = ['tahun', 'bulan', 'statusBaca', 'tanggalBaca', 'cari'];

    public function mount()
    {
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.bacameter.datatarget.index', [
            'i' => ($this->page - 1) * 10,
            'data' => BacaMeter::with('pengguna')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->where(fn($q) => $q->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->where('no_langganan', 'like', '%' . $this->cari . '%')))->paginate(10),
        ]);
    }
}
