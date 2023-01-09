<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenagihanController extends Controller
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
      return response()->json([
        'status' => 'sukses',
        'data' => Tagihan::withoutGlobalScopes()->where('pembaca_kode', $pembaca->first()->kode)->get(),
      ]);
    }
    return response()->json([
      'status' => 'gagal',
      'data' => 'Tidak ada data petugas',
    ]);
  }

  public function lunasi(Request $req)
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required',
      'tanggal_tagih' => 'required',
      'longitude' => 'required',
      'latitude' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => 'gagal',
        'data' => $validator->messages(),
      ]);
    }

    try {
      Tagihan::where('id', $req->id)->withoutGlobalScopes()->update([
        'tanggal_tagih' => $req->tanggal_tagih,
        'latitude' => $req->latitude,
        'longitude' => $req->longitude,
      ]);
      return response()->json([
        'status' => 'sukses',
        'data' => null,
      ]);
    } catch (\Exception$e) {
      return response()->json([
        'status' => 'gagal',
        'data' => $e->getMessage(),
      ]);
    }
  }
}
