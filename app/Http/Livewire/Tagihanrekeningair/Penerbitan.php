<?php

namespace App\Http\Livewire\Tagihanrekeningair;

use App\Models\BacaMeter;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use App\Models\TarifMaterai;
use App\Models\TarifProgresif;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Penerbitan extends Component
{
    public $pelanggan, $golongan, $standLalu, $standIni, $statusBaca, $catatan, $pelangganId, $tahun, $bulan, $dataTarifProgresif, $dataTarifMaterai;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
        $this->dataTarifProgresif = TarifProgresif::with('tarifProgresifDetail')->withTrashed()->get();
        $this->dataTarifMaterai = TarifMaterai::withTrashed()->get();
    }

    public function updatedPelangganId()
    {
        $this->setPelanggan();
    }

    public function setPelanggan()
    {
        $this->pelanggan = Pelanggan::findOrFail($this->pelangganId);
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

        if (BacaMeter::where('pelanggan_id', $this->pelanggan->id)->where('periode', $this->tahun . '-' . $this->bulan . '-01')->count() > 0) {
            session()->flash('danger', 'Rekening air periode ' . $this->tahun . '-' . $this->bulan . ' untuk pelanggan ini sudah ada');
        }
        $pakai = $this->standIni - $this->standLalu;
        if ($pakai >= 0) {
            $tarifProgresif = $this->dataTarifProgresif->where('tanggal_berlaku', '<=', $this->tahun . '-' . $this->bulan . '-01')->where('golongan_id', $this->golongan)->first()->tarifProgresifDetail;

            $hargaAir = 0;
            $sisa = $m3 = $pakai;

            if ($tarifProgresif) {
                if ($m3 <= $tarifProgresif->first()->max_pakai) {
                    $hargaAir += 10 * (float) $tarifProgresif->first()->nilai;
                } else {
                    $i = 0;
                    $progresif = [];
                    foreach ($tarifProgresif as $tarif) {
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

            DB::transaction(function () use ($hargaAir) {
                $bacaMeter = new BacaMeter();
                $bacaMeter->periode = $this->tahun . '-' . $this->bulan . '-01';
                $bacaMeter->stand_lalu = $this->standLalu;
                $bacaMeter->stand_ini = $this->standIni;
                $bacaMeter->status_baca = $this->statusBaca;
                $bacaMeter->tanggal_baca = now();
                $bacaMeter->latitude = $this->pelanggan->latitude;
                $bacaMeter->longitude = $this->pelanggan->longitude;
                $bacaMeter->pelanggan_id = $this->pelangganId;
                $bacaMeter->pembaca_id = $this->pelanggan->pembaca_id;
                $bacaMeter->pengguna_id = auth()->id();
                $bacaMeter->created_at = now();
                $bacaMeter->updated_at = now();
                $bacaMeter->save();

                $rekeningAir = new RekeningAir();
                $rekeningAir->harga_air = $hargaAir;
                $rekeningAir->biaya_denda = 0;
                $rekeningAir->biaya_lainnya = $biayaLainnya;
                $rekeningAir->biaya_meter_air = $biayaMeterAir;
                $rekeningAir->biaya_materai = $biayaMaterai;
                $rekeningAir->biaya_ppn = $biayaPpn;
                $rekeningAir->diskon = $diskon;
                $rekeningAir->golongan_id = $row->pelanggan->golongan_id;
                $rekeningAir->baca_meter_id = $row->id;
                $rekeningAir->jalan_id = $row->pelanggan->jalan_id;
                $rekeningAir->tarif_denda_id = $this->tarifDenda ? $this->tarifDenda->id : null;
                $rekeningAir->tarif_lainnya_id = $row->pelanggan->tarif_lainnya_id;
                $rekeningAir->tarif_materai_id = $this->tarifMaterai ? $this->tarifMaterai->id : null;
                $rekeningAir->tarif_meter_air_id = $row->pelanggan->diameter->tarifMeterAir ? $row->pelanggan->diameter->tarifMeterAir->id : null;
                $rekeningAir->tarif_progresif_id = $row->pelanggan->golongan->tarifProgresif->id;
                $rekeningAir->pengguna_id = auth()->id();
                $rekeningAir->created_at = now();
                $rekeningAir->updated_at = now();
                $rekeningAir->save();
            });

            $tarifMaterai = $this->dataTarifMaterai->where('tanggal_berlaku', '<=', $this->dataRekeningAir[$id]['periode'])->where('min_tagihan', '<=', $hargaAir + $this->dataRekeningAir[$id]['biaya_lainnya'] + $this->dataRekeningAir[$id]['biaya_meter_air'])->first();
            if ($tarifMaterai) {
                $this->dataRekeningAir[$id]['biaya_materai_baru'] = $tarifMaterai->nilai;
            } else {
                $this->dataRekeningAir[$id]['biaya_materai_baru'] = 0;
            }
            $this->dataRekeningAir[$id]['update'] = 1;
        }
    }

    public function render()
    {
        return view('livewire.tagihanrekeningair.penerbitan');
    }
}
