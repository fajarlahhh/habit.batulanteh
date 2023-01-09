<?php

namespace App\Imports;

use App\Models\BacaMeter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BacameterImport implements ToModel, WithStartRow
{
  public $pengguna;

  public function __construct($pengguna)
  {
    $this->pengguna = $pengguna;
  }

  public function model(array $row)
  {
    return new BacaMeter([
      'pengguna_id' => $this->pengguna,
      'no_langganan' => $row[0],
      'nama' => $row[1],
      'alamat' => $row[2],
      'periode' => $row[3] . '-01',
      'pembaca_kode' => $row[4],
    ]);
  }

  public function startRow(): int
  {
    return 2;
  }
}
