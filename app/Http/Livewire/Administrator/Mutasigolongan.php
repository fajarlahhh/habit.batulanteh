<?php

namespace App\Http\Livewire\Administrator;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\LogGolongan;
use Illuminate\Support\Facades\DB;

class Mutasigolongan extends Component
{
    public $pelanggan, $pelangganId, $catatan, $golongan;

    protected $rules = [
        'pelangganId' => 'required',
        'catatan' => 'required',
        'golongan' => 'required',
    ];

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $log = new LogGolongan();
            $log->status_lama = $this->pelanggan->status;
            $log->golongan_id_lama = $this->pelanggan->golongan_id;
            $log->golongan_id_baru = $this->golongan;
            $log->pelanggan_id = $this->pelangganId;
            $log->save();

            $this->pelanggan->golongan_id = $this->golongan;
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
        return view('livewire.administrator.mutasigolongan');
    }
}
