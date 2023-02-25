<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    //
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'uid' => 'required',
            'kata_sandi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'gagal',
                'data' => $validator->messages(),
            ], 400);
        }

        try {
            $pengguna = Pengguna::where('uid', $req->uid)->withoutGlobalScopes()->get();
            if ($pengguna->count() > 0) {
                $pengguna = $pengguna->first();
                if (Hash::check($req->kata_sandi, $pengguna->kata_sandi)) {
                    return response()->json([
                        'status' => 'sukses',
                        'data' => [
                            'nama' => $pengguna->nama,
                            'uid' => $pengguna->uid,
                            'deskripsi' => $pengguna->deskripsi,
                            'api_token' => $pengguna->api_token,
                        ],
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'gagal',
                        'data' => 'Kata sandi salah',
                    ], 401);
                }
            }
            return response()->json([
                'status' => 'gagal',
                'data' => 'UID salah',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'gagal',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
}
