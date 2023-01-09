<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $uid, $kataSandi, $remember = false;
    public function submit()
    {
        $this->validate([
            'uid' => 'required',
            'kataSandi' => 'required',
        ]);

        if (Auth::attempt(['uid' => $this->uid, 'password' => $this->kataSandi], $this->remember)) {
            redirect()->intended('dashboard');
        } else {
            session()->flash('danger', 'Kredensial tidak valid');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
