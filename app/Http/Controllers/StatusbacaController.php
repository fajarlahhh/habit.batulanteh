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
      return response()->json([
        'status' => 'sukses',
        'data' => StatusBaca::all(),
      ],200);
  }
}
