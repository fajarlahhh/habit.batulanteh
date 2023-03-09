<?php

namespace App\Http\Livewire\Bacameter;

use App\Models\Ira;
use App\Models\Dspl;
use Livewire\Component;
use App\Models\BacaMeter;
use App\Models\Pelanggan;
use App\Models\TarifDenda;
use App\Models\RekeningAir;
use App\Models\TarifMaterai;
use App\Models\TarifProgresif;
use Illuminate\Support\Facades\DB;

class Postingrekeningair extends Component
{
    public $bulan, $tahun, $tarifDenda, $tarifMaterai;

    public function mount()
    {
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');

        $this->tarifDenda = TarifDenda::where('tanggal_berlaku', '<=', date('Y-m-d'))->orderBy('tanggal_berlaku', 'desc')->first();
        $this->tarifMaterai = TarifMaterai::where('tanggal_berlaku', '<=', date('Y-m-d'))->orderBy('tanggal_berlaku', 'desc')->first();
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

        $golongan = Pelanggan::whereNotIn('golongan_id', TarifProgresif::select('golongan_id')->groupBy('golongan_id')->get()->pluck('golongan_id'))->get();
        if ($golongan->count() > 0) {
            session()->flash('danger', 'Tarif pelanggan ' . $golongan->pluck('no_langganan')->implode(', ') . ' tidak ada');
            return $this->render();
        }

        if (RekeningAir::withoutGlobalScopes()->where('periode', $this->tahun . "-" . $this->bulan . "-01")->count() > 0) {
            session()->flash('danger', 'Data rekening air periode ' . $this->tahun . '-' . $this->bulan . ' ini sudah ada');
            return $this->render();
        }

        if (BacaMeter::whereNull('stand_ini')->where('periode', $this->tahun . "-" . $this->bulan . "-01")->get()->count() > 0) {
            session()->flash('danger', 'Terdapat target baca yang belum memiliki stand ini');
            return $this->render();
        }

        DB::transaction(function ($q) {
            RekeningAir::belumBayar()->whereHas('bacaMeter', fn ($q) => $q->where('periode', $this->tahun . "-" . $this->bulan . "-01"))->forceDelete();

            $dataBacaMeter = BacaMeter::with('pelanggan.golongan.tarifProgresif.tarifProgresifDetail')->with('pelanggan.diameter.tarifMeterAir.tarifMeterAirDetail')->with('pelanggan.tarifLainnya.tarifLainnyaDetail')->where('periode', $this->tahun . "-" . $this->bulan . "-01")->get();

            $dataRekeningAir = [];

            foreach ($dataBacaMeter as $key => $row) {
                $pakai = $row->stand_pasang || $row->stand_angkat ? ($row->stand_ini - $row->stand_pasang) + ($row->stand_angkat - $row->stand_lalu) : $row->stand_ini - $row->stand_lalu;
                $hargaAir = 0;
                $biayaMaterai = 0;
                $biayaPpn = 0;
                $diskon = 0;
                $sisa = $m3 = $pakai;
                $tarifProgresif = $row->pelanggan->golongan->tarifProgresif->tarifProgresifDetail;

                if ($tarifProgresif->count() > 0) {
                    if ($m3 <= 10) {
                        $hargaAir = 10 * $tarifProgresif->first()->nilai;
                    } else {
                        $hargaAirProgresif = [];
                        foreach ($tarifProgresif as $key => $tarif) {
                            $minPakai = $tarif->min_pakai;
                            $maxPakai = $tarif->max_pakai;
                            $nilai = $tarif->nilai;

                            if ($key == 0) {
                                $dif = $maxPakai - ($minPakai == 0 ? 0 : ($minPakai));
                            } else {
                                $dif = $maxPakai - ($minPakai == 0 ? 0 : ($minPakai - 1));
                            }

                            $hargaAirProgresif[] = ($m3 < $maxPakai ? $sisa * $nilai : $dif * $nilai);

                            $sisa = (($m3 - $maxPakai) >= 0 ? $m3 - $maxPakai : 0);
                        }
                        $hargaAir = collect($hargaAirProgresif)->sum();
                    }
                }

                $biayaLainnya = $row->pelanggan->tarifLainnya ? $row->pelanggan->tarifLainnya->tarifLainnyaDetail->sum('nilai') : 0;
                $biayaMeterAir = $row->pelanggan->diameter->tarifMeterAir ? $row->pelanggan->diameter->tarifMeterAir->tarifMeterAirDetail->sum('nilai') : 0;

                if ($this->tarifMaterai) {
                    if ($hargaAir >= $this->tarifMaterai->min_harga_air) {
                        $biayaMaterai = $this->tarifMaterai->nilai;
                    }
                }

                array_push($dataRekeningAir, [
                    'periode' => $this->tahun . '-' . $this->bulan . '-01',
                    'stand_lalu' => $row->stand_lalu,
                    'stand_ini' => $row->stand_ini,
                    'stand_angkat' => $row->stand_angkat,
                    'stand_pasang' => $row->stand_pasang,
                    'harga_air' => $row->status_baca == 'SEGEL' ? 0 : $hargaAir, // Untuk pelanggan pSEGEL tidak dikenakan harga air
                    'biaya_denda' => 0,
                    'biaya_lainnya' => $biayaLainnya,
                    'biaya_meter_air' => $biayaMeterAir,
                    'biaya_materai' => $biayaMaterai,
                    'biaya_ppn' => $biayaPpn,
                    'diskon' => $diskon,
                    'golongan_id' => $row->pelanggan->golongan_id,
                    'baca_meter_id' => $row->id,
                    'pelanggan_id' => $row->pelanggan_id,
                    'rayon_id' => $row->rayon_id,
                    'tarif_denda_id' => $this->tarifDenda ? $this->tarifDenda->id : null,
                    'tarif_materai_id' => $this->tarifMaterai ? $this->tarifMaterai->id : null,
                    'tarif_meter_air_id' => $row->pelanggan->diameter->tarifMeterAir ? $row->pelanggan->diameter->tarifMeterAir->id : null,
                    'tarif_progresif_id' => $row->pelanggan->golongan->tarifProgresif->id,
                    'pengguna_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $rekeningAir = collect($dataRekeningAir)->chunk(2000);
            foreach ($rekeningAir as $row) {
                RekeningAir::insert($row->toArray());
            }
            Ira::where('periode', $this->tahun . '-' . $this->bulan . '-01')->delete();

            $ira = collect($dataRekeningAir)->map(fn ($q) => [
                'periode' => $this->tahun . '-' . $this->bulan . '-01',
                'stand_lalu' => $q['stand_lalu'],
                'stand_ini' => $q['stand_ini'],
                'stand_angkat' => $q['stand_angkat'],
                'stand_pasang' => $q['stand_pasang'],
                'harga_air' => $q['harga_air'],
                'biaya_denda' => $q['biaya_denda'],
                'biaya_lainnya' => $q['biaya_lainnya'],
                'biaya_meter_air' => $q['biaya_meter_air'],
                'biaya_materai' => $q['biaya_materai'],
                'biaya_ppn' => $q['biaya_ppn'],
                'diskon' => $q['diskon'],
                'golongan_id' => $q['golongan_id'],
                'rayon_id' => $q['rayon_id'],
                'pelanggan_id' => $q['pelanggan_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ])->chunk(1000);

            $ira[] = Pelanggan::with('rayon')->whereIn('status', [3])->get()->map(fn ($q) => [
                'periode' => $this->tahun . '-' . $this->bulan . '-01',
                'stand_lalu' => null,
                'stand_ini' => null,
                'stand_angkat' => null,
                'stand_pasang' => null,
                'harga_air' => null,
                'biaya_denda' => null,
                'biaya_lainnya' => null,
                'biaya_meter_air' => null,
                'biaya_materai' => null,
                'biaya_ppn' => null,
                'diskon' => null,
                'golongan_id' => $q->golongan_id,
                'rayon_id' => $q->rayon_id,
                'pelanggan_id' => $q->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($ira as $row) {
                Ira::insert($row->toArray());
            }

            $dspl = RekeningAir::belumBayar()->with('pelanggan')->get()->map(fn($q) => [
                'periode' => date('Y-m-1'),
                'status_pelanggan' => $q->pelanggan->status,
                'periode_rekening' => $q->periode,
                'harga_air' => $q->harga_air,
                'biaya_denda' => $q->biaya_denda,
                'biaya_lainnya' => $q->biaya_lainnya,
                'biaya_meter_air' => $q->biaya_meter_air,
                'biaya_materai' => $q->biaya_materai,
                'biaya_ppn' => $q->biaya_ppn,
                'golongan_id' => $q->golongan_id,
                'pelanggan_id' => $q->pelanggan_id,
                'rayon_id' => $q->rayon_id,
                'created_at' => now(),
                'updated_at' => now(),
            ])->chunk(1000);
            
            foreach ($dspl as $row) {
                Dspl::insert($row->toArray());
            }
            session()->flash('success', 'Data rekening air dan IRA periode ' . $this->tahun . '-' . $this->bulan . ' berhasil diposting');
        });
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.bacameter.postingrekeningair');
    }
}
