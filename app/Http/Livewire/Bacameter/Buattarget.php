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
        ini_set('memory_limit', '6144M');

        $this->validate([
            "bulan" => "required",
            "tahun" => "required",
        ]);

        // if (BacaMeter::where('periode', $this->tahun . "-" . $this->bulan . "-01")->count() > 0) {
        //     session()->flash('danger', 'Data bacaan periode ' . $this->tahun . '-' . $this->bulan . ' ini sudah ada');
        //     return $this->render();
        // }

        DB::transaction(function ($q) {
            BacaMeter::whereNull('tanggal_baca')->where('periode', $this->tahun . '-' . $this->bulan . '-01')->forceDelete();
            $dataPelanggan = Pelanggan::with('rekeningAirTerakhir')->with('rayon.ruteBaca')->whereIn('status', [1, 3])->get()->map(fn ($q) => [
                [
                    'periode' => $this->tahun . '-' . $this->bulan . '-01',
                    'stand_lalu' => $q->rekeningAir->count() > 0 ? $q->rekeningAir->first()->stand_ini : 0,
                    'latitude' => $q->latitude,
                    'longitude' => $q->longitude,
                    'pelanggan_id' => $q->id,
                    'pembaca_id' => $q->rayon->ruteBaca->pembaca_id,
                    'rayon_id' => $q->rayon_id,
                    'pengguna_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'stand_ini' => $q->status == 3 ? DB::raw('stand_lalu') : 0,
                    'status_baca' => $q->status == 3 ? 'SEGEL' : null,
                    'tanggal_baca' => $q->status == 3 ? now() : null,
                ]
            ]);
            
            $insert = collect($dataPelanggan)->chunk(2000);
            foreach ($insert as $row) {
                BacaMeter::insert($row->toArray());
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
