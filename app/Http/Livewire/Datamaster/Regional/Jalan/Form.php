<?php

namespace App\Http\Livewire\Datamaster\Regional\Jalan;

use App\Models\Jalan;
use App\Models\JalanKelurahan;
use Livewire\Component;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $key, $nama, $jenis, $data, $dataKelurahan, $detail = [];

    protected $rules = [
        'nama' => 'required',
        'jenis' => 'required',
        'detail' => 'required',
        'detail.*.kelurahan_id' => 'required|numeric|distinct',
    ];

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $this->data->nama = $this->nama;
            $this->data->jenis = $this->jenis;
            $this->data->save();

            JalanKelurahan::where('jalan_id', $this->data->id)->delete();
            JalanKelurahan::insert(collect($this->detail)->map(fn ($q) => [
                'jalan_id' => $this->data->id,
                'kelurahan_id' => $q['kelurahan_id'],
                'pengguna_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.jalan'));
    }

    public function mount()
    {
        $this->dataKelurahan = Kelurahan::with('kecamatan')->get();
        if ($this->key) {
            $this->data = Jalan::findOrFail($this->key);
            $this->nama = $this->data->nama;
            $this->jenis = $this->data->jenis;
            $this->detail =  $this->data->jalanKelurahan->map(fn ($q) => [
                'kelurahan_id' => $q->kelurahan_id
            ])->toArray();
        } else {
            $this->data = new Jalan();
        }
    }

    public function tambahDetail()
    {
        $this->detail[] = [
            'kelurahan_id' => null,
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

    public function render()
    {
        return view('livewire.datamaster.regional.jalan.form');
    }
}
