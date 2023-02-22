<?php

namespace App\Http\Livewire\Datamaster\Regional\Rutebaca;

use App\Models\Pengguna;
use App\Models\Rayon;
use App\Models\RuteBaca;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $detail = [], $pembacaId, $key, $data, $dataRayon, $dataPengguna;

    protected $queryString = ['key'];

    protected $rules = [
        'pembacaId' => 'required|numeric',
        'detail' => 'required',
        'detail.*.rayon_id' => 'required|numeric|distinct',
    ];

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            RuteBaca::where('pembaca_id', ($this->key ? $this->data->id : $this->pembacaId))->delete();
            RuteBaca::insert(collect($this->detail)->map(fn ($q) => [
                'pembaca_id' => $this->pembacaId,
                'rayon_id' => $q['rayon_id'],
                'pengguna_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray());
            session()->flash('success', 'Berhasil menyimpan data');
        });

        return redirect(route('datamaster.regional.rutebaca'));
    }

    public function tambahDetail($id, $rayon)
    {
        $data = collect($this->dataRayon)->where('rayon_id', $rayon)->first();
        unset($this->dataRayon[$id]);
        $this->detail[] = [
            'rayon_id' => $rayon,
            'nama' => $data['nama'],
        ];
    }

    public function hapusDetail($id, $rayon)
    {
        $data = collect($this->detail)->where('rayon_id', $rayon)->first();
        unset($this->detail[$id]);
        $this->dataRayon[] = [
            'rayon_id' => $rayon,
            'nama' => $data['nama'],
        ];
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function mount()
    {
        $this->dataRayon = Rayon::whereNotIn('id', RuteBaca::all()->pluck('rayon_id'))->get()->map(fn($q) => [
            'rayon_id' => $q->id,
            'nama' => $q->nama,
        ])->toArray();
        $this->dataPengguna = Pengguna::whereNotIn('id', RuteBaca::all()->pluck('pembaca_id')->all())->get();
        if ($this->key) {
            $this->data = Pengguna::findOrFail($this->key);
            $this->pembacaId = $this->data->id;
            $this->detail = $this->data->ruteBaca->map(fn($q) => [
                'rayon_id' => $q->id,
                'nama' => $q->rayon->nama,
            ])->toArray();
        }
    }

    public function render()
    {
        return view('livewire.datamaster.regional.rutebaca.form');
    }
}
