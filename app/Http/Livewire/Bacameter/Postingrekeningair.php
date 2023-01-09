<?php

namespace App\Http\Livewire\Bacameter;

use App\Models\BacaMeter;
use App\Models\Ira;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use App\Models\TarifDenda;
use App\Models\TarifMaterai;
use App\Models\TarifProgresif;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Postingrekeningair extends Component
{
    public $bulan, $tahun, $proses, $tarifDenda, $tarifMaterai;

    public function mount()
    {
        $this->bulan = $this->bulan ?: date('m');
        $this->tahun = $this->tahun ?: date('Y');

        $this->tarifDenda = TarifDenda::where('tanggal_berlaku', '<=', date('Y-m-d'))->orderBy('tanggal_berlaku', 'desc')->first();
        $this->tarifMaterai = TarifMaterai::where('tanggal_berlaku', '<=', date('Y-m-d'))->orderBy('tanggal_berlaku', 'desc')->first();
    }

    public function setProses($proses = null)
    {
        $this->validate([
            "bulan" => "required",
            "tahun" => "required",
        ]);

        if (RekeningAir::whereHas('bacaMeter', fn($q) => $q->where('periode', $this->tahun . "-" . $this->bulan . "-01"))->count() > 0) {
            session()->flash('danger', 'Data rekening air periode ' . $this->tahun . '-' . $this->bulan . ' ini sudah ada');
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
        $posting = true;

        if (Pelanggan::select('golongan_id')->whereNotIn('golongan_id', TarifProgresif::select('golongan_id')->groupBy('golongan_id')->get()->pluck('golongan_id'))->groupBy('golongan_id')->get()->count() > 0) {
            session()->flash('danger', 'Terdapat golongan pelanggan yang tidak memiliki tarif progresif');
            $posting = false;
        }

        if ($posting == true) {
            DB::transaction(function ($q) {
                RekeningAir::belumBayar()->whereHas('bacaMeter', fn($q) => $q->where('periode', $this->tahun . "-" . $this->bulan . "-01"))->forceDelete();

                $dataBacaMeter = BacaMeter::whereHas('rekeningAir', fn($q) => $q->belumBayar())->with('pelanggan.golongan.tarifProgresif.tarifProgresifDetail')->with('pelanggan.diameter.tarifMeterAir.tarifMeterAirDetail')->with('pelanggan.tarifLainnya.tarifLainnyaDetail')->where('periode', $this->tahun . "-" . $this->bulan . "-01")->get();

                $dataRekeningAir = [];

                foreach ($dataBacaMeter as $key => $row) {
                    $hargaAir = 0;
                    $biayaMaterai = 0;
                    $biayaPpn = 0;
                    $diskon = 0;
                    $sisa = $m3 = $row->stand_ini - $row->stand_lalu;
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

                    if ($this->tarifMaterai->count() > 0) {
                        if ($hargaAir >= $this->tarifMaterai->min_harga_air) {
                            $biayaMaterai = $this->tarifMaterai->nilai;
                        }
                    }

                    array_push($dataRekeningAir, [
                        'pakai' => $row->stand_ini - $row->stand_lalu,
                        'harga_air' => $hargaAir,
                        'biaya_denda' => 0,
                        'biaya_lainnya' => $biayaLainnya,
                        'biaya_meter_air' => $biayaMeterAir,
                        'biaya_materai' => $biayaMaterai,
                        'biaya_ppn' => $biayaPpn,
                        'diskon' => $diskon,
                        'golongan_id' => $row->pelanggan->golongan_id,
                        'baca_meter_id' => $row->id,
                        'jalan_id' => $row->pelanggan->jalan_id,
                        'tarif_denda_id' => $this->tarifDenda ? $this->tarifDenda->id : null,
                        'tarif_lainnya_id' => $row->pelanggan->tarif_lainnya_id,
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

                $dataRekening = Pelanggan::where('tanggal_pasang', '<', Carbon::parse($this->tahun . '-' . $this->bulan . '-01')->format('Y-m-d'))->with(['rekeningAirTerakhir' => fn($q) => $q->where('periode', $this->tahun . '-' . $this->bulan . '-01')])->with('rekeningAirTerakhir.bacaMeter')->with('jalan')->get();

                $dataIra = [];
                foreach ($dataRekening as $row) {
                    array_push($dataIra, [
                        'status_pelanggan' => $row->status,
                        'periode' => $this->tahun . '-' . $this->bulan . '-01',
                        'stand_lalu' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->bacaMeter->stand_lalu : null,
                        'stand_ini' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->bacaMeter->stand_ini : null,
                        'harga_air' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->harga_air : 0,
                        'biaya_denda' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->biaya_denda : 0,
                        'biaya_lainnya' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->biaya_lainnya : 0,
                        'biaya_meter_air' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->biaya_meter_air : 0,
                        'biaya_materai' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->biaya_materai : 0,
                        'biaya_ppn' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->biaya_ppn : 0,
                        'diskon' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->diskon : 0,
                        'golongan_id' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->golongan_id : 0,
                        'jalan_id' => $row->rekeningAirTerakhir ? $row->rekeningAirTerakhir->jalan_id : 0,
                        'id_pelanggan' => $row->getKey(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                $chunk = collect($dataIra)->chunk(1000);
                foreach ($chunk as $rekap) {
                    Ira::insert($rekap->toArray());
                }

                session()->flash('success', 'Data rekening air periode ' . $this->tahun . '-' . $this->bulan . ' berhasil diposting');
            });
        }
        $this->reset('proses');
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
