<?php

namespace App\Http\Livewire\Datamaster\Tarif\Materai;

use App\Models\TarifMaterai;
use Livewire\Component;

class Form extends Component
{
    public $key, $tanggalBerlaku, $sk, $keterangan, $nilai, $data, $minTagihan;

    protected $rules = [
        'tanggalBerlaku' => 'required|date',
        'sk' => 'required',
        'keterangan' => 'required',
        'nilai' => 'required|numeric',
        'minTagihan' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->tanggal_berlaku = $this->tanggalBerlaku;
        $this->data->sk = $this->sk;
        $this->data->keterangan = $this->keterangan;
        $this->data->nilai = $this->nilai;
        $this->data->min_tagihan = $this->minTagihan;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.tarif.materai'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = TarifMaterai::findOrFail($this->key);
            $this->tanggalBerlaku = $this->data->tanggal_berlaku;
            $this->sk = $this->data->sk;
            $this->keterangan = $this->data->keterangan;
            $this->nilai = $this->data->nilai;
            $this->minTagihan = $this->data->min_tagihan;
        } else {
            $this->data = new TarifMaterai();
            $this->tanggalBerlaku = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.materai.form');
    }
}
