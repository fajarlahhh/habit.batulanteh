<?php

namespace App\Http\Livewire\Pembayaran;

use App\Models\Pelanggan;
use App\Models\RekeningNonAir as ModelsRekeningNonAir;
use App\Models\TarifPelayananSangsi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Romans\Filter\IntToRoman;

class Rekeningnonair extends Component
{
    public $pelanggan, $pelangganId, $nama, $alamat, $noHp, $pelayananSangsiId, $tagihan, $tarifPelayananSangsi, $dataPelanggan, $bayar;

    public function updatedPelayananSangsiId()
    {
        $this->tarifPelayananSangsi = TarifPelayananSangsi::findOrFail($this->pelayananSangsiId);
        $this->tagihan = $this->tarifPelayananSangsi->nilai;
        $this->reset(['pelangganId', 'nama', 'alamat', 'noHp']);
    }

    public function updatedPelangganId()
    {
        if ($this->tarifPelayananSangsi->pelanggan != null) {
            $this->pelanggan = Pelanggan::findOrFail($this->pelangganId);
            $this->nama = $this->pelanggan->nama;
            $this->alamat = $this->pelanggan->alamat;
            $this->noHp = $this->pelanggan->no_hp;
        }
    }

    public function submit()
    {
        $this->validate([
            'pelayananSangsiId' => 'required',
        ]);

        $pelayanan = TarifPelayananSangsi::findOrFail($this->pelayananSangsiId);

        if ($pelayanan->pelanggan != null) {
            $this->validate([
                'bayar' => 'required|numeric|min:' . $this->tagihan,
                'pelangganId' => 'required|numeric',
                'tagihan' => 'required|numeric',
            ]);
        } else {
            $this->validate([
                'bayar' => 'required|numeric|min:' . $this->tagihan,
                'nama' => 'required',
                'alamat' => 'required',
                'noHp' => 'required',
                'tagihan' => 'required|numeric',
            ]);
        }
        DB::transaction(function () use ($pelayanan) {
            $roman = new IntToRoman();
            $terakhir = ModelsRekeningNonAir::where('created_at', 'like', date('Y-m') . '%')->orderBy('created_at', 'desc')->first();
            $nomor = '000001/NONAIR/PBL/' . $roman->filter(date('m')) . '/' . date('Y');
            if ($terakhir) {
                $terakhir = sprintf('%06s', (int) substr($terakhir->nomor, 0, 6) + 1);
                $nomor = $terakhir . '/NONAIR/PBL/' . $roman->filter(date('m')) . '/' . date('Y');
            }

            $data = new ModelsRekeningNonAir();
            $data->nomor = $nomor;
            $data->jenis = $pelayanan->jenis;
            $data->nama = $this->nama;
            $data->alamat = $this->alamat;
            $data->no_hp = $this->noHp;
            $data->nilai = $this->tagihan;
            $data->pelanggan_id = $this->pelangganId;
            $data->kasir = auth()->user()->nama;
            $data->save();

            $cetak = view('cetak.nota-rekeningnonair', [
                'dataRekeningNonAir' => ModelsRekeningNonAir::findOrFail($data->id),
            ])->render();

            if ($pelayanan->fungsi == 'aktifkan pelanggan') {
                Pelanggan::where('id', $this->pelangganId)->update(['status'=> 1]);
            }

            session()->flash('cetak', $cetak);
            session()->flash('success', 'Berhasil menyimpan data');
        });
        return redirect(route('pembayaran.rekeningnonair'));
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.pembayaran.rekeningnonair');
    }
}
