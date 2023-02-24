<?php

namespace App\Http\Livewire\Datamaster\Regional\Rayon;

use App\Models\Jalan;
use App\Models\JalanLingkungan;
use App\Models\Rayon;
use App\Models\RayonDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $detail = [], $nama, $kode, $keterangan, $data, $key, $dataJalanLingkungan;

    protected $queryString = ['key'];

    protected $rules = [
        'kode' => 'required|digits:4',
        'nama' => 'required',
        'detail' => 'required',
        'detail.*.jalan_lingkungan_id' => 'required|numeric|distinct',
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
                'jalan_lingkungan_id' => $q['jalan_lingkungan_id'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.rayon'));
    }

    public function tambahDetail($id, $jalan)
    {
        $data = collect($this->dataJalanLingkungan)->where('jalan_lingkungan_id', $jalan)->first();
        unset($this->dataJalanLingkungan[$id]);
        $this->detail[] = [
            'jalan_lingkungan_id' => $jalan,
            'nama' => $data['nama'],
            'nama_lingkungan' => $data['nama_lingkungan'],
            'nama_kelurahan' => $data['nama_kelurahan'],
            'nama_kecamatan' => $data['nama_kecamatan'],
        ];
    }

    public function hapusDetail($id, $jalan)
    {
        $data = collect($this->detail)->where('jalan_lingkungan_id', $jalan)->first();
        unset($this->detail[$id]);
        $this->dataJalanLingkungan[] = [
            'jalan_lingkungan_id' => $jalan,
            'nama' => $data['nama'],
            'nama_lingkungan' => $data['nama_lingkungan'],
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
        $this->dataJalanLingkungan = JalanLingkungan::with('lingkungan.kelurahan.kecamatan')->with('jalan')->whereNotIn('id', RayonDetail::all()->pluck('jalan_lingkungan_id'))->get()->map(fn($q) => [
            'jalan_lingkungan_id' => $q->id,
            'nama' => $q->jalan->nama,
            'nama_lingkungan' => $q->lingkungan->nama,
            'nama_kelurahan' => $q->lingkungan->kelurahan->nama,
            'nama_kecamatan' => $q->lingkungan->kelurahan->kecamatan->nama,
        ])->sortBy('nama')->toArray();
        if ($this->key) {
            $this->data = Rayon::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
            $this->keterangan = $this->data->keterangan;
            $this->detail = $this->data->rayonDetail->map(fn($q) => [
                'jalan_lingkungan_id' => $q->jalan_lingkungan_id,
                'nama' => $q->jalanLingkungan->jalan->nama,
                'nama_lingkungan' => $q->jalanLingkungan->lingkungan->nama,
                'nama_kelurahan' => $q->jalanLingkungan->lingkungan->kelurahan->nama,
                'nama_kecamatan' => $q->jalanLingkungan->lingkungan->kelurahan->kecamatan->nama,
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
