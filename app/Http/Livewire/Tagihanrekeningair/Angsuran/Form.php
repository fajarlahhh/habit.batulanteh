<?php

namespace App\Http\Livewire\Tagihanrekeningair\Angsuran;

use App\Models\AngsuranRekeningAir;
use App\Models\AngsuranRekeningAirDetail;
use App\Models\AngsuranRekeningAirPeriode;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Romans\Filter\IntToRoman;

class Form extends Component
{
    public $pelanggan, $pelangganId, $dataRekeningAir, $keterangan, $pemohon, $tenor = 2, $angsuranSelanjutnya = 0, $angsuranPertama = 0;

    protected $rules = [
        'pelangganId' => 'required',
        'dataRekeningAir' => 'required',
        'angsuranPertama' => 'required',
        'angsuranSelanjutnya' => 'required',
        'pemohon' => 'required',
        'keterangan' => 'required',
        'tenor' => 'required',
    ];

    public function updatedPelangganId()
    {
        $this->pelanggan = Pelanggan::with('golongan')->with('bacaMeter.rekeningAir')->with(['bacaMeter' => fn($q) => $q->whereHas('rekeningAir', fn($r) => $r->belumBayar())])->findOrFail($this->pelangganId);
        $this->dataRekeningAir = $this->pelanggan->bacaMeter->map(fn($q) => [
            'rekening_air_id' => $q->rekeningAir->id,
            'periode' => $q->periode,
            'denda' => $q->rekeningAir->tarifDenda->nilai,
            'tagihan' => $q->rekeningAir->harga_air + $q->rekeningAir->biaya_denda + $q->rekeningAir->biaya_lainnya + $q->rekeningAir->biaya_meter_air + $q->rekeningAir->biaya_materai + $q->rekeningAir->biaya_ppn - $q->rekeningAir->diskon,
        ]);
        $this->hitungAngsuran();
    }

    public function updatedTenor()
    {
        $this->hitungAngsuran();
    }

    public function updatedAngsuranPertama()
    {
        $this->hitungAngsuran();
    }

    public function hitungAngsuran()
    {
        $selisih = collect($this->dataRekeningAir)->sum(fn($q) => $q['tagihan'] + $q['denda']) - ($this->angsuranPertama ?: 0);
        $this->angsuranSelanjutnya = $selisih / ($this->tenor - 1);
    }

    public function hapus($id)
    {
        unset($this->dataRekeningAir[$id]);
        $this->hitungAngsuran();
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $filter = new IntToRoman();
            $angsuranTerakhir = AngsuranRekeningAir::select('nomor')->where('created_at', 'like', date('Y-m') . '%')->whereNotNull('nomor')->orderBy('id', 'desc')->get()->first();
            $nomor = '00001/ANGSURAN/' . config('constants.perusahaan_alias') . '/' . $filter->filter(date('m')) . '/' . date('Y');
            if ($angsuranTerakhir) {
                $angsuranTerakhir = sprintf('%05s', (integer) substr($angsuranTerakhir->nomor, 0, 5) + 1);
                $nomor = $angsuranTerakhir . '/ANGSURAN/' . config('constant.alias') . '/' . $filter->filter(date('m')) . '/' . date('Y');
            }

            $data = new AngsuranRekeningAir();
            $data->nomor = $nomor;
            $data->pemohon = $this->pemohon;
            $data->keterangan = $this->keterangan;
            $data->pelanggan_id = $this->pelangganId;
            $data->save();

            $detail = [];
            for ($i = 0; $i < $this->tenor; $i++) {
                array_push($detail, [
                    'angsuran_rekening_air_id' => $data->id,
                    'urutan' => $i + 1,
                    'nilai' => $i == 0 ? $this->angsuranPertama : $this->angsuranSelanjutnya,
                ]);
            }

            AngsuranRekeningAirDetail::insert($detail);
            AngsuranRekeningAirPeriode::insert($this->dataRekeningAir->map(fn($q) => [
                'angsuran_rekening_air_id' => $data->id,
                'rekening_air_id' => $q['rekening_air_id'],
            ])->toArray());
        });

        session()->flash('cetak', '$this->data->id');
        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('tagihanrekeningair.angsuran'));
    }

    public function render()
    {
        return view('livewire.tagihanrekeningair.angsuran.form');
    }
}
