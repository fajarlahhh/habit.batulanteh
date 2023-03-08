<?php

namespace App\Http\Livewire\Datamaster\Regional\Rayon;

use App\Models\Kelurahan;
use App\Models\Rayon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $nama, $kode, $kelurahan, $data, $key, $dataKelurahan, $bacameter;

    protected $queryString = ['key'];

    protected $rules = [
        'kode' => 'required|digits:4',
        'nama' => 'required',
        'kelurahan' => 'required',
        'bacameter' => 'required'
    ];

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            $this->data->kode = $this->kode;
            $this->data->nama = $this->nama;
            $this->data->pembaca_id = $this->bacameter;
            $this->data->kelurahan_id = $this->kelurahan;
            $this->data->save();
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.rayon'));
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        $this->dataKelurahan = Kelurahan::with('kecamatan')->get()->map(fn ($q) => [
            'id' => $q->id,
            'nama' => $q->nama,
            'nama_kecamatan' => $q->kecamatan->nama,
        ])->sortBy('nama')->toArray();
        if ($this->key) {
            $this->data = Rayon::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
            $this->bacameter = $this->data->pembaca_id;
            $this->kelurahan = $this->data->kelurahan_id;
        } else {
            $this->data = new Rayon();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.regional.rayon.form');
    }
}
