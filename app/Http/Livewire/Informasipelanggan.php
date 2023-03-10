<?php

namespace App\Http\Livewire;

use App\Models\Pelanggan;
use App\Models\TarifDenda;
use Livewire\Component;

class Informasipelanggan extends Component
{
    public $pelanggan, $pelangganId, $catatan, $status, $dataTarifDenda, $dataPelanggan = [];

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        $this->dataTarifDenda = TarifDenda::orderBy('tanggal_berlaku', 'desc')->first();
        $this->dataPelanggan =Pelanggan::with('rayon.kelurahan.kecamatan')->get();
    }

    public function updatedPelangganId()
    {
        $this->pelanggan = Pelanggan::with('golongan')->with('tagihan')->with('kolektifDetail.kolektif')->findOrFail($this->pelangganId);
        $this->status = $this->pelanggan->status;
    }

    public function render()
    {
        return view('livewire.informasipelanggan');
    }
}
