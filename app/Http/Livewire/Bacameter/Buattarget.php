<?php

namespace App\Http\Livewire\Bacameter;

use App\Models\BacaMeter;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Buattarget extends Component
{
    public $bulan, $tahun, $proses;

    public function mount()
    {
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');
    }

    public function setProses($proses = null)
    {
        $this->validate([
            "bulan" => "required",
            "tahun" => "required",
        ]);

        if (BacaMeter::where('periode', $this->tahun . "-" . $this->bulan . "-01")->count() > 0) {
            session()->flash('danger', 'Data bacaan periode ' . $this->tahun . '-' . $this->bulan . ' ini sudah ada');
        }

        $this->proses = $proses;
    }

    public function submit()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '6144M');

        $this->validate([
            "bulan" => "required",
            "tahun" => "required",
        ]);

        DB::transaction(function ($q) {
            BacaMeter::whereNull('tanggal_baca')->where('periode', $this->tahun.'-'.$this->bulan.'-01')->forceDelete();
            $pelanggan = Pelanggan::with('rekeningAirTerakhir')->whereIn('status', [1, 3])->get();
            $data = [];
            foreach ($pelanggan as $key => $row) {
                array_push($data, [
                    'periode' => $this->tahun . '-' . $this->bulan . '-01',
                    'stand_lalu' => $row->rekening_air_terakhir ? $row->rekening_air_terakhir->stand_ini : 0,
                    'latitude' => $row->latitude,
                    'longitude' => $row->longitude,
                    'pelanggan_id' => $row->id,
                    'pembaca_id' => $row->pembaca_id,
                    'pengguna_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $insert = collect($data)->chunk(2000);
            foreach ($insert as $row) {
                BacaMeter::insert($row->toArray());
            }

            BacaMeter::where('pelanggan_id', $pelanggan->where('status', 3)->pluck('id')->all())->where('periode', $this->tahun . '-' . $this->bulan . '-01')->update([
                'stand_ini' => 0,
                'status_baca' => 'PUTUS SEMENTAR PERMINTAAN SENDIRI',
                'tanggal_baca' => now(),
            ]);
            session()->flash('success', 'Data bacaan periode ' . $this->tahun . '-' . $this->bulan . ' berhasil dibuat');
        });
        $this->reset('proses');
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.bacameter.buattarget');
    }
}
