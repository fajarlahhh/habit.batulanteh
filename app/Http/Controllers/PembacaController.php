<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembacaController extends Controller
{
  //
  public function login(Request $req)
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
      return response()->json([
        'status' => 'sukses',
        'data' => $pembaca,
      ]);
    }
    return response()->json([
      'status' => 'gagal',
      'data' => 'Tidak ada data petugas',
    ]);
  }
}
