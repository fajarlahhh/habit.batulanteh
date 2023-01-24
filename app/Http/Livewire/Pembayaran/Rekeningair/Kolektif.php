<?php

namespace App\Http\Livewire\Pembayaran\Rekeningair;

use App\Models\AngsuranRekeningAir;
use App\Models\AngsuranRekeningAirDetail;
use App\Models\AngsuranRekeningAirPeriode;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Kolektif extends Component
{
    public $dataPelanggan = [], $kolektifId, $dataRekeningAir = [], $keterangan, $dataAngsuranRekeningAir = [], $bayar = 0, $awalRekeningAir = null, $awalAngsuranRekeningAir = null;

    public function updatedKolektifId()
    {
        $this->dataRekeningAir = [];
        $this->dataAngsuranRekeningAir = [];
        $this->dataPelanggan = Pelanggan::whereHas('kolektifDetail', fn($q) => $q->where('kolektif_id', $this->kolektifId))->with(['bacaMeter' => fn($q) => $q->with(['rekeningAir' => fn($r) => $r->with('golongan')->with('angsuranRekeningAirPeriode')])->whereHas('rekeningAir', fn($q) => $q->belumBayar())])->with(['angsuranRekeningAir' => fn($q) => $q->belumLunas()->with(['angsuranRekeningAirDetail' => fn($r) => $r->belumBayar()])])->get();
        $this->setDataRekeningAir();
        $this->setDataAngsuranRekeningAir();
    }

    public function setDataRekeningAir()
    {
        foreach ($this->dataPelanggan as $key => $row) {
            foreach ($row->bacaMeter->whereNotIn('baca_meter_id', collect($this->dataRekeningAir)->pluck('baca_meter_id'))->all() as $key => $subRow) {
                $periode = new Carbon($subRow->periode);
                $denda = $periode->addMonths(1)->day(25)->format('Ymd') < date('Ymd') ? $subRow->rekeningAir->tarifDenda->nilai : 0;
                $this->dataRekeningAir[] = [
                    'baca_meter_id' => $subRow->id,
                    'rekening_air_id' => $subRow->rekeningAir->id,
                    'pelanggan_id' => $subRow->pelanggan_id,
                    'no_langganan' => $subRow->pelanggan->no_langganan,
                    'nama' => $subRow->pelanggan->nama,
                    'alamat' => $subRow->pelanggan->alamat,
                    'periode' => $subRow->periode,
                    'golongan' => $subRow->rekeningAir->golongan->nama,
                    'angsur' => $subRow->rekeningAir->angsuranRekeningAirPeriode ? 1 : 0,
                    'pakai' => $subRow->stand_ini - $subRow->stand_lalu,
                    'tagihan' => $subRow->rekeningAir->harga_air + $subRow->rekeningAir->biaya_denda + $subRow->rekeningAir->biaya_lainnya + $subRow->rekeningAir->biaya_meter_air + $subRow->rekeningAir->biaya_materai,
                    'denda' => $denda,
                ];
            }
        }
    }
    public function setDataAngsuranRekeningAir()
    {
        foreach ($this->dataPelanggan as $key => $row) {
            if ($row->angsuranRekeningAir->count() > 0) {
                foreach ($row->angsuranRekeningAir->first()->angsuranRekeningAirDetail->whereNotIn('angsuran_rekening_air_detail_id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_detail_id'))->all() as $key => $subRow) {
                    $this->dataAngsuranRekeningAir[] = [
                        'angsuran_rekening_air_id' => $subRow->angsuranRekeningAir->id,
                        'angsuran_rekening_air_detail_id' => $subRow->id,
                        'pelanggan_id' => $subRow->angsuranRekeningAir->pelanggan_id,
                        'no_langganan' => $subRow->angsuranRekeningAir->pelanggan->no_langganan,
                        'nama' => $subRow->angsuranRekeningAir->pelanggan->nama,
                        'alamat' => $subRow->angsuranRekeningAir->pelanggan->alamat,
                        'nomor' => $subRow->angsuranRekeningAir->nomor,
                        'urutan' => $subRow->urutan,
                        'nilai' => $subRow->nilai,
                    ];
                }
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'bayar' => 'required|numeric|min:' . collect($this->dataRekeningAir)->where('angsur', 0)->sum(fn($q) => $q['tagihan'] + $q['denda']) + collect($this->dataAngsuranRekeningAir)->sum('nilai'),
            'dataRekeningAir' => 'required',
        ]);
        DB::transaction(function () {
            foreach (collect($this->dataRekeningAir)->where('angsur', 0)->all() as $key => $row) {
                RekeningAir::where('id', $row['rekening_air_id'])->whereNull('waktu_bayar')->update([
                    'kasir' => auth()->user()->uid,
                    'waktu_bayar' => now(),
                    'biaya_denda' => $row['denda'],
                ]);
            }

            foreach (collect($this->dataAngsuranRekeningAir)->all() as $key => $row) {
                AngsuranRekeningAirDetail::where('urutan', $row['urutan'])->where('angsuran_rekening_air_id', $row['angsuran_rekening_air_id'])->where('id', $row['angsuran_rekening_air_detail_id'])->update([
                    'kasir' => auth()->user()->uid,
                    'waktu_bayar' => now(),
                ]);
            }

            foreach (collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_id')->unique()->all() as $key => $row) {
                if (AngsuranRekeningAir::where('id', $row)->lunas()->count() > 0) {
                    $dataAngsuranRekeningAirPeriode = AngsuranRekeningAirPeriode::where('angsuran_rekening_air_id', $row)->get()->pluck('rekening_air_id')->all();
                    RekeningAir::whereIn('id', $dataAngsuranRekeningAirPeriode)->belumBayar()->update([
                        'kasir' => auth()->user()->uid,
                        'waktu_bayar' => now(),
                        'biaya_denda' => DB::raw('(select nilai from tarif_denda where id=tarif_denda_id)'),
                    ]);
                }
            }

            $cetak = view('cetak.nota-rekeningair', [
                'dataRekeningAir' => RekeningAir::with('bacaMeter')->whereIn('id', collect($this->dataRekeningAir)->where('angsur', 0)->pluck('rekening_air_id')->all())->sudahBayar()->get(),
                'dataAngsuranRekeningAir' => AngsuranRekeningAirDetail::with('angsuranRekeningAir')
                    ->whereIn('urutan', collect($this->dataAngsuranRekeningAir)->pluck('urutan')->all())
                    ->whereIn('angsuran_rekening_air_id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_id')->all())
                    ->whereIn('id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_detail_id')->all())->sudahBayar()->get(),
            ])->render();

            session()->flash('cetak', $cetak);
        });

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('pembayaran.rekeningair.perpelanggan'));
    }

    public function hapusDataRekeningAir($id)
    {
        unset($this->dataRekeningAir[$id]);
    }

    public function hapusDataAngsuranRekeningAir($id)
    {
        unset($this->dataAngsuranRekeningAir[$id]);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.pembayaran.rekeningair.kolektif');
    }
}
