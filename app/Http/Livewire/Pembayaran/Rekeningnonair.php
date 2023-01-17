<?php

namespace App\Http\Livewire\Pembayaran;

use Livewire\Component;

class Rekeningnonair extends Component
{
    public $pelanggan, $pelangganId, $nama, $alamat, $noHp;
    public function render()
    {
        return view('livewire.pembayaran.rekeningnonair');
    }
}
