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

    public $key, $data, $noBodyWaterMeter, $tanggalBaca, $standIni, $statusBaca, $standAngkat, $standPasang, $foto, $fotoUpload;

    public function mount()
    {
        $this->data = BacaMeter::findOrFail($this->key);
        $this->noBodyWaterMeter = $this->data->pelanggan->no_body_water_meter;
        $this->tanggalBaca = $this->data->tanggal_baca ?: date('Y-m-d');
        $this->standIni = $this->data->stand_ini;
        $this->standAngkat = $this->data->stand_angkat;
        $this->standPasang = $this->data->stand_pasang;
        $this->statusBaca = $this->data->status_baca;
        $this->pembaca = $this->data->pembaca_id;
    }

    public function submit()
    {
        $this->validate([
            'noBodyWaterMeter' => 'required',
            'standIni' => 'required|numeric',
            'tanggalBaca' => 'required|date',
            'statusBaca' => 'required',
        ]);

        if ($this->standPasang || $this->standAngkat) {
            $this->validate([
                'standPasang' => 'required|numeric',
                'standAngkat' => 'required|numeric',
            ]);
        }

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
                if ($this->standPasang || $this->standAngkat) {
                    $this->data->stand_pasang = $this->standPasang;
                    $this->data->stand_angkat = $this->standAngkat;
                }
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
