<?php

namespace App\Http\Livewire\Administrator\Mutasistatus;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\LogStatusPelanggan;
use Illuminate\Support\Facades\DB;

class Bongkar extends Component
{
    public $pelanggan, $pelangganId, $catatan;

    protected $rules = [
        'pelangganId' => 'required',
        'catatan' => 'required',
    ];

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $log = new LogStatusPelanggan();
            $log->status_lama = $this->pelanggan->status;
            $log->status_baru = 3;
            $log->pelanggan_id = $this->pelangganId;
            $log->catatan = $this->catatan;
            $log->save();

            $this->pelanggan->status = 3;
            $this->pelanggan->save();
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('administrator.mutasistatus.segel'));
    }

    public function updatedPelangganId()
    {
        $this->pelanggan = Pelanggan::with('golongan')->findOrFail($this->pelangganId);
    }
    
    public function render()
    {
        return view('livewire.administrator.mutasistatus.bongkar');
    }
}
