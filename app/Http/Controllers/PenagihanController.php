<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pembaca;
use App\Models\Tagihan;
use App\Models\Pengguna;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenagihanController extends Controller
{
    //
    public function index(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'cari' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'gagal',
                'data' => $validator->messages(),
            ], 400);
        }

        try {
            return response()->json([
                'status' => 'sukses',
                'data' => Pelanggan::whereHas('tagihan')->where('nama', 'like', '%' . $req->cari . '%')->orWhere('no_langganan', 'like', '%' . $req->cari . '%')->with('tagihan.golongan')->with('tagihan.tarifDenda')->get()->map(fn ($q) => [
                    'no_langganan' => $q->no_langganan,
                    'nama' => $q->nama,
                    'alamat' => $q->alamat,
                    'tagihan' => $q->tagihan->map(function ($r) {
                        $periode = new Carbon($r->periode);
                        $denda = $periode->addMonths(1)->day(25)->format('Ymd') < date('Ymd') ? $r->tarifDenda->nilai : 0;
                        return [
                            'id' => $r->id,
                            'stand_lalu' => $r->stand_lalu,
                            'stand_ini' => $r->stand_ini,
                            'stand_angkat' => $r->stand_angkat,
                            'stand_pasang' => $r->stand_pasang,
                            'pakai' => $r->stand_ini || $r->stand_lalu ? $r->stand_ini - $r->stand_pasang + $r->stand_angkat - $r->stand_lalu : $r->stand_ini - $r->stand_lalu,
                            'periode' => $r->periode,
                            'tagihan' => $r->harga_air + $r->biaya_lainnya + $r->biaya_meter_air + $r->biaya_materai,
                            'denda' => $denda,
                        ];
                    })
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    public function lunasi(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'gagal',
                'data' => $validator->messages(),
            ], 400);
        }

        try {
            $pengguna = Pengguna::where('api_token', $req->header('Token'))->get();
            if ($pengguna->count() > 0) {
                $pengguna  = $pengguna->first();
                if (RekeningAir::whereIn('id', $req->id)->whereNull('waktu_bayar')->count() > 0) {
                    RekeningAir::whereIn('id', $req->id)->whereNull('waktu_bayar')->update([
                        'kasir' => $pengguna->nama,
                        'waktu_bayar' => now(),
                    ]);
                    return response()->json([
                        'status' => 'sukses',
                        'data' => null,
                    ], 200);
                }
                return response()->json([
                    'status' => 'gagal',
                    'data' => 'Data tidak ditemukan',
                ], 404);
            }
            return response()->json([
                'status' => 'gagal',
                'data' => 'Pengguna tidak ditemukan',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    public function terbayar(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'gagal',
                'data' => $validator->messages(),
            ], 400);
        }

        try {
            $pengguna = Pengguna::where('api_token', $req->header('Token'))->get();
            $tanggal = explode(' - ', $req->tanggal);

            if ($pengguna->count() > 0) {
                $pengguna  = $pengguna->first();
                return response()->json([
                    'status' => 'sukses',
                    'data' => RekeningAir::where('kasir', $pengguna->nama)->whereBetween('waktu_bayar', [$tanggal[0] . ' 00:00:00', $tanggal[1] . ' 23:59:59'])->get(),
                ]);
            } 
            return response()->json([
                'status' => 'gagal',
                'data' => 'Pengguna tidak ditemukan',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
}
