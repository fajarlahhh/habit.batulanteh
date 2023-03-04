<?php

namespace App\Http\Livewire\Tagihanrekeningair;

use App\Models\BacaMeter;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use App\Models\TarifDenda;
use App\Models\TarifLainnya;
use App\Models\TarifMaterai;
use App\Models\TarifMeterAir;
use App\Models\TarifProgresif;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Penerbitan extends Component
{
    public $pelanggan, $golongan, $standLalu, $standIni, $standAngkat, $standPasang, $statusBaca, $catatan, $pelangganId, $tahun, $bulan, $dataTarifProgresif, $dataTarifMaterai, $dataTarifDenda, $dataTarifLainnya, $dataTarifMeterAir;

    public function mount()
    {
        $this->bulan = $this->bulan?:date('m');
        $this->tahun = $this->tahun?:date('Y');
        $this->dataTarifProgresif = TarifProgresif::with('tarifProgresifDetail')->withTrashed()->get();
        $this->dataTarifMaterai = TarifMaterai::withTrashed()->get();
        $this->dataTarifDenda = TarifDenda::withTrashed()->get();
        $this->dataTarifLainnya = TarifLainnya::with('tarifLainnyaDetail')->withTrashed()->get();
        $this->dataTarifMeterAir = TarifMeterAir::with('tarifMeterAirDetail')->withTrashed()->get();
    }

    public function updatedPelangganId()
    {
        $this->setPelanggan();
    }

    public function setPelanggan()
    {
        $this->pelanggan = Pelanggan::findOrFail($this->pelangganId);
        $this->golongan = $this->pelanggan->golongan_id;
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function submit()
    {
        $this->validate([
            'pelangganId' => 'required|numeric',
            'catatan' => 'required',
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
            'golongan' => 'required|numeric',
            'standLalu' => 'required|numeric',
            'standIni' => 'required|numeric',
            'statusBaca' => 'required',
        ]);
        if (date('Ymd') < $this->tahun . substr('0' . $this->bulan, -2) . '01') {
            session()->flash('danger', 'Periode ' . $this->tahun . '-' . $this->bulan . ' belum saatnya terbit');
        } else if (BacaMeter::where('pelanggan_id', $this->pelanggan->id)->withoutGlobalScopes()->where('periode', $this->tahun . '-' . $this->bulan . '-01')->count() > 0) {
            session()->flash('danger', 'Rekening air periode ' . $this->tahun . '-' . $this->bulan . ' untuk pelanggan ini sudah ada');
        } else {
            DB::transaction(function () {
                $pakai = $this->standIni - $this->standLalu;
                if ($pakai >= 0) {
                    $tarifProgresif = $this->dataTarifProgresif->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->where('golongan_id', $this->golongan)->sortByDesc('tanggal_berlaku')->first();

                    $tarifDenda = $this->dataTarifDenda->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->sortByDesc('tanggal_berlaku')->count() > 0 ? $this->dataTarifDenda->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->sortByDesc('tanggal_berlaku')->first()->id : null;

                    $tarifMeterAir = $this->dataTarifMeterAir->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->sortByDesc('tanggal_berlaku')->count() > 0 ? $this->dataTarifMeterAir->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->sortByDesc('tanggal_berlaku')->first() : null;

                    $tarifLainnya = $this->dataTarifLainnya->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->sortByDesc('tanggal_berlaku')->count() ? $this->dataTarifLainnya->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->sortByDesc('tanggal_berlaku')->first() : null;

                    $hargaAir = 0;
                    $biayaLainnya = $tarifLainnya ? $tarifLainnya->tarifLainnyaDetail->sum('nilai') : 0;
                    $biayaMeterAir = $tarifMeterAir ? $tarifMeterAir->tarifMeterAirDetail->sum('nilai') : 0;
                    $biayaMaterai = 0;

                    $sisa = $m3 = $pakai;

                    if ($tarifProgresif->tarifProgresifDetail) {
                        if ($m3 <= $tarifProgresif->tarifProgresifDetail->first()->max_pakai) {
                            $hargaAir += 10 * (float) $tarifProgresif->tarifProgresifDetail->first()->nilai;
                        } else {
                            $i = 0;
                            $progresif = [];
                            foreach ($tarifProgresif->tarifProgresifDetail as $tarif) {
                                $minPakai = $tarif->min_pakai;
                                $maxPakai = $tarif->max_pakai;
                                $nilai = $tarif->nilai;

                                if ($i == 0) {
                                    $dif = $maxPakai - ($minPakai == 0 ? 0 : ($minPakai));
                                } else {
                                    $dif = $maxPakai - ($minPakai == 0 ? 0 : ($minPakai - 1));
                                }

                                $progresif[] = ($m3 < $maxPakai ? $sisa * $nilai : $dif * $nilai);

                                $sisa = (($m3 - $maxPakai) >= 0 ? $m3 - $maxPakai : 0);
                                $i++;
                            }

                            for ($i = 0; $i < count($progresif); $i++) {
                                $hargaAir += $progresif[$i];
                            }
                        }
                    }

                    $tarifMaterai = $this->dataTarifMaterai->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->where('min_tagihan', '<=', $hargaAir + $biayaLainnya + $biayaMeterAir)->first();
                    if ($tarifMaterai) {
                        $biayaMaterai = $tarifMaterai->nilai;
                    }

                    $bacaMeter = new BacaMeter();
                    $bacaMeter->periode = $this->tahun . '-' . $this->bulan . '-01';
                    $bacaMeter->stand_lalu = $this->standLalu;
                    $bacaMeter->stand_ini = $this->standIni;
                    $bacaMeter->stand_angkat = $this->standAngkat;
                    $bacaMeter->stand_pasang = $this->standPasang;
                    $bacaMeter->status_baca = $this->statusBaca;
                    $bacaMeter->tanggal_baca = now();
                    $bacaMeter->latitude = $this->pelanggan->latitude;
                    $bacaMeter->longitude = $this->pelanggan->longitude;
                    $bacaMeter->pelanggan_id = $this->pelangganId;
                    $bacaMeter->rayon_id = $this->pelanggan->rayon_id;
                    $bacaMeter->pembaca_id = $this->pelanggan->rayon->ruteBaca->pembaca_id;
                    $bacaMeter->pengguna_id = auth()->id();
                    $bacaMeter->created_at = now();
                    $bacaMeter->updated_at = now();
                    $bacaMeter->save();

                    $rekeningAir = new RekeningAir();
                    $rekeningAir->periode = $this->tahun . '-' . $this->bulan . '-01';
                    $rekeningAir->stand_lalu = $this->standLalu;
                    $rekeningAir->stand_ini = $this->standIni;
                    $rekeningAir->stand_angkat = $this->standAngkat;
                    $rekeningAir->stand_pasang = $this->standPasang;
                    $rekeningAir->harga_air = $hargaAir;
                    $rekeningAir->biaya_denda = 0;
                    $rekeningAir->biaya_lainnya = $biayaLainnya;
                    $rekeningAir->biaya_meter_air = $biayaMeterAir;
                    $rekeningAir->biaya_materai = $biayaMaterai;
                    $rekeningAir->biaya_ppn = 0;
                    $rekeningAir->diskon = 0;
                    $rekeningAir->keterangan = $this->catatan;
                    $rekeningAir->pelanggan_id = $this->pelangganId;
                    $rekeningAir->rayon_id = $this->pelanggan->rayon_id;
                    $rekeningAir->golongan_id = $this->golongan;
                    $rekeningAir->tarif_denda_id = $tarifDenda;
                    $rekeningAir->tarif_lainnya_id = $tarifLainnya ? $tarifLainnya->id : null;
                    $rekeningAir->tarif_materai_id = $tarifMaterai ? $tarifMaterai->id : null;
                    $rekeningAir->tarif_meter_air_id = $tarifMeterAir ? $tarifMeterAir->id : null;
                    $rekeningAir->tarif_progresif_id = $tarifProgresif->id;
                    $rekeningAir->baca_meter_id = $bacaMeter->id;
                    $rekeningAir->pengguna_id = auth()->id();
                    $rekeningAir->created_at = now();
                    $rekeningAir->updated_at = now();
                    $rekeningAir->save();
                }
                session()->flash('success', 'Berhasil menyimpan data');
            });
            return $this->redirect('/tagihanrekeningair/penerbitan');
        }
    }

    public function render()
    {
        return view('livewire.tagihanrekeningair.penerbitan');
    }
}
