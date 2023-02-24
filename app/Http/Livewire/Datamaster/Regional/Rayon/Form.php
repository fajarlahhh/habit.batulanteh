<?php

namespace App\Http\Livewire\Datamaster\Regional\Rayon;

use App\Models\Jalan;
use App\Models\JalanKelurahan;
use App\Models\Rayon;
use App\Models\RayonDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $detail = [], $nama, $kode, $keterangan, $data, $key, $dataJalanKelurahan;

    protected $queryString = ['key'];

    protected $rules = [
        'kode' => 'required|digits:4',
        'nama' => 'required',
        'detail' => 'required',
        'detail.*.id' => 'required|numeric|distinct',
    ];

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            $this->data->kode = $this->kode;
            $this->data->nama = $this->nama;
            $this->data->keterangan = $this->keterangan;
            $this->data->save();

            RayonDetail::where('rayon_id', $this->data->id)->delete();
            RayonDetail::insert(collect($this->detail)->map(fn($q) => [
                'rayon_id' => $this->data->id,
                'jalan_kelurahan_id' => $q['id'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.rayon'));
    }

    public function tambahDetail($key, $id)
    {
        $data = collect($this->dataJalanKelurahan)->where('id', $id)->first();
        unset($this->dataJalanKelurahan[$key]);
        $this->detail[] = [
            'id' => $id,
            'nama' => $data['nama'],
            'nama_kelurahan' => $data['nama_kelurahan'],
            'nama_kecamatan' => $data['nama_kecamatan'],
        ];
    }

    public function hapusDetail($key, $id)
    {
        $data = collect($this->detail)->where('id', $id)->first();
        unset($this->detail[$key]);
        $this->dataJalanKelurahan[] = [
            'id' => $id,
            'nama' => $data['nama'],
            'nama_kelurahan' => $data['nama_kelurahan'],
            'nama_kecamatan' => $data['nama_kecamatan'],
        ];
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        $this->dataJalanKelurahan = JalanKelurahan::with('kelurahan.kecamatan')->with('jalan')->whereNotIn('id', RayonDetail::all()->pluck('jalan_kelurahan_id'))->get()->map(fn($q) => [
            'id' => $q->id,
            'nama' => $q->jalan->nama,
            'nama_kelurahan' => $q->kelurahan->nama,
            'nama_kecamatan' => $q->kelurahan->kecamatan->nama,
        ])->sortBy('nama')->toArray();
        if ($this->key) {
            $this->data = Rayon::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
            $this->keterangan = $this->data->keterangan;
            $this->detail = $this->data->rayonDetail->map(fn($q) => [
                'id' => $q->jalan_kelurahan_id,
                'nama' => $q->jalanKelurahan->jalan->nama,
                'nama_kelurahan' => $q->jalanKelurahan->kelurahan->nama,
                'nama_kecamatan' => $q->jalanKelurahan->kelurahan->kecamatan->nama,
            ])->toArray();
        } else {
            $this->data = new Rayon();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.regional.rayon.form');
    }
}
