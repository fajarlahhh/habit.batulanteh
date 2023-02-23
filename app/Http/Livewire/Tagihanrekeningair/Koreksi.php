<?php

namespace App\Http\Livewire\Tagihanrekeningair;

use App\Models\BacaMeter;
use App\Models\KoreksiRekeningAir;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use App\Models\TarifMaterai;
use App\Models\TarifProgresif;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Koreksi extends Component
{
    public $pelanggan, $catatan, $pelangganId, $dataRekeningAir = [], $tahun, $dataTarifProgresif, $dataTarifMaterai;

    public function mount()
    {
        $this->tahun = date('Y');
        $this->dataTarifProgresif = TarifProgresif::with('tarifProgresifDetail')->withTrashed()->get();
        $this->dataTarifMaterai = TarifMaterai::withTrashed()->get();
    }

    public function updatedTahun()
    {
        if ($this->pelanggan) {
            $this->setDataRekeningAir();
        }
    }

    public function updatedPelangganId()
    {
        $this->setPelanggan();
    }

    public function setPelanggan()
    {
        $this->pelanggan = Pelanggan::with('rekeningAir.golongan')->findOrFail($this->pelangganId);
        $this->dataRekeningAir = $this->pelanggan->rekeningAir;
        $this->setDataRekeningAir();
    }

    public function setDataRekeningAir()
    {
        $this->dataRekeningAir = [];
        $this->dataRekeningAir = collect($this->dataRekeningAir)->filter(fn($q) => false !== stristr($q->periode, $this->tahun))->map(fn($q) => [
            'periode' => $q->periode,
            'stand_lalu_lama' => $q->stand_lalu,
            'stand_ini_lama' => $q->stand_ini,
            'stand_angkat_lama' => $q->stand_angkat,
            'stand_pasang_lama' => $q->stand_pasang,
            'harga_air_lama' => $q->harga_air,
            'biaya_materai_lama' => $q->biaya_materai,
            'stand_lalu_baru' => $q->stand_lalu,
            'stand_ini_baru' => $q->stand_ini,
            'stand_angkat_baru' => $q->stand_angkat,
            'stand_pasang_baru' => $q->stand_pasang,
            'harga_air_baru' => $q->rekeningAir->harga_air,
            'biaya_materai_baru' => $q->rekeningAir->biaya_materai,
            'biaya_lainnya' => $q->rekeningAir->biaya_lainnya,
            'biaya_meter_air' => $q->rekeningAir->biaya_meter_air,
            'kasir' => $q->rekeningAir->kasir,
            'waktu_bayar' => $q->rekeningAir->waktu_bayar,
            'angsur' => $q->rekeningAir->angsuranRekeningAirPeriode ? 1 : 0,
            'rekening_air_id' => $q->rekeningAir->id,
            'baca_meter_id' => $q->id,
            'golongan_id_lama' => $q->rekeningAir->golongan_id,
            'golongan_id_baru' => $q->rekeningAir->golongan_id,
            'update' => 0,
            'data_tarif' => $this->dataTarifProgresif->where('tanggal_berlaku', '<=', $q->periode)->count() == 0 ? 0 : 1,
        ])->toArray();
    }

    public function setHargaAir($id)
    {
        $total = sizeof($this->dataRekeningAir);
        if ($total - $id > 1) {
            $this->dataRekeningAir[$id + 1]['stand_lalu_baru'] = $this->dataRekeningAir[$id]['stand_ini_baru'];
            $this->setHargaAir($id + 1);
        }

        $pakai = $this->dataRekeningAir[$id]['stand_ini_baru'] - $this->dataRekeningAir[$id]['stand_lalu_baru'];
        if ($pakai >= 0) {
            $tarifProgresif = $this->dataTarifProgresif->where('tanggal_berlaku', '<=', $this->dataRekeningAir[$id]['periode'])->where('golongan_id', $this->dataRekeningAir[$id]['golongan_id_baru'])->sortByDesc('tanggal_berlaku')->first()->tarifProgresifDetail;

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

            $this->dataRekeningAir[$id]['harga_air_baru'] = $hargaAir;

            $tarifMaterai = $this->dataTarifMaterai->where('tanggal_berlaku', '<=', $this->dataRekeningAir[$id]['periode'])->where('min_tagihan', '<=', $hargaAir + $this->dataRekeningAir[$id]['biaya_lainnya'] + $this->dataRekeningAir[$id]['biaya_meter_air'])->first();
            if ($tarifMaterai) {
                $this->dataRekeningAir[$id]['biaya_materai_baru'] = $tarifMaterai->nilai;
            } else {
                $this->dataRekeningAir[$id]['biaya_materai_baru'] = 0;
            }
            $this->dataRekeningAir[$id]['update'] = 1;
        }
    }

    public function submit()
    {
        $this->validate([
            'pelangganId' => 'required||numeric',
            'catatan' => 'required',
            'dataRekeningAir' => 'required',
        ]);

        DB::transaction(function () {
            KoreksiRekeningAir::insert(collect($this->dataRekeningAir)->where('update', 1)->map(fn($q) => [
                'stand_lalu_lama' => $q['stand_lalu_lama'],
                'stand_ini_lama' => $q['stand_ini_lama'],
                'harga_air_lama' => $q['harga_air_lama'],
                'biaya_materai_lama' => $q['biaya_materai_lama'],
                'stand_lalu_baru' => $q['stand_lalu_baru'],
                'stand_ini_baru' => $q['stand_ini_baru'],
                'harga_air_baru' => $q['harga_air_baru'],
                'biaya_materai_baru' => $q['biaya_materai_baru'],
                'catatan' => $this->catatan,
                'rekening_air_id' => $q['rekening_air_id'],
                'golongan_id_lama' => $q['golongan_id_lama'],
                'golongan_id_baru' => $q['golongan_id_baru'],
                'pengguna_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray());

            foreach (collect($this->dataRekeningAir)->where('update', 1)->all() as $index => $row) {
                RekeningAir::where('id', $row['rekening_air_id'])->belumBayar()->update([
                    'stand_lalu' => $row['stand_lalu_baru'],
                    'stand_ini' => $row['stand_ini_baru'],
                    'harga_air' => $row['harga_air_baru'],
                    'golongan_id' => $row['golongan_id_baru'],
                    'biaya_materai' => $row['biaya_materai_baru'],
                    'pengguna_id' => auth()->id(),
                    'updated_at' => now(),
                ]);
            }
        });
        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('tagihanrekeningair.koreksi'));
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.tagihanrekeningair.koreksi');
    }
}
