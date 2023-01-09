<?php

namespace App\Exports;

use App\Models\BacaMeter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BacameterExport implements FromCollection, WithMapping, WithHeadings
{
  public $cari, $status, $statusBaca, $pembaca, $tahun, $bulan;

  public function __construct($cari, $status, $statusBaca, $pembaca, $tahun, $bulan)
  {
    $this->cari = $cari;
    $this->status = $status;
    $this->statusBaca = $statusBaca;
    $this->pembaca = $pembaca;
    $this->tahun = $tahun;
    $this->bulan = $bulan;
  }
  public function collection()
  {
    return BacaMeter::where(fn($q) => $q->where('no_langganan', 'like', '%' . $this->cari . '%')->orWhere('nama', 'like', '%' . $this->cari . '%'))->when($this->status == 1, fn($q) => $q->whereNotNull('tanggal_baca'))->when($this->status == 0, fn($q) => $q->whereNull('tanggal_baca'))->when($this->statusBaca, fn($q) => $q->where('status_baca', $this->statusBaca))->when($this->pembaca, fn($q) => $q->where('pembaca_kode', $this->pembaca))->where('periode', $this->tahun . '-' . $this->bulan . '-01')->get();
  }
  public function map($data): array
  {
    return [
      $data->no_langganan,
      $data->nama,
      $data->alamat,
      $data->pembaca_kode,
      $data->stand_ini,
      $data->tanggal_baca,
      $data->status_baca,
    ];
  }

  public function headings(): array
  {
    return [
      [
        'NO. LANGGANAN',
        'NAMA',
        'ALAMAT',
        'KODE PEMBACA',
        'STAND INI',
        'TGL. BACA',
        'STATUS BACA',
      ]];
  }
}
