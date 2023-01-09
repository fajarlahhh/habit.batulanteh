<?php

namespace App\Http\Livewire\Datamaster\MerkWaterMeter;

use App\Models\MerkWaterMeter;
use Livewire\Component;

class Form extends Component
{
    public $key, $merk, $deskripsi, $data;

    protected $rules = [
        'merk' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->merk = $this->merk;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.merkwatermeter'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = MerkWaterMeter::findOrFail($this->key);
            $this->merk = $this->data->merk;
        } else {
            $this->data = new MerkWaterMeter();
        }
    }
    public function render()
    {
        return view('livewire.datamaster.merkwatermeter.form');
    }
}
