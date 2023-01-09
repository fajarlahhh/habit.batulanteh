<?php

namespace App\Http\Livewire\Datamaster\Golongan;

use App\Models\Golongan;
use Livewire\Component;

class Form extends Component
{
    public $key, $nama, $deskripsi, $data;

    protected $rules = [
        'nama' => 'required',
        'deskripsi' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->nama = $this->nama;
        $this->data->deskripsi = $this->deskripsi;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.golongan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Golongan::findOrFail($this->key);
            $this->nama = $this->data->nama;
            $this->deskripsi = $this->data->deskripsi;
        } else {
            $this->data = new Golongan();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.golongan.form');
    }
}
