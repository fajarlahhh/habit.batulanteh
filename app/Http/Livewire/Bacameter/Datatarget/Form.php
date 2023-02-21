<?php

namespace App\Http\Livewire\Bacameter\Datatarget;

use App\Models\BacaMeter;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $key, $data, $noBodyWaterMeter, $tanggalBaca, $standIni, $statusBaca, $foto, $fotoUpload;

    public function mount()
    {
        $this->data = BacaMeter::findOrFail($this->key);
        $this->noBodyWaterMeter = $this->data->pelanggan->no_body_water_meter;
        $this->tanggalBaca = $this->data->tanggal_baca ?: date('Y-m-d');
        $this->standIni = $this->data->stand_ini;
        $this->statusBaca = $this->data->status_baca;
    }

    public function submit()
    {
        $this->validate([
            'noBodyWaterMeter' => 'required',
            'standIni' => 'required|numeric',
            'tanggalBaca' => 'required|date',
            'statusBaca' => 'required',
        ]);

        $edit = true;

        if ($this->data->rekeningAir) {
            session()->flash('danger', 'Gagal menyimpan data. Tagihan rekening air untuk data ini sudah diterbitkan');
            $edit = false;
        }

        if ($edit == true) {
            DB::transaction(function ($q) {
                Pelanggan::where('id', $this->data->pelanggan_id)->update([
                    'no_body_water_meter' => $this->noBodyWaterMeter,
                ]);

                $this->data->stand_ini = $this->standIni;
                $this->data->tanggal_baca = $this->tanggalBaca;
                $this->data->status_baca = $this->statusBaca;
                if ($this->fotoUpload) {
                    File::delete(Storage::url($this->data->foto));
                    $namaFile = date('YmdHims') . time() . uniqid() . '.' . $this->fotoUpload->getClientOriginalExtension();
                    Storage::putFileAs('public/bacameter/', $this->fotoUpload, $namaFile);
                    $this->data->foto = 'public/bacameter/' . $namaFile;
                }
                $this->data->save();
                session()->flash('success', 'Berhasil menyimpan data');
            });
        }

        return redirect(route('bacameter.datatarget'));
    }

    public function boot()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.bacameter.datatarget.form');
    }
}
