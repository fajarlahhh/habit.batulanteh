<?php

namespace App\Http\Livewire\Datamaster\Regional\Unitpelayanan;

use App\Models\UnitPelayanan;
use Livewire\Component;

class Form extends Component
{
    public $key, $alamat, $nama, $data;

    protected $rules = [
        'alamat' => 'required',
        'nama' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->alamat = $this->alamat;
        $this->data->nama = $this->nama;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.regional.unitpelayanan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = UnitPelayanan::findOrFail($this->key);
            $this->alamat = $this->data->alamat;
            $this->nama = $this->data->nama;
        } else {
            $this->data = new UnitPelayanan();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.regional.unitpelayanan.form');
    }
}
