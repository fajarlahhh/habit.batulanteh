<?php

namespace App\Http\Livewire\Datamaster\Regional\Rayon;

use App\Models\Jalan;
use App\Models\Rayon;
use App\Models\RayonDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $detail = [], $nama, $kode, $keterangan, $data, $key, $dataJalan;

    protected $queryString = ['key'];

    protected $rules = [
        'kode' => 'required|digits:4',
        'nama' => 'required',
        'detail' => 'required',
        'detail.*.jalan_id' => 'required|numeric|distinct',
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
                'jalan_id' => $q['jalan_id'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.rayon'));
    }

    public function tambahDetail($id, $jalan)
    {
        $data = collect($this->dataJalan)->where('jalan_id', $jalan)->first();
        unset($this->dataJalan[$id]);
        $this->detail[] = [
            'jalan_id' => $jalan,
            'nama' => $data['nama'],
            'nama_kelurahan' => $data['nama_kelurahan'],
            'nama_kecamatan' => $data['nama_kecamatan'],
        ];
    }

    public function hapusDetail($id, $jalan)
    {
        $data = collect($this->detail)->where('jalan_id', $jalan)->first();
        unset($this->detail[$id]);
        $this->dataJalan[] = [
            'jalan_id' => $jalan,
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
        $this->dataJalan = Jalan::with('kelurahan.kecamatan')->whereNotIn('id', RayonDetail::all()->pluck('jalan_id'))->orderBy('nama')->get()->map(fn($q) => [
            'jalan_id' => $q->id,
            'nama' => $q->nama,
            'nama_kelurahan' => $q->kelurahan->nama,
            'nama_kecamatan' => $q->kelurahan->kecamatan->nama,
        ])->toArray();
        if ($this->key) {
            $this->data = Rayon::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
            $this->keterangan = $this->data->keterangan;
            $this->detail = $this->data->rayonDetail->map(fn($q) => [
                'jalan_id' => $q->jalan_id,
                'nama' => $q->jalan->nama,
                'nama_kelurahan' => $q->jalan->kelurahan->nama,
                'nama_kecamatan' => $q->jalan->kelurahan->kecamatan->nama,
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
