<?php

namespace App\Http\Livewire\Datamaster\Tarif\Progresif;

use App\Models\TarifProgresif;
use App\Models\TarifProgresifDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $progresif = [], $tanggalBerlaku, $sk, $keterangan, $golongan, $data, $key;

    protected $queryString = ['key'];

    protected $rules = [
        'tanggalBerlaku' => 'required|date',
        'sk' => 'required',
        'keterangan' => 'required',
        'golongan' => 'required|numeric',
        'progresif' => 'required',
        'progresif.*.min_pakai' => 'required|numeric|distinct',
        'progresif.*.max_pakai' => 'required|numeric|distinct',
        'progresif.*.nilai' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            $this->data->tanggal_berlaku = $this->tanggalBerlaku;
            $this->data->sk = $this->sk;
            $this->data->keterangan = $this->keterangan;
            $this->data->golongan_id = $this->golongan;
            $this->data->save();

            TarifProgresifDetail::where('tarif_progresif_id', $this->data->id)->delete();
            TarifProgresifDetail::insert(collect($this->progresif)->map(fn($q) => [
                'tarif_progresif_id' => $this->data->id,
                'min_pakai' => $q['min_pakai'],
                'max_pakai' => $q['max_pakai'],
                'nilai' => $q['nilai'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.tarif.progresif'));
    }

    public function tambahProgresif()
    {
        $this->progresif[] = [
            'min_pakai' => null,
            'max_pakai' => null,
            'nilai' => null,
        ];
    }

    public function hapusProgresif($i)
    {
        unset($this->progresif[$i]);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = TarifProgresif::findOrFail($this->key);
            $this->tanggalBerlaku = $this->data->tanggal_berlaku;
            $this->sk = $this->data->sk;
            $this->keterangan = $this->data->keterangan;
            $this->golongan = $this->data->golongan_id;
            $this->progresif = $this->data->tarifProgresifDetail->toArray();
        } else {
            $this->data = new TarifProgresif();
            $this->tanggalBerlaku = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.progresif.form');
    }
}
