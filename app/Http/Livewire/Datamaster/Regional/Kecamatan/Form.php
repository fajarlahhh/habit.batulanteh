<?php

namespace App\Http\Livewire\Datamaster\Regional\Kecamatan;

use App\Models\Kecamatan;
use Livewire\Component;

class Form extends Component
{
    public $key, $kode, $nama, $data;

    protected $rules = [
        'kode' => 'required',
        'nama' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->kode = $this->kode;
        $this->data->nama = $this->nama;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.regional.kecamatan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Kecamatan::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
        } else {
            $this->data = new Kecamatan();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.regional.kecamatan.form');
    }
}
