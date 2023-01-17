<?php

namespace App\Http\Livewire\Datamaster\Diameter;

use App\Models\Diameter;
use Livewire\Component;

class Form extends Component
{
    public $key, $ukuran, $biayaPemasangan, $biayaGantiMeter, $biayaPindahMeter, $data;

    protected $rules = [
        'ukuran' => 'required',
        // 'biayaPemasangan' => 'required|numeric',
        // 'biayaGantiMeter' => 'required|numeric',
        // 'biayaPindahMeter' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->ukuran = $this->ukuran;
        $this->data->biaya_pemasangan = $this->biayaPemasangan;
        $this->data->biaya_ganti_meter = $this->biayaGantiMeter;
        $this->data->biaya_pindah_meter = $this->biayaPindahMeter;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.diameter'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Diameter::findOrFail($this->key);
            $this->ukuran = $this->data->ukuran;
            $this->biayaPemasangan = $this->data->biaya_pemasangan;
            $this->biayaGantiMeter = $this->data->biaya_ganti_meter;
            $this->biayaPindahMeter = $this->data->biaya_pindah_meter;
        } else {
            $this->data = new Diameter();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.diameter.form');
    }
}
