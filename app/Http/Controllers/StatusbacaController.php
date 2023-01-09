<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use App\Models\StatusBaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusbacaController extends Controller
{
  //
  public function index(Request $req)
  {
    $validator = Validator::make($req->all(), [
      'pembaca' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'gagal',
        'data' => $validator->messages(),
      ]);
    }

    $pembaca = Pembaca::where('uid', $req->pembaca)->withoutGlobalScopes()->get();
    if ($pembaca->count() > 0) {
      $dataStatusBaca = StatusBaca::withoutGlobalScopes()->where('pengguna_id', $pembaca->first()->pengguna_id)->get();
      return response()->json([
        'status' => 'sukses',
        'data' => $dataStatusBaca,
      ]);
    }
    return response()->json([
      'status' => 'gagal',
      'data' => 'Tidak ada data petugas',
    ]);
  }
}
