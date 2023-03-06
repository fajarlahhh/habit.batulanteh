<?php

namespace App\Http\Livewire\Cetak;

use Livewire\Component;
use App\Models\LogStatusPelanggan;
use Maatwebsite\Excel\Facades\Excel;

class Daftarpergantianstatuspelanggan extends Component
{
    public $tanggal;

    public $queryString = ['tanggal'];

    public function mount()
    {
        $this->tanggal = $this->tanggal ?: date('Y-m-d');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function cetak()
    {
        $cetak = view('cetak.daftarpergantianstatuspelanggan', [
            'tanggal' => $this->tanggal,
            'data' => LogStatusPelanggan::with('pelanggan')->whereBetween('created_at', [$this->tanggal . ' 00:00:00', $this->tanggal . ' 23:59:59'])->get(),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function render()
    {
        return view('livewire.cetak.daftarpergantianstatuspelanggan', [
            'data' => LogStatusPelanggan::with('pelanggan')->whereBetween('created_at', [$this->tanggal . ' 00:00:00', $this->tanggal . ' 23:59:59'])->get(),
        ]);
    }
}
