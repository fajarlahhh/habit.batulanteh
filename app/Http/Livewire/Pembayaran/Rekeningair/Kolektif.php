<?php

namespace App\Http\Livewire\Pembayaran\Rekeningair;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Pengguna;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use Illuminate\Support\Facades\DB;
use App\Models\AngsuranRekeningAir;
use App\Models\AngsuranRekeningAirDetail;
use App\Models\AngsuranRekeningAirPeriode;

class Kolektif extends Component
{
    public $dataPelanggan = [], $kolektifId, $dataRekeningAir = [], $keterangan, $dataAngsuranRekeningAir = [], $bayar = 0, $awalRekeningAir = null, $awalAngsuranRekeningAir = null, $tanggal,$dataKasir, $kasir;

    public function mount()
    {
        $this->tanggal = date('Y-m-d H:i');
        $this->dataKasir = Pengguna::where('penagih', '>', 0)->get();
        $this->kasir = $this->kasir ?: auth()->user()->nama;
    }

    public function updatedKolektifId()
    {
        $this->dataRekeningAir = [];
        $this->dataAngsuranRekeningAir = [];
        $this->dataPelanggan = Pelanggan::whereHas('kolektifDetail', fn ($q) => $q->where('kolektif_id', $this->kolektifId))->with('rekeningAir', fn ($q) => $q->belumBayar()->with('golongan'))->get();
        $this->setDataRekeningAir();
        $this->setDataAngsuranRekeningAir();
    }

    public function setDataRekeningAir()
    {
        foreach ($this->dataPelanggan as $key => $row) {
            foreach ($row->rekeningAir->whereNotIn('id', collect($this->dataRekeningAir)->pluck('id'))->all() as $key => $subRow) {
                $periode = new Carbon($subRow->periode);
                $denda = $periode->addMonths(1)->day(20)->format('Ymd') < date('Ymd') ? $subRow->tarifDenda->nilai : 0;
                $this->dataRekeningAir[] = [
                    'id' => $subRow->id,
                    'pelanggan_id' => $subRow->pelanggan_id,
                    'no_langganan' => $subRow->pelanggan->no_langganan,
                    'nama' => $subRow->pelanggan->nama,
                    'alamat' => $subRow->pelanggan->alamat,
                    'periode' => $subRow->periode,
                    'golongan' => $subRow->golongan->nama,
                    'angsur' => $subRow->angsuranRekeningAirPeriode ? 1 : 0,
                    'pakai' => $subRow->stand_ini || $subRow->stand_lalu ? $subRow->stand_ini - $subRow->stand_pasang + $subRow->stand_angkat - $subRow->stand_lalu : $subRow->stand_ini - $subRow->stand_lalu,
                    'tagihan' => $subRow->harga_air + $subRow->biaya_lainnya + $subRow->biaya_meter_air + $subRow->biaya_admin + $subRow->biaya_materai,
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
            'bayar' => 'required|numeric|min:' . collect($this->dataRekeningAir)->where('angsur', 0)->sum(fn ($q) => $q['tagihan'] + $q['denda']) + collect($this->dataAngsuranRekeningAir)->sum('nilai'),
            'dataRekeningAir' => 'required',
            'kasir' => 'required'
        ]);
        DB::transaction(function () {
            foreach (collect($this->dataRekeningAir)->where('angsur', 0)->all() as $key => $row) {
                RekeningAir::where('id', $row['id'])->whereNull('waktu_bayar')->update([
                    'kasir' => $this->kasir,
                    'waktu_bayar' => $this->tanggal,
                    'biaya_denda' => $row['denda'],
                ]);
            }

            foreach (collect($this->dataAngsuranRekeningAir)->all() as $key => $row) {
                AngsuranRekeningAirDetail::where('urutan', $row['urutan'])->where('angsuran_rekening_air_id', $row['angsuran_rekening_air_id'])->where('id', $row['angsuran_rekening_air_detail_id'])->update([
                    'kasir' => $this->kasir,
                    'waktu_bayar' => $this->tanggal,
                ]);
            }

            foreach (collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_id')->unique()->all() as $key => $row) {
                if (AngsuranRekeningAir::where('id', $row)->lunas()->count() > 0) {
                    $dataAngsuranRekeningAirPeriode = AngsuranRekeningAirPeriode::where('angsuran_rekening_air_id', $row)->get()->pluck('rekening_air_id')->all();
                    RekeningAir::whereIn('id', $dataAngsuranRekeningAirPeriode)->belumBayar()->update([
                        'kasir' => $this->kasir,
                        'waktu_bayar' => $this->tanggal,
                        'biaya_denda' => DB::raw('(select nilai from tarif_denda where id=tarif_denda_id)'),
                    ]);
                }
            }

            $cetak = view('cetak.nota-rekeningair', [
                'dataRekeningAir' => RekeningAir::with('bacaMeter')->whereIn('id', collect($this->dataRekeningAir)->where('angsur', 0)->pluck('id')->all())->sudahBayar()->get(),
                'dataAngsuranRekeningAir' => AngsuranRekeningAirDetail::with('angsuranRekeningAir')
                    ->whereIn('urutan', collect($this->dataAngsuranRekeningAir)->pluck('urutan')->all())
                    ->whereIn('angsuran_rekening_air_id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_id')->all())
                    ->whereIn('id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_detail_id')->all())->sudahBayar()->get(),
            ])->render();

            session()->flash('cetak', $cetak);
        });

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('pembayaran.rekeningair.kolektif'));
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
