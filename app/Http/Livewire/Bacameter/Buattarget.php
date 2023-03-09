<?php

namespace App\Http\Livewire\Bacameter;

use App\Models\BacaMeter;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Buattarget extends Component
{
    public $bulan, $tahun;

    public function mount()
    {
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');
    }

    public function submit()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $this->validate([
            "bulan" => "required",
            "tahun" => "required",
        ]);

        if (BacaMeter::where('status_baca', '!=', 'SEGEL')->whereNull('tanggal_baca')->where('periode', $this->tahun . "-" . $this->bulan . "-01")->count() > 0) {
            session()->flash('danger', 'Data bacaan periode ' . $this->tahun . '-' . $this->bulan . ' ini sudah terbaca ada');
            return $this->render();
        }
        BacaMeter::where('status_baca', 'SEGEL')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->forceDelete();
        BacaMeter::whereNull('tanggal_baca')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->forceDelete();

        DB::transaction(function () {
            $dataPelanggan = Pelanggan::with('rayon')->whereIn('status', [1, 3])->get();

            $data = [];
            foreach ($dataPelanggan as $key => $row) {
                array_push($data, [
                    'periode' => $this->tahun . '-' . $this->bulan . '-01',
                    'stand_lalu' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->stand_ini : 0,
                    'latitude' => $row->latitude,
                    'longitude' => $row->longitude,
                    'pelanggan_id' => $row->id,
                    'pembaca_id' => $row->rayon->pembaca_id,
                    'rayon_id' => $row->rayon_id,
                    'pengguna_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'stand_ini' => $row->status == 2 ? DB::raw('stand_lalu') : 0,
                    'status_baca' => $row->status == 2 ? 'SEGEL' : null,
                    'tanggal_baca' => $row->status == 2 ? now() : null,
                ]);
            }

            foreach (collect($data)->chunk(2000) as $r) {
                BacaMeter::insert($r->toArray());
            }

            session()->flash('success', 'Data bacaan periode ' . $this->tahun . '-' . $this->bulan . ' berhasil dibuat');
        });
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
