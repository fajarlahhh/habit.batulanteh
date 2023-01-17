<?php

namespace App\Http\Livewire\Datamaster\Tarif\Pelayanan;

use App\Models\TarifPelayananSangsi;
use Livewire\Component;

class Form extends Component
{
    public $key, $tanggalBerlaku, $jenis, $keterangan, $nilai, $data, $diameterId;

    protected $rules = [
        'tanggalBerlaku' => 'required|date',
        'jenis' => 'required',
        'keterangan' => 'required',
        'nilai' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();

        $this->data->tanggal_berlaku = $this->tanggalBerlaku;
        $this->data->jenis = $this->jenis;
        $this->data->keterangan = $this->keterangan;
        $this->data->nilai = $this->nilai;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('datamaster.tarif.denda'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = TarifPelayananSangsi::findOrFail($this->key);
            $this->tanggalBerlaku = $this->data->tanggal_berlaku;
            $this->jenis = $this->data->jenis;
            $this->keterangan = $this->data->keterangan;
            $this->nilai = $this->data->nilai;
            $this->diameterId = $this->data->diameter_id;
        } else {
            $this->data = new TarifPelayananSangsi();
            $this->tanggalBerlaku = date('Y-m-d');
        }
    }
    public function render()
    {
        return view('livewire.datamaster.tarif.pelayanan.form');
    }
}
