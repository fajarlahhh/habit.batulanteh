<?php

namespace App\Http\Livewire\Tagihanrekeningair\Angsuran;

use App\Models\Pelanggan;
use Livewire\Component;

class Form extends Component
{
    public $pelanggan, $pelangganId, $dataRekeningAir, $keterangan, $pemohon;

    public function updatedPelangganId()
    {
        $this->pelanggan = Pelanggan::with('golongan')->with('bacaMeter.rekeningAir')->with(['bacaMeter' => fn($q) => $q->whereHas('rekeningAir', fn($r) => $r->belumBayar())])->findOrFail($this->pelangganId);
        $this->dataRekeningAir = $this->pelanggan->bacaMeter->map(fn($q) => [
            'rekening_air_id' => $q->rekeningAir->id,
            'denda' => $q->rekeningAir->tarifDenda->nilai,
            'rekening_air_id' => $q->rekeningAir->id,
            'rekening_air_id' => $q->rekeningAir->id,
            'rekening_air_id' => $q->rekeningAir->id,
        ]);
        dd($this->dataRekeningAir);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.tagihanrekeningair.angsuran.form');
    }
}
