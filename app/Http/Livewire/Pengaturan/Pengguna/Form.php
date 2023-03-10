<?php

namespace App\Http\Livewire\Pengaturan\Pengguna;

use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $data, $key, $uid, $nama, $deskripsi, $kataSandi, $level = 'operator', $akses = [], $dataLevel = [], $dataMenu, $penagih = 0, $pembaca = 0, $unitPelayanan;

    public function submit()
    {
        $this->validate([
            'akses' => 'required',
            'level' => 'required',
            'uid' => 'required',
            'nama' => 'required',
            'penagih' => 'required',
        ]);

        DB::transaction(function () {
            if (!$this->key) {
                $this->data->uid = $this->uid;
                $this->data->kata_sandi = Hash::make($this->uid);
            }
            $this->data->nama = $this->nama;
            $this->data->api_token = Str::random(60);
            $this->data->deskripsi = $this->deskripsi;
            $this->data->penagih = $this->penagih;
            $this->data->unit_pelayanan_id = $this->unitPelayanan;
            $this->data->bacameter = $this->pembaca ? 1 : 0;
            $this->data->save();

            $this->data->syncPermissions($this->akses);

            if (sizeof($this->data->getRoleNames()) > 0) {
                $this->data->removeRole($this->data->getRoleNames()->first());
            }

            $this->data->assignRole($this->level);

            if ($this->level !== 'administrator') {
                foreach ($this->akses as $row) {
                    $this->data->givePermissionTo($row);
                }
            }
        });

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('pengaturan.pengguna'));
    }

    public function mount()
    {
        $this->dataMenu = $this->menu(config('sidebar.menu'), true);
        $this->dataLevel = Role::all();
        if ($this->key) {
            $this->data = Pengguna::findOrFail($this->key);
            $this->uid = $this->data->uid;
            $this->nama = $this->data->nama;
            $this->deskripsi = $this->data->deskripsi;
            $this->penagih = $this->data->penagih;
            $this->pembaca = $this->data->bacameter;
            $this->unitPelayanan = $this->data->unit_pelayanan_id;
            $this->level = $this->data->getRoleNames()->first();
            $this->akses = $this->data->getPermissionNames()->toArray();
        } else {
            $this->data = new Pengguna();
        }
    }

    public function menu($val, $flatten = false)
    {
        $menu = [];
        foreach ($val as $row) {
            if ($flatten) {
                $menu[] = [
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'sub_menu' => !empty($row['sub_menu']) ? $this->menu($row['sub_menu'], true) : [],
                ];
            } else {
                $menu[] = [
                    'id' => $row['id'],
                    'sub_menu' => !empty($row['sub_menu']) ? $this->menu($row['sub_menu']) : [],
                ];
            }
        }
        return $menu;
    }

    public function updatedLevel()
    {
        if ($this->level == 'administrator') {
            $this->akses = Permission::all()->pluck('name')->all();
        }
    }

    public function resetKataSandi()
    {
        $this->data->kata_sandi = Hash::make($this->uid);
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
    }

    public function resetApiToken()
    {
        $this->data->api_token = Hash::make(Str::random(10));
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
    }

    public function boot()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.pengaturan.pengguna.form');
    }
}
