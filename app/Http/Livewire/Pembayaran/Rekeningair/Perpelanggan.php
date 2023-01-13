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

class Perpelanggan extends Component
{
    public $pelanggan, $pelangganId, $dataRekeningAir = [], $keterangan, $dataAngsuranRekeningAir = [], $bayar = 0, $awalRekeningAir = null, $awalAngsuranRekeningAir = null;

    public function updatedPelangganId()
    {
        $this->setPelanggan();
    }

    public function setPelanggan()
    {
        $this->pelanggan = Pelanggan::with(['bacaMeter' => fn($q) => $q->where('periode', '<', date('Y-m-01'))->with(['rekeningAir' => fn($r) => $r->with('golongan')->with('angsuranRekeningAirPeriode')])->whereHas('rekeningAir', fn($q) => $q->belumBayar())])->with(['angsuranRekeningAir' => fn($q) => $q->belumLunas()->with(['angsuranRekeningAirDetail' => fn($r) => $r->belumBayar()])])->findOrFail($this->pelangganId);
        $this->setDataRekeningAir();
        $this->setDataAngsuranRekeningAir();
        $this->reset(['pelangganId']);
    }

    public function setDataRekeningAir()
    {
        if ($this->pelanggan->bacaMeter->count() > 0) {
            $this->dataRekeningAir = $this->pelanggan->bacaMeter->whereNotIn('baca_meter_id', collect($this->dataRekeningAir)->pluck('baca_meter_id'))->map(function ($q) {
                $periode = new Carbon($q->periode);
                $denda = $periode->addMonths(1)->day(25)->format('Ymd') < date('Ymd') ? $q->rekeningAir->tarifDenda->nilai : 0;
                return [
                    'baca_meter_id' => $q->id,
                    'rekening_air_id' => $q->rekeningAir->id,
                    'pelanggan_id' => $q->pelanggan_id,
                    'no_langganan' => $q->pelanggan->no_langganan,
                    'nama' => $q->pelanggan->nama,
                    'alamat' => $q->pelanggan->alamat,
                    'periode' => $q->periode,
                    'golongan' => $q->rekeningAir->golongan->nama,
                    'angsur' => $q->rekeningAir->angsuranRekeningAirPeriode ? 1 : 0,
                    'pakai' => $q->stand_ini - $q->stand_lalu,
                    'tagihan' => $q->rekeningAir->harga_air + $q->rekeningAir->biaya_denda + $q->rekeningAir->biaya_lainnya + $q->rekeningAir->biaya_meter_air + $q->rekeningAir->biaya_materai,
                    'denda' => $denda,
                ];
            })->toArray();
        }
    }

    public function setDataAngsuranRekeningAir()
    {
        if ($this->pelanggan->angsuranRekeningAir->count() > 0) {
            $this->dataAngsuranRekeningAir = $this->pelanggan->angsuranRekeningAir->first()->angsuranRekeningAirDetail->whereNotIn('angsuran_rekening_air_detail_id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_detail_id'))->map(function ($q) {
                return [
                    'angsuran_rekening_air_id' => $q->angsuranRekeningAir->id,
                    'angsuran_rekening_air_detail_id' => $q->id,
                    'pelanggan_id' => $q->angsuranRekeningAir->pelanggan_id,
                    'no_langganan' => $q->angsuranRekeningAir->pelanggan->no_langganan,
                    'nama' => $q->angsuranRekeningAir->pelanggan->nama,
                    'alamat' => $q->angsuranRekeningAir->pelanggan->alamat,
                    'nomor' => $q->angsuranRekeningAir->nomor,
                    'urutan' => $q->urutan,
                    'nilai' => $q->nilai,
                ];
            })->toArray();
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
                    'kasir_id' => auth()->id(),
                    'waktu_bayar' => now(),
                    'biaya_denda' => $row['denda'],
                ]);
            }

            foreach (collect($this->dataAngsuranRekeningAir)->all() as $key => $row) {
                AngsuranRekeningAir::where('id', $row['angsuran_rekening_air_detail_id'])->belumBayar()->update([
                    'kasir_id' => auth()->id(),
                    'waktu_bayar' => now(),
                ]);
            }

            foreach (collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_id')->unique()->all() as $key => $row) {
                if (AngsuranRekeningAir::where('id', $row)->lunas()->count() > 0) {
                    $dataAngsuranRekeningAirPeriode = AngsuranRekeningAirPeriode::where('angsuran_rekening_air_id', $row)->get()->pluck('rekening_air_id')->all();
                    RekeningAir::whereIn('id', $dataAngsuranRekeningAirPeriode)->belumBayar()->update([
                        'kasir_id' => auth()->id(),
                        'waktu_bayar' => now(),
                        'biaya_denda' => DB::raw('(select nilai from tarif_denda where id=tarif_denda_id)'),
                    ]);
                }
            }
            $cetak = view('livewire.pembayaran.rekeningair.cetak', [
                'dataRekeningAir' => RekeningAir::with('bacaMeter')->whereIn('id', collect($this->dataRekeningAir)->where('angsur', 0)->pluck('rekening_air_id')->all())->sudahBayar()->get(),
                'dataAngsuranRekeningAir' => AngsuranRekeningAirDetail::with('angsuranRekeningAir')->whereIn('id', collect($this->dataAngsuranRekeningAir)->where('angsurs', 0)->pluck('rekening_air_id')->all())->sudahBayar()->get(),
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
        return view('livewire.pembayaran.rekeningair.perpelanggan');
    }
}
