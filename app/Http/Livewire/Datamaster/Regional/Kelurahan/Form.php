<?php

namespace App\Http\Livewire\Datamaster\Regional\Kelurahan;

use App\Models\Kelurahan;
use Livewire\Component;

class Form extends Component
{
    public $key, $kode, $nama, $kecamatanId, $data;

    protected $rules = [
        'kode' => 'required',
        'nama' => 'required',
        'kecamatanId' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->kode = $this->kode;
        $this->data->nama = $this->nama;
        $this->data->kecamatan_id = $this->kecamatanId;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.regional.kelurahan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Kelurahan::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
            $this->kecamatanId = $this->data->kecamatan_id;
        } else {
            $this->data = new Kelurahan();
        }
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.datamaster.regional.kelurahan.form');
    }
}
