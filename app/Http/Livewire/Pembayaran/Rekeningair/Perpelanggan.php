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

class Perpelanggan extends Component
{
    public $pelanggan, $pelangganId, $dataRekeningAir = [], $keterangan, $dataAngsuranRekeningAir = [], $bayar = 0, $awalRekeningAir = null, $awalAngsuranRekeningAir = null, $tanggal, $dataKasir, $kasir;

    public function updatedPelangganId()
    {
        $this->setPelanggan();
    }

    public function mount()
    {
        $this->tanggal = date('Y-m-d H:i');
        $this->dataKasir = Pengguna::where('penagih', '>', 0)->get();
        $this->kasir = $this->kasir ?: auth()->user()->nama;
    }

    public function setPelanggan()
    {
        $this->pelanggan = Pelanggan::with(['rekeningAir' => fn ($r) => $r->belumBayar()->with('golongan')])->findOrFail($this->pelangganId);
        $this->setDataRekeningAir();
        $this->setDataAngsuranRekeningAir();
        $this->reset(['pelangganId']);
    }

    public function setDataRekeningAir()
    {
        if ($this->pelanggan->rekeningAir->count() > 0) {
            foreach ($this->pelanggan->rekeningAir->whereNotIn('id', collect($this->dataRekeningAir)->pluck('id'))->all() as $key => $row) {
                $periode = new Carbon($row->periode);
                $denda = $periode->addMonths(1)->day(25)->format('Ymd') < date('Ymd') ? $row->tarifDenda->nilai : 0;
                $this->dataRekeningAir[] = [
                    'id' => $row->id,
                    'pelanggan_id' => $row->pelanggan_id,
                    'no_langganan' => $row->pelanggan->no_langganan,
                    'nama' => $row->pelanggan->nama,
                    'alamat' => $row->pelanggan->alamat,
                    'periode' => $row->periode,
                    'golongan' => $row->golongan->nama,
                    'angsur' => $row->angsuranRekeningAirPeriode ? 1 : 0,
                    'pakai' => $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu,
                    'tagihan' => $row->harga_air + $row->biaya_lainnya + $row->biaya_meter_air + $row->biaya_admin + $row->biaya_materai,
                    'denda' => $denda,
                ];
            }
        }
    }

    public function setDataAngsuranRekeningAir()
    {
        if ($this->pelanggan->angsuranRekeningAir->count() > 0) {
            foreach ($this->pelanggan->angsuranRekeningAir->first()->angsuranRekeningAirDetail->whereNotIn('angsuran_rekening_air_detail_id', collect($this->dataAngsuranRekeningAir)->pluck('angsuran_rekening_air_detail_id'))->all() as $key => $row) {
                $this->dataAngsuranRekeningAir[] = [
                    'angsuran_rekening_air_id' => $row->angsuranRekeningAir->id,
                    'angsuran_rekening_air_detail_id' => $row->id,
                    'pelanggan_id' => $row->angsuranRekeningAir->pelanggan_id,
                    'no_langganan' => $row->angsuranRekeningAir->pelanggan->no_langganan,
                    'nama' => $row->angsuranRekeningAir->pelanggan->nama,
                    'alamat' => $row->angsuranRekeningAir->pelanggan->alamat,
                    'nomor' => $row->angsuranRekeningAir->nomor,
                    'urutan' => $row->urutan,
                    'nilai' => $row->nilai,
                ];
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
