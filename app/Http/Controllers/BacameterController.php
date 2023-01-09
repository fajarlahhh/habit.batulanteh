<?php

namespace App\Http\Controllers;

use App\Models\BacaMeter;
use App\Models\Pembaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BacameterController extends Controller
{
  //
  public function index(Request $req)
  {
    $validator = Validator::make($req->all(), [
      'pembaca' => 'required',
      'periode' => 'required',
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
        'data' => BacaMeter::withoutGlobalScopes()->where('periode', $req->periode)->whereNotNull('tanggal_baca')->where('pembaca_kode', $pembaca->first()->kode)->get(),
      ]);
    }
  }

  public function upload(Request $req)
  {
    $validator = Validator::make($req->all(), [
      'id' => 'required',
      'stand' => 'required',
      'status_baca' => 'required',
      'tanggal_baca' => 'required',
      'longitude' => 'required',
      'latitude' => 'required',
      'file' => 'required|image:jpeg,png,jpg',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => 'gagal',
        'data' => $validator->messages(),
      ]);
    }
    try {
      $gambar = $req->file('file');
      $extension = $gambar->getClientOriginalExtension();
      $namaFile = date('YmdHims') . time() . uniqid() . '_' . $req->id;
      $gambar->move(public_path('foto'), $namaFile . '.' . $extension);
      BacaMeter::where('id', $req->id)->withoutGlobalScopes()->update([
        'stand_ini' => $req->stand,
        'status_baca' => $req->status_baca,
        'tanggal_baca' => $req->tanggal_baca,
        'latitude' => $req->latitude,
        'longitude' => $req->longitude,
        'foto' => 'foto/' . $namaFile . '.' . $extension,
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
