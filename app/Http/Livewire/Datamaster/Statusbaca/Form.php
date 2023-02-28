<?php

namespace App\Http\Livewire\Datamaster\Statusbaca;

use App\Models\StatusBaca;
use Livewire\Component;

class Form extends Component
{
    public $key, $keterangan, $inputAngka = true, $data;

    protected $rules = [
        'keterangan' => 'required',
        'inputAngka' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->keterangan = $this->keterangan;
        $this->data->input_angka = $this->inputAngka;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.statusbaca'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = StatusBaca::findOrFail($this->key);
            $this->keterangan = $this->data->keterangan;
            $this->inputAngka = $this->data->input_angka;
        } else {
            $this->data = new StatusBaca();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.statusbaca.form');
    }
}
