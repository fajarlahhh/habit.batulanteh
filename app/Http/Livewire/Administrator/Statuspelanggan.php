<?php

namespace App\Http\Livewire\Administrator;

use App\Models\LogStatusPelanggan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Statuspelanggan extends Component
{
    public $pelanggan, $pelangganId, $catatan, $status;

    protected $rules = [
        'pelangganId' => 'required',
        'catatan' => 'required',
        'status' => 'required',
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
            $log->status_baru = $this->status;
            $log->pelanggan_id = $this->pelangganId;
            $log->save();

            $this->pelanggan->status = $this->status;
            $this->pelanggan->save();
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('administrator.statuspelanggan'));
    }

    public function updatedPelangganId()
    {
        $this->pelanggan = Pelanggan::with('golongan')->findOrFail($this->pelangganId);
        $this->status = $this->pelanggan->status;
    }

    public function render()
    {
        return view('livewire.administrator.statuspelanggan');
    }
}
