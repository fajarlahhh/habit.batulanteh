<?php

namespace App\Http\Livewire\Datamaster\Regional\Lingkungan;

use App\Models\Lingkungan;
use Livewire\Component;

class Form extends Component
{
    public $key, $kode, $nama, $kelurahanId, $data;

    protected $rules = [
        'nama' => 'required',
        'kelurahanId' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();
        $this->data->nama = $this->nama;
        $this->data->kelurahan_id = $this->kelurahanId;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.regional.lingkungan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Lingkungan::findOrFail($this->key);
            $this->nama = $this->data->nama;
            $this->kelurahanId = $this->data->kelurahan_id;
        } else {
            $this->data = new Lingkungan();
        }
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }
    public function render()
    {
        return view('livewire.datamaster.regional.lingkungan.form');
    }
}
