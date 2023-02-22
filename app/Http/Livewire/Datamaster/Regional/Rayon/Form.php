<?php

namespace App\Http\Livewire\Datamaster\Regional\Rayon;

use App\Models\Jalan;
use App\Models\Rayon;
use Livewire\Component;
use App\Models\RayonDetail;
use Illuminate\Support\Facades\DB;

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
            RayonDetail::insert(collect($this->detail)->map(fn ($q) => [
                'rayon_id' => $this->data->id,
                'jalan_id' => $q['jalan_id'],
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.rayon'));
    }

    public function tambahDetail()
    {
        $this->detail[] = [
            'rayon_id' => null,
            'jalan_id' => null,
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
        $this->dataJalan = Jalan::all();
        if ($this->key) {
            $this->data = Rayon::findOrFail($this->key);
            $this->kode = $this->data->kode;
            $this->nama = $this->data->nama;
            $this->keterangan = $this->data->keterangan;
            $this->detail = $this->data->rayonDetail->toArray();
        } else {
            $this->data = new Rayon();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.regional.rayon.form');
    }
}
