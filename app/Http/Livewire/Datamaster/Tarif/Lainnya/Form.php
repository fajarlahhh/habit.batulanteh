<?php

namespace App\Http\Livewire\Datamaster\Tarif\Lainnya;

use App\Models\TarifLainnya;
use Livewire\Component;

class Form extends Component
{
    public $key, $tanggalBerlaku, $sk, $keterangan, $nilai, $data, $nama;

    protected $rules = [
        'tanggalBerlaku' => 'required|date',
        'sk' => 'required',
        'keterangan' => 'required',
        'nama' => 'required',
        'nilai' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->tanggal_berlaku = $this->tanggalBerlaku;
        $this->data->sk = $this->sk;
        $this->data->keterangan = $this->keterangan;
        $this->data->nama = $this->nama;
        $this->data->nilai = $this->nilai;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.tarif.lainnya'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = TarifLainnya::findOrFail($this->key);
            $this->tanggalBerlaku = $this->data->tanggal_berlaku;
            $this->nama = $this->data->nama;
            $this->sk = $this->data->sk;
            $this->keterangan = $this->data->keterangan;
            $this->nilai = $this->data->nilai;
        } else {
            $this->data = new TarifLainnya();
            $this->tanggalBerlaku = date('Y-m-d');
        }
    }
    public function render()
    {
        return view('livewire.datamaster.tarif.lainnya.form');
    }
}
