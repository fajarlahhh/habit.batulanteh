<?php

namespace App\Http\Livewire\Bacameter\Datatarget;

use App\Models\BacaMeter;
use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tahun;
    public $bulan;
    public $statusBaca;
    public $tanggalBaca;
    public $cari;

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
        $tahun = 2023;
        $bulan = 2;
        foreach (Pelanggan::all() as $key => $row) {
            $filename = $row->no_langganan . '_' . $tahun . '-' . $bulan . '.jpg';
            try {
                $file_name = basename('http://www.perumdamsumbawa.co.id/secure/upload/wm/' . $filename);
                file_put_contents('bacameter/' . $file_name, file_get_contents('http://www.perumdamsumbawa.co.id/secure/upload/wm/' . $filename));
            } catch (\Throwable$th) {
                //throw $th;
            }
        }

        return view('livewire.bacameter.datatarget.index', [
            'i' => ($this->page - 1) * 10,
            'data' => BacaMeter::with('pengguna')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->where(fn($q) => $q->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->cari . '%')->where('no_langganan', 'like', '%' . $this->cari . '%')))->paginate(10),
        ])->extends('livewire.main', [
            'sidebarTwo' => true,
            'slot' => null,
        ])->section('subcontent');
    }
}
