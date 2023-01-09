<?php

namespace App\Http\Livewire\Datamaster\Regional\Jalan;

use App\Models\Jalan;
use Livewire\Component;

class Form extends Component
{
    public $key, $nama, $jenis, $kelurahan, $data;

    protected $rules = [
        'nama' => 'required',
        'jenis' => 'required',
        'kelurahan' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->nama = $this->nama;
        $this->data->jenis = $this->jenis;
        $this->data->kelurahan_id = $this->kelurahan;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.regional.jalan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Jalan::findOrFail($this->key);
            $this->nama = $this->data->nama;
            $this->jenis = $this->data->jenis;
            $this->kelurahan = $this->data->kelurahan_id;
        } else {
            $this->data = new Jalan();
        }
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.datamaster.regional.jalan.form');
    }
}
