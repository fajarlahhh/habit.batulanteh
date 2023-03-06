<?php

namespace App\Http\Livewire\Administrator\Datapembayaran;

use App\Models\LogPembatalanRekAir;
use App\Models\RekeningAir as ModelsRekeningAir;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Rekeningair extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tanggal, $key, $cari;

    protected $queryString = ['tanggal', 'cari'];

    public function cetak($id)
    {
        $cetak = view('cetak.nota-rekeningair', [
            'dataRekeningAir' => ModelsRekeningAir::with('bacaMeter')->where('id', $id)->sudahBayar()->get(),
            'dataAngsuranRekeningAir' => collect([]),
        ])->render();
        session()->flash('cetak', $cetak);
        $this->emit('cetak');
    }

    public function mount()
    {
        $this->tanggal = $this->tanggal ?: date('Y-m-d');
    }

    public function setKey($key = null)
    {
        $this->key = $key;
    }

    public function hapus()
    {
        DB::transaction(function () {
            ModelsRekeningAir::where('id', $this->key)->update([
                'waktu_bayar' => null,
                'kasir' => null,
            ]);

            $data = ModelsRekeningAir::where('id', $this->key)->first();

            $log = new LogPembatalanRekAir();
            $log->stand_lalu = $data->stand_lalu;
            $log->stand_ini = $data->stand_ini;
            $log->stand_angkat = $data->stand_angkat;
            $log->stand_pasang = $data->stand_pasang;
            $log->biaya_denda = $data->biaya_denda;
            $log->biaya_lainnya = $data->biaya_lainnya;
            $log->biaya_meter_air = $data->biaya_meter_air;
            $log->biaya_admin = $data->biaya_admin;
            $log->biaya_materai = $data->biaya_materai;
            $log->biaya_ppn = $data->biaya_ppn;
            $log->rekening_air_id = $data->id;
            $log->created_at = now();
            $log->updated_at = now();
            $log->save();
        });
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.administrator.datapembayaran.rekeningair', [
            'i' => ($this->page - 1) * 10,
            'data' => ModelsRekeningAir::withoutGlobalScopes()->whereBetween('waktu_bayar', [$this->tanggal . ' 00:00:00', $this->tanggal . ' 23:59:59'])->sudahBayar()->whereHas('pelanggan', fn ($r) => $r->where('nama', 'like', '%' . $this->cari . '%')->orWhere('no_langganan', 'like', '%' . $this->cari . '%'))->orderBy('created_at')->paginate(10),
        ]);
    }
}
