<?php

namespace App\Http\Livewire\Datamaster\Tarif\Meterair;

use App\Models\TarifMeterAir;
use App\Models\TarifMeterAirDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $jenis = [], $tanggalBerlaku, $sk, $keterangan, $diameter, $data, $key;

    protected $queryString = ['key'];

    protected $rules = [
        'tanggalBerlaku' => 'required|date',
        'sk' => 'required',
        'keterangan' => 'required',
        'diameter' => 'required|numeric',
        'jenis' => 'required',
        'jenis.*.jenis' => 'required|distinct',
        'jenis.*.nilai' => 'required|numeric',
    ];

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            $this->data->tanggal_berlaku = $this->tanggalBerlaku;
            $this->data->sk = $this->sk;
            $this->data->keterangan = $this->keterangan;
            $this->data->diameter_id = $this->diameter;
            $this->data->save();

            TarifMeterAirDetail::where('tarif_meter_air_id', $this->data->id)->delete();
            TarifMeterAirDetail::insert(collect($this->jenis)->map(fn($q) => [
                'tarif_meter_air_id' => $this->data->id,
                'jenis' => $q['jenis'],
                'nilai' => $q['nilai'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.tarif.meterair'));
    }

    public function tambahJenis()
    {
        $this->jenis[] = [
            'jenis' => null,
            'max_pakai' => null,
            'nilai' => null,
        ];
    }

    public function hapusJenis($i)
    {
        unset($this->jenis[$i]);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = TarifMeterAir::findOrFail($this->key);
            $this->tanggalBerlaku = $this->data->tanggal_berlaku;
            $this->sk = $this->data->sk;
            $this->keterangan = $this->data->keterangan;
            $this->diameter = $this->data->diameter_id;
            $this->jenis = $this->data->tarifMeterAirDetail->toArray();
        } else {
            $this->data = new TarifMeterAir();
            $this->tanggalBerlaku = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.datamaster.tarif.meterair.form');
    }
}
