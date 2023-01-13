<?php

namespace App\Http\Livewire\Datamaster\Tarif\Pelayanan;

use App\Models\TarifPelayanan;
use Livewire\Component;

class Form extends Component
{
    public $key, $tanggalBerlaku, $sk, $keterangan, $nilai, $data, $diameterId;

    protected $rules = [
        'tanggalBerlaku' => 'required|date',
        'sk' => 'required',
        'keterangan' => 'required',
        'nilai' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->tanggal_berlaku = $this->tanggalBerlaku;
        $this->data->sk = $this->sk;
        $this->data->keterangan = $this->keterangan;
        $this->data->nilai = $this->nilai;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.tarif.denda'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = TarifPelayanan::findOrFail($this->key);
            $this->tanggalBerlaku = $this->data->tanggal_berlaku;
            $this->sk = $this->data->sk;
            $this->keterangan = $this->data->keterangan;
            $this->nilai = $this->data->nilai;
            $this->diameterId = $this->data->diameter_id;
        } else {
            $this->data = new TarifPelayanan();
            $this->tanggalBerlaku = date('Y-m-d');
        }
    }
    public function render()
    {
        return view('livewire.datamaster.tarif.pelayanan.form');
    }
}