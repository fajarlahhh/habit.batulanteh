<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use App\Models\Pengguna;
use App\Models\BacaMeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BacameterController extends Controller
{
    //
    public function index(Request $req)
    {
        $periode = date('Y-m-01');
        try {
            $pengguna = Pengguna::select('id')->where('api_token', $req->header('Token'))->where('bacameter', 1)->get();
            if ($pengguna->count() > 0) {
                $pengguna  = $pengguna->first();
                return response()->json([
                    'status' => 'sukses',
                    'data' => BacaMeter::withoutGlobalScopes()->with(['pelanggan.rekeningAirTigaTerakhir' => function ($q) {
                        return  $q->take(3);
                    }])->where('periode', $periode)->whereNull('tanggal_baca')->where('pembaca_id', $pengguna->id)->get()->map(fn ($q) => [
                        'id' => $q->id,
                        'no_langganan' => $q->pelanggan->no_langganan,
                        'nama' => $q->pelanggan->nama,
                        'alamat' => $q->pelanggan->alamat,
                        'rayon' => $q->rayon->nama,
                        'periode' => $q->periode,
                        'stand_lalu' => $q->stand_lalu,
                        'stand_ini' => $q->stand_ini,
                        'latitude' => $q->latitude,
                        'longitude' => $q->longitude,
                        'rekeningAirTigaTerakhir' => $q->pelanggan->rekeningAirTigaTerakhir->map(fn ($r) => [
                            'periode' => $r->periode,
                            'pakai' => $r->stand_pasang || $r->stand_angkat ? ($r->stand_ini - $r->stand_pasang) + ($r->stand_angkat - $r->stand_lalu) : $r->stand_ini - $r->stand_lalu,
                        ])
                    ]),
                ], 200);
            } else {
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'Kredensial tidak valid',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage(),
            ], 500);
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
            ], 400);
        }

        try {
            $pengguna = Pengguna::select('id')->where('api_token', $req->header('Token'))->where('bacameter', 1)->get();
            if ($pengguna->count() > 0) {
                $gambar = $req->file('file');
                $namaFile = date('YmdHims') . time() . uniqid() . '.' . $gambar->getClientOriginalExtension();
                Storage::putFileAs('public/bacameter/', $gambar, $namaFile);
                BacaMeter::where('id', $req->id)->withoutGlobalScopes()->update([
                    'stand_ini' => $req->stand,
                    'status_baca' => $req->status_baca,
                    'tanggal_baca' => $req->tanggal_baca,
                    'latitude' => $req->latitude,
                    'longitude' => $req->longitude,
                    'foto' => 'public/bacameter/' . $namaFile
                ]);
                return response()->json([
                    'status' => 'sukses',
                    'data' => null,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'Kredensial tidak valid',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
}
