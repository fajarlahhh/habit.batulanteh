<?php

namespace App\Http\Livewire\Pengaturan\Kolektif;

use App\Models\Kolektif;
use App\Models\KolektifDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public $detail = [], $nama, $keterangan, $data, $key;

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
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('pengaturan.kolektif'));
    }

    public function tambahDetail()
    {
        $this->detail[] = [
            'kolektif_id' => null,
            'pelanggan_id' => null,
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
        return view('livewire.pengaturan.kolektif.form');
    }
}
