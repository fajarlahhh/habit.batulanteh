<?php

namespace App\Http\Livewire;

use App\Models\Pelanggan;
use App\Models\TarifDenda;
use Livewire\Component;

class Informasipelanggan extends Component
{
    public $pelanggan, $pelangganId, $catatan, $status, $dataTarifDenda;

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        $this->dataTarifDenda = TarifDenda::orderBy('tanggal_berlaku', 'desc')->first();
    }

    public function updatedPelangganId()
    {
        $this->pelanggan = Pelanggan::with('golongan')->with('tagihan.rekeningAir')->findOrFail($this->pelangganId);
        $this->status = $this->pelanggan->status;
    }

    public function render()
    {
        return view('livewire.informasipelanggan');
    }
}