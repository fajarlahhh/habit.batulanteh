<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Gantisandi extends Component
{
    public $kataSandiLama, $kataSandiBaru;
    
    public function submit()
    {
        $this->validate([
            'kataSandiLama' => 'required',
            'kataSandiBaru' => 'required',
        ]);

        $id = Auth::id();
        $pengguna = Pengguna::findOrFail($id);
        if ($pengguna) {
            if (!Hash::check($this->kataSandiLama, $pengguna->kata_sandi)) {
                session()->flash('danger', 'Gagal menyimpan data. Kata sandi lama salah');
            }else{
                $pengguna->kata_sandi = Hash::make($this->kataSandiBaru);
                $pengguna->save();
                session()->flash('success', 'Berhasil menyimpan data');
            }
        } else {
            session()->flash('danger', 'Gagal menyimpan data. Data tidak ditemukan');
        }
        $this->reset(['kataSandiLama', 'kataSandiBaru']);
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.gantisandi');
    }
}
