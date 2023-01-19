<?php

namespace App\Http\Livewire\Pembayaran;

use App\Models\Pelanggan;
use App\Models\TarifPelayananSangsi;
use Livewire\Component;

class Rekeningnonair extends Component
{
    public $pelanggan, $pelangganId, $nama, $alamat, $noHp, $pelayananSangsiId, $tagihan, $tarifPelayananSangsi, $dataPelanggan;

    public function updatedPelayananSangsiId()
    {
        $this->tarifPelayananSangsi = TarifPelayananSangsi::findOrFail($this->pelayananSangsiId);
        $this->tagihan = $this->tarifPelayananSangsi->nilai;
        $this->reset(['pelangganId', 'nama', 'alamat', 'noHp']);
    }

    public function updatedPelangganId()
    {
        if ($this->tarifPelayananSangsi->pelanggan != null) {
            $this->pelanggan = Pelanggan::findOrFail($this->pelangganId);
            $this->nama = $this->pelanggan->nama;
            $this->alamat = $this->pelanggan->alamat;
            $this->noHp = $this->pelanggan->no_hp;
        }
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.pembayaran.rekeningnonair');
    }
}
