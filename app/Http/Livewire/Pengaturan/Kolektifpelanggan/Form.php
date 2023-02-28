<?php

namespace App\Http\Livewire\Pengaturan\Kolektifpelanggan;

use Livewire\Component;
use App\Models\Kolektif;
use App\Models\Pelanggan;
use App\Models\KolektifDetail;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $detail = [], $nama, $keterangan, $data, $key, $dataPelanggan;

    protected $queryString = ['key'];

    protected $rules = [
        'nama' => 'required',
        'keterangan' => 'required',
        'detail' => 'required',
        'detail.*.pelanggan_id' => 'required|numeric|distinct',
    ];

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            $this->data->nama = $this->nama;
            $this->data->keterangan = $this->keterangan;
            $this->data->save();

            KolektifDetail::where('kolektif_id', $this->data->id)->delete();
            KolektifDetail::insert(collect($this->detail)->map(fn($q) => [
                'kolektif_id' => $this->data->id,
                'pelanggan_id' => $q['pelanggan_id'],
                'penanggung_jawab' => $q['penanggung_jawab'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('pengaturan.kolektifpelanggan'));
    }

    public function tambahDetail()
    {
        $this->detail[] = [
            'kolektif_id' => null,
            'pelanggan_id' => null,
            'penanggung_jawab' => null,
        ];
    }

    public function hapusDetail($i)
    {
        unset($this->detail[$i]);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        $this->dataPelanggan = Pelanggan::whereNotIn('id', KolektifDetail::when($this->key,fn($q) => $q->where('kolektif_id', $this->key))->get()->pluck('pelanggan_id'))->get();
        if ($this->key) {
            $this->data = Kolektif::findOrFail($this->key);
            $this->nama = $this->data->nama;
            $this->keterangan = $this->data->keterangan;
            $this->detail = $this->data->kolektifDetail->toArray();
        } else {
            $this->data = new Kolektif();
        }
    }

    public function render()
    {
        return view('livewire.pengaturan.kolektifpelanggan.form');
    }
}
