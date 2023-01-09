<?php

namespace App\Http\Livewire\Auth;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Gantipassword extends Component
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
        session()->flash('danger', 'Gagal menyimpan data. Password lama salah');
      }
    } else {
      session()->flash('danger', 'Gagal menyimpan data. Data tidak ditemukan');
    }
    $pengguna->kata_sandi = Hash::make($this->kataSandiBaru);
    $pengguna->save();
    session()->flash('success', 'Berhasil menyimpan data');
    $this->reset(['kataSandiLama', 'kataSandiBaru']);

    $this->emit('done');
  }

  public function render()
  {
    return view('livewire.auth.gantipassword');
  }
}
