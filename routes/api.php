<?php

use App\Http\Controllers\BacameterController;
use App\Http\Controllers\PenagihanController;
use App\Http\Controllers\PpobController;
use App\Http\Controllers\StatusbacaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware(['cors'])->get('/', function () {
    return response()->json([
        'status' => 'sukses',
        'data' => 'API PERUMDAM BATU LANTEH',
    ]);
});

Route::middleware(['cors'])->post('/login', [\App\Http\Controllers\PenggunaController::class, 'login']);

Route::prefix('master')->group(function () {
    Route::middleware(['cors', 'apitoken'])->get('/statusbaca', [StatusbacaController::class, 'index']);
});

Route::prefix('bacameter')->group(function () {
    Route::middleware(['cors', 'apitoken'])->get('/target', [BacameterController::class, 'index']);
    Route::middleware(['cors', 'apitoken'])->post('/upload', [BacameterController::class, 'upload']);
});

Route::prefix('penagihan')->group(function () {
    Route::middleware(['cors', 'apitoken'])->get('/target', [PenagihanController::class, 'index']);
    Route::middleware(['cors', 'apitoken'])->post('/lunasi', [PenagihanController::class, 'lunasi']);
    Route::middleware(['cors', 'apitoken'])->post('/terbayar', [PenagihanController::class, 'terbayar']);
});

Route::prefix('ppob')->group(function () {
    Route::middleware(['cors', 'apitoken'])->get('/tunggakan', [PpobController::class, 'cari']);
    Route::middleware(['cors', 'apitoken'])->post('/bayar', [PenagihanController::class, 'lunasi']);
    Route::middleware(['cors', 'apitoken'])->get('/lpp', [PpobController::class, 'data']);
});
