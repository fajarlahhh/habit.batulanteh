<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
  public $salam = "";

  public function mount()
  {
    $time = date("H");

    if ($time < "12") {
      $this->salam = "Selamat pagi";
    } else if ($time >= "12" && $time < "17") {
      $this->salam = "Selamat sore";
    } else if ($time >= "17") {
      $this->salam = "Selamat malam";
    }
  }

  public function render()
  {
    $this->emit('reinitialize');
    return view('livewire.dashboard');
  }
}
