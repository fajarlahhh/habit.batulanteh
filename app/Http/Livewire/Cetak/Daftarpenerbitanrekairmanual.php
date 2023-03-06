<?php

namespace App\Http\Livewire\Cetak;

use App\Models\PenerbitanRekAirManual;
use Livewire\Component;

class Daftarpenerbitanrekairmanual extends Component
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
        $cetak = view('cetak.daftarpenerbitanrekairmanual', [
            'tanggal' => $this->tanggal,
            'data' => PenerbitanRekAirManual::with('pelanggan')->whereBetween('created_at', [$this->tanggal . ' 00:00:00', $this->tanggal . ' 23:59:59'])->get(),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function render()
    {
        return view('livewire.cetak.daftarpenerbitanrekairmanual', [
            'data' => PenerbitanRekAirManual::with('pelanggan')->whereBetween('created_at', [$this->tanggal . ' 00:00:00', $this->tanggal . ' 23:59:59'])->get(),
        ]);
    }
}
