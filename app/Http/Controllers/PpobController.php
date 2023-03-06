<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengguna;
use App\Models\Pelanggan;
use App\Models\RekeningAir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PpobController extends Controller
{
    public function cari(Request $req)
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
            $pengguna = Pengguna::where('api_token', $req->header('Token'))->where('penagih', 2)->get();
            if ($pengguna->count() > 0) {
                return response()->json([
                    'status' => 'sukses',
                    'data' => Pelanggan::whereHas('tagihan')->withCount('tagihan')
                        ->having('tagihan_count', '<=', 3)->where('no_langganan', $req->cari)->where('status', 1)->with('tagihan.golongan')->with('tagihan.tarifDenda')->get()->map(fn ($q) => [
                            'no_langganan' => $q->no_langganan,
                            'nama' => $q->nama,
                            'alamat' => $q->alamat,
                            'tagihan' => $q->tagihan->map(function ($r) {
                                $periode = new Carbon($r->periode);
                                $denda = $periode->addMonths(1)->day(25)->format('Ymd') < date('Ymd') ? $r->tarifDenda->nilai : 0;
                                return [
                                    'id' => $r->id,
                                    'pakai' => $r->stand_ini || $r->stand_lalu ? $r->stand_ini - $r->stand_pasang + $r->stand_angkat - $r->stand_lalu : $r->stand_ini - $r->stand_lalu,
                                    'periode' => $r->periode,
                                    'tagihan' => $r->harga_air + $r->biaya_lainnya + $r->biaya_meter_air + $r->biaya_admin + $r->biaya_materai,
                                    'denda' => $denda,
                                ];
                            })
                        ]),
                ]);
            }
            return response()->json([
                'status' => 'gagal',
                'data' => 'Kredensial tidak valid',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => 'Terjadi kesalahan di server',
            ], 500);
        }
    }

    public function bayar(Request $req)
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
            $pengguna = Pengguna::where('api_token', $req->header('Token'))->where('penagih', 2)->get();
            if ($pengguna->count() > 0) {
                $pengguna  = $pengguna->first();
                if (collect($req->id)->count() <= 3) {
                    if (RekeningAir::whereIn('id', $req->id)->whereNull('waktu_bayar')->count() == collect($req->id)->count()) {
                        DB::transaction(function () use($pengguna, $req) {
                            foreach (RekeningAir::whereIn('id', $req->id)->get() as $key => $row) {
                                $periode = new Carbon($row->periode);
                                $denda = $periode->addMonths(1)->day(25)->format('Ymd') < date('Ymd') ? $row->tarifDenda->nilai : 0;
                                RekeningAir::where('id', $row->id)->whereNull('waktu_bayar')->update([
                                    'kasir' => $pengguna->nama,
                                    'waktu_bayar' => now(),
                                    'biaya_denda' => $denda
                                ]);
                            }
                        });
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
                    'data' => 'Transaksi tidak sah',
                ], 401);
            }
            return response()->json([
                'status' => 'gagal',
                'data' => 'Kredensial tidak valid',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => 'Terjadi kesalahan di server',
            ], 500);
        }
    }

    public function data(Request $req)
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
            $pengguna = Pengguna::where('api_token', $req->header('Token'))->where('penagih', 2)->get();

            if ($pengguna->count() > 0) {
                $tanggal = explode(' - ', $req->tanggal);
                $pengguna  = $pengguna->first();
                return response()->json([
                    'status' => 'sukses',
                    'data' => RekeningAir::with('pelanggan')->where('kasir', $pengguna->nama)->whereBetween('waktu_bayar', [$tanggal[0] . ' 00:00:00', $tanggal[1] . ' 23:59:59'])->get()->map(fn ($q) => [
                        "id" => $q->id,
                        "no_langganan" => $q->pelanggan->no_langganan,
                        "periode" => $q->periode,
                        'pakai' => $q->stand_ini || $q->stand_lalu ? $q->stand_ini - $q->stand_pasang + $q->stand_angkat - $q->stand_lalu : $q->stand_ini - $q->stand_lalu,
                        "waktu_bayar" => $q->waktu_bayar,
                        "kasir" => $q->kasir,
                        "jumlah" => $q->harga_air + $q->biaya_lainnya + $q->biaya_meter_air + $q->biaya_admin + $q->biaya_materai + $q->biaya_denda,
                    ]),
                ]);
            }
            return response()->json([
                'status' => 'gagal',
                'data' => 'Kredensial tidak valid',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => 'Terjadi kesalahan di server',
            ], 500);
        }
    }
}
