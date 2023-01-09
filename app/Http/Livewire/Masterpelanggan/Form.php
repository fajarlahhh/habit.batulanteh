<?php

namespace App\Http\Livewire\Masterpelanggan;

use App\Models\Jalan;
use App\Models\Pelanggan;
use Livewire\Component;

class Form extends Component
{
    public $data, $key, $status, $noLangganan, $nama, $alamat, $noHp, $tanggalPasang, $noBodyWaterMeter, $golongan, $jalan, $merkWaterMeter, $diameter, $pembaca;

    public function submit()
    {
        $this->validate([
            'status' => 'required|numeric|between:1,4',
            'nama' => 'required',
            'alamat' => 'required',
            'noHp' => 'digits_between:9,13|numeric|regex:/(08)[0-9]{9}/',
            'tanggalPasang' => 'required|date',
            'noBodyWaterMeter' => 'required',
            'jalan' => 'required|numeric',
            'golongan' => 'required|numeric',
            'merkWaterMeter' => 'required|numeric',
            'diameter' => 'required|numeric',
            'pembaca' => 'required|numeric',
        ]);

        if (!$this->key) {
            $area = str_replace('.', '', Jalan::findOrFail($this->jalan)->kelurahan->kecamatan->kode);
            $pelanggan = Pelanggan::where('jalan_id', $this->jalan)->orderBy('id', 'desc')->first();
            $this->noLangganan = $area . '00001';
            if ($pelanggan) {
                $this->noLangganan = $area . sprintf('%04s', (integer) substr($pelanggan->no_langganan, 6, 4) + 1);
            }
            $this->data->no_langganan = $this->noLangganan;
        }

        $this->data->status = $this->status;
        $this->data->nama = $this->nama;
        $this->data->alamat = $this->alamat;
        $this->data->no_hp = $this->noHp;
        $this->data->tanggal_pasang = $this->tanggalPasang;
        $this->data->no_body_water_meter = $this->noBodyWaterMeter;
        $this->data->golongan_id = $this->golongan;
        $this->data->jalan_id = $this->jalan;
        $this->data->merk_water_meter_id = $this->merkWaterMeter;
        $this->data->diameter_id = $this->diameter;
        $this->data->pembaca_id = $this->pembaca;
        $this->data->save();

        session()->flash('success', 'Berhasil menyimpan data');
        return redirect(route('masterpelanggan'));
    }

    public function mount()
    {
        if ($this->key) {
            $this->data = Pelanggan::findOrFail($this->key);
            $this->status = $this->data->status;
            $this->noLangganan = $this->data->no_langganan;
            $this->nama = $this->data->nama;
            $this->alamat = $this->data->alamat;
            $this->noHp = $this->data->no_hp;
            $this->tanggalPasang = $this->data->tanggal_pasang;
            $this->noBodyWaterMeter = $this->data->no_body_water_meter;
            $this->golongan = $this->data->golongan_id;
            $this->jalan = $this->data->jalan_id;
            $this->merkWaterMeter = $this->data->merk_water_meter_id;
            $this->diameter = $this->data->diameter_id;
            $this->pembaca = $this->data->pembaca_id;
        } else {
            $this->data = new Pelanggan();
            $this->tanggalPasang = date('Y-m-d');
        }
    }

    public function booted()
    {
        $this->emit('reinitialize');
    }

    public function render()
    {
        return view('livewire.masterpelanggan.form');
    }
}
