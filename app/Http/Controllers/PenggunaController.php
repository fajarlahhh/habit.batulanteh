<?php

namespace App\Http\Controllers;

use App\Models\Pembaca;
use Illuminate\Http\Request;
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
