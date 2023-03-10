<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', \App\Http\Livewire\Dashboard::class);
    Route::get('/gantisandi', \App\Http\Livewire\Gantisandi::class);
    Route::prefix('administrator')->group(function () {
        Route::prefix('datapembayaran')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|administratordatapembayaranrekeningair']], function () {
                Route::get('/rekeningair', \App\Http\Livewire\Administrator\Datapembayaran\Rekeningair::class)->name('administrator.datapembayaran.rekeningair');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|administratordatapembayaranrekeningnonair']], function () {
                Route::get('/rekeningnonair', \App\Http\Livewire\Administrator\Datapembayaran\Rekeningnonair::class)->name('administrator.datapembayaran.rekeningnonair');
            });
        });
        Route::group(['middleware' => ['role_or_permission:administrator|administratorbuattarget']], function () {
            Route::get('/mutasigolongan', \App\Http\Livewire\Administrator\Mutasigolongan::class)->name('administrator.mutasigolongan');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|administratormutasiwm']], function () {
            Route::get('/mutasiwm', \App\Http\Livewire\Administrator\Mutasiwatermeter::class)->name('administrator.mutasiwm');
        });
        Route::prefix('mutasistatus')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|administratormutasipelanggansegel']], function () {
                Route::get('/segel', \App\Http\Livewire\Administrator\Mutasistatus\Segel::class)->name('administrator.mutasistatus.segel');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|administratormutasipelangganbongkar']], function () {
                Route::get('/bongkar', \App\Http\Livewire\Administrator\Mutasistatus\Bongkar::class)->name('administrator.mutasistatus.bongkar');
            });
        });
    });

    Route::prefix('bacameter')->group(function () {
        Route::group(['middleware' => ['role_or_permission:administrator|bacameterbuattarget']], function () {
            Route::get('/buattarget', \App\Http\Livewire\Bacameter\Buattarget::class)->name('bacameter.buattarget');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|bacameterdatatarget']], function () {
            Route::get('/datatarget', \App\Http\Livewire\Bacameter\Datatarget\Index::class)->name('bacameter.datatarget');
            Route::get('/datatarget/edit/{key}', \App\Http\Livewire\Bacameter\Datatarget\Form::class)->name('bacameter.datatarget.edit');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|bacameterpostingrekeningair']], function () {
            Route::get('/postingrekeningair', \App\Http\Livewire\Bacameter\Postingrekeningair::class)->name('bacameter.postingrekeningair');
        });
    });

    Route::prefix('pengaturan')->group(function () {
        Route::group(['middleware' => ['role_or_permission:administrator|pengaturanpengguna']], function () {
            Route::get('/pengguna', \App\Http\Livewire\Pengaturan\Pengguna\Index::class)->name('pengaturan.pengguna');
            Route::get('/pengguna/tambah', \App\Http\Livewire\Pengaturan\Pengguna\Form::class)->name('pengaturan.pengguna.tambah');
            Route::get('/pengguna/edit/{key}', \App\Http\Livewire\Pengaturan\Pengguna\Form::class)->name('pengaturan.pengguna.edit');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|pengaturankolektifpelanggan']], function () {
            Route::get('/kolektifpelanggan', \App\Http\Livewire\Pengaturan\Kolektifpelanggan\Index::class)->name('pengaturan.kolektifpelanggan');
            Route::get('/kolektifpelanggan/tambah', \App\Http\Livewire\Pengaturan\Kolektifpelanggan\Form::class)->name('pengaturan.kolektifpelanggan.tambah');
            Route::get('/kolektifpelanggan/edit/{key}', \App\Http\Livewire\Pengaturan\Kolektifpelanggan\Form::class)->name('pengaturan.kolektifpelanggan.edit');
        });
    });

    Route::prefix('cetak')->group(function () {
        Route::group(['middleware' => ['role_or_permission:administrator|cetakdrd']], function () {
            Route::get('/drd', \App\Http\Livewire\Cetak\Drd::class)->name('cetak.drd');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|cetakdspl']], function () {
            Route::get('/dspl', \App\Http\Livewire\Cetak\Dspl::class)->name('cetak.dspl');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|cetakira']], function () {
            Route::get('/ira', \App\Http\Livewire\Cetak\Ira::class)->name('cetak.ira');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|cetakkoreksirekeningair']], function () {
            Route::get('/koreksirekeningair', \App\Http\Livewire\Cetak\Koreksirekeningair::class)->name('cetak.koreksirekeningair');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|cetakdaftarpenerbitanmanual']], function () {
            Route::get('/daftarpenerbitanrekairmanual', \App\Http\Livewire\Cetak\Daftarpenerbitanrekairmanual::class)->name('cetak.daftarpenerbitanrekairmanual');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|cetakdaftarpergantianstatuspelanggan']], function () {
            Route::get('/daftarpergantianstatuspelanggan', \App\Http\Livewire\Cetak\Daftarpergantianstatuspelanggan::class)->name('cetak.daftarpergantianstatuspelanggan');
        });
        Route::prefix('lpp')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|cetaklppair']], function () {
                Route::get('/air', \App\Http\Livewire\Cetak\Lpp\Air::class)->name('cetak.lpp.air');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|cetaklppnonair']], function () {
                Route::get('/nonair', \App\Http\Livewire\Cetak\Lpp\Nonair::class)->name('cetak.lpp.nonair');
            });
        });
        Route::prefix('pembatalan')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|cetakpembatalanair']], function () {
                Route::get('/air', \App\Http\Livewire\Cetak\Pembatalan\Air::class)->name('cetak.pembatalan.air');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|cetakpembatalannonair']], function () {
                Route::get('/nonair', \App\Http\Livewire\Cetak\Pembatalan\Nonair::class)->name('cetak.pembatalan.nonair');
            });
        });
        Route::group(['middleware' => ['role_or_permission:administrator|cetakprogresbacameter']], function () {
            Route::get('/progresbacameter', \App\Http\Livewire\Cetak\Progresbacameter::class)->name('cetak.progresbacameter');
        });
    });

    Route::prefix('datamaster')->group(function () {
        Route::group(['middleware' => ['role_or_permission:administrator|datamasterdiameter']], function () {
            Route::get('/diameter', \App\Http\Livewire\Datamaster\Diameter\Index::class)->name('datamaster.diameter');
            Route::get('/diameter/tambah', \App\Http\Livewire\Datamaster\Diameter\Form::class)->name('datamaster.diameter.tambah');
            Route::get('/diameter/edit/{key}', \App\Http\Livewire\Datamaster\Diameter\Form::class)->name('datamaster.diameter.edit');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|datamastergolongan']], function () {
            Route::get('/golongan', \App\Http\Livewire\Datamaster\Golongan\Index::class)->name('datamaster.golongan');
            Route::get('/golongan/tambah', \App\Http\Livewire\Datamaster\Golongan\Form::class)->name('datamaster.golongan.tambah');
            Route::get('/golongan/edit/{key}', \App\Http\Livewire\Datamaster\Golongan\Form::class)->name('datamaster.golongan.edit');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|datamastermerkwatermeter']], function () {
            Route::get('/merkwatermeter', \App\Http\Livewire\Datamaster\Merkwatermeter\Index::class)->name('datamaster.merkwatermeter');
            Route::get('/merkwatermeter/tambah', \App\Http\Livewire\Datamaster\Merkwatermeter\Form::class)->name('datamaster.merkwatermeter.tambah');
            Route::get('/merkwatermeter/edit/{key}', \App\Http\Livewire\Datamaster\Merkwatermeter\Form::class)->name('datamaster.merkwatermeter.edit');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|datamasterstatusbaca']], function () {
            Route::get('/statusbaca', \App\Http\Livewire\Datamaster\Statusbaca\Index::class)->name('datamaster.statusbaca');
            Route::get('/statusbaca/tambah', \App\Http\Livewire\Datamaster\Statusbaca\Form::class)->name('datamaster.statusbaca.tambah');
            Route::get('/statusbaca/edit/{key}', \App\Http\Livewire\Datamaster\Statusbaca\Form::class)->name('datamaster.statusbaca.edit');
        });
        Route::prefix('regional')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|datamasterregionalkecamatan']], function () {
                Route::get('/kecamatan', \App\Http\Livewire\Datamaster\Regional\Kecamatan\Index::class)->name('datamaster.regional.kecamatan');
                Route::get('/kecamatan/tambah', \App\Http\Livewire\Datamaster\Regional\Kecamatan\Form::class)->name('datamaster.regional.kecamatan.tambah');
                Route::get('/kecamatan/edit/{key}', \App\Http\Livewire\Datamaster\Regional\Kecamatan\Form::class)->name('datamaster.regional.kecamatan.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamasterregionalkelurahan']], function () {
                Route::get('/kelurahan', \App\Http\Livewire\Datamaster\Regional\Kelurahan\Index::class)->name('datamaster.regional.kelurahan');
                Route::get('/kelurahan/tambah', \App\Http\Livewire\Datamaster\Regional\Kelurahan\Form::class)->name('datamaster.regional.kelurahan.tambah');
                Route::get('/kelurahan/edit/{key}', \App\Http\Livewire\Datamaster\Regional\Kelurahan\Form::class)->name('datamaster.regional.kelurahan.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamasterregionalrayon']], function () {
                Route::get('/rayon', \App\Http\Livewire\Datamaster\Regional\Rayon\Index::class)->name('datamaster.regional.rayon');
                Route::get('/rayon/tambah', \App\Http\Livewire\Datamaster\Regional\Rayon\Form::class)->name('datamaster.regional.rayon.tambah');
                Route::get('/rayon/edit/{key}', \App\Http\Livewire\Datamaster\Regional\Rayon\Form::class)->name('datamaster.regional.rayon.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamasterregionalunitpelayanan']], function () {
                Route::get('/unitpelayanan', \App\Http\Livewire\Datamaster\Regional\Unitpelayanan\Index::class)->name('datamaster.regional.unitpelayanan');
                Route::get('/unitpelayanan/tambah', \App\Http\Livewire\Datamaster\Regional\Unitpelayanan\Form::class)->name('datamaster.regional.unitpelayanan.tambah');
                Route::get('/unitpelayanan/edit/{key}', \App\Http\Livewire\Datamaster\Regional\Unitpelayanan\Form::class)->name('datamaster.regional.unitpelayanan.edit');
            });
        });
        Route::prefix('tarif')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|datamastertarifdenda']], function () {
                Route::get('/denda', \App\Http\Livewire\Datamaster\Tarif\Denda\Index::class)->name('datamaster.tarif.denda');
                Route::get('/denda/tambah', \App\Http\Livewire\Datamaster\Tarif\Denda\Form::class)->name('datamaster.tarif.denda.tambah');
                Route::get('/denda/edit/{key}', \App\Http\Livewire\Datamaster\Tarif\Denda\Form::class)->name('datamaster.tarif.denda.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamastertariflainnya']], function () {
                Route::get('/lainnya', \App\Http\Livewire\Datamaster\Tarif\Lainnya\Index::class)->name('datamaster.tarif.lainnya');
                Route::get('/lainnya/tambah', \App\Http\Livewire\Datamaster\Tarif\Lainnya\Form::class)->name('datamaster.tarif.lainnya.tambah');
                Route::get('/lainnya/edit/{key}', \App\Http\Livewire\Datamaster\Tarif\Lainnya\Form::class)->name('datamaster.tarif.lainnya.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamastertarifmaterai']], function () {
                Route::get('/materai', \App\Http\Livewire\Datamaster\Tarif\Materai\Index::class)->name('datamaster.tarif.materai');
                Route::get('/materai/tambah', \App\Http\Livewire\Datamaster\Tarif\Materai\Form::class)->name('datamaster.tarif.materai.tambah');
                Route::get('/materai/edit/{key}', \App\Http\Livewire\Datamaster\Tarif\Materai\Form::class)->name('datamaster.tarif.materai.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamastertarifmeterair']], function () {
                Route::get('/meterair', \App\Http\Livewire\Datamaster\Tarif\Meterair\Index::class)->name('datamaster.tarif.meterair');
                Route::get('/meterair/tambah', \App\Http\Livewire\Datamaster\Tarif\Meterair\Form::class)->name('datamaster.tarif.meterair.tambah');
                Route::get('/meterair/edit/{key}', \App\Http\Livewire\Datamaster\Tarif\Meterair\Form::class)->name('datamaster.tarif.meterair.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamastertarifpelayanan']], function () {
                Route::get('/pelayanan', \App\Http\Livewire\Datamaster\Tarif\Pelayanan\Index::class)->name('datamaster.tarif.pelayanan');
                Route::get('/pelayanan/tambah', \App\Http\Livewire\Datamaster\Tarif\Pelayanan\Form::class)->name('datamaster.tarif.pelayanan.tambah');
                Route::get('/pelayanan/edit/{key}', \App\Http\Livewire\Datamaster\Tarif\Pelayanan\Form::class)->name('datamaster.tarif.pelayanan.edit');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|datamastertarifprogresif']], function () {
                Route::get('/progresif', \App\Http\Livewire\Datamaster\Tarif\Progresif\Index::class)->name('datamaster.tarif.progresif');
                Route::get('/progresif/tambah', \App\Http\Livewire\Datamaster\Tarif\Progresif\Form::class)->name('datamaster.tarif.progresif.tambah');
                Route::get('/progresif/edit/{key}', \App\Http\Livewire\Datamaster\Tarif\Progresif\Form::class)->name('datamaster.tarif.progresif.edit');
            });
        });
    });

    Route::group(['middleware' => ['role_or_permission:administrator|informasipelanggan']], function () {
        Route::get('/informasipelanggan', \App\Http\Livewire\Informasipelanggan::class);
    });

    Route::group(['middleware' => ['role_or_permission:administrator|masterpelanggan']], function () {
        Route::get('/masterpelanggan', \App\Http\Livewire\Masterpelanggan\Index::class)->name('masterpelanggan');
        Route::get('/masterpelanggan/tambah', \App\Http\Livewire\Masterpelanggan\Form::class)->name('masterpelanggan.tambah');
        Route::get('/masterpelanggan/edit/{key}', \App\Http\Livewire\Masterpelanggan\Form::class)->name('masterpelanggan.edit');
    });

    Route::prefix('tagihanrekeningair')->group(function () {
        // Route::group(['middleware' => ['role_or_permission:administrator|tagihanrekeningairangsuran']], function () {
        //     Route::get('/angsuran', \App\Http\Livewire\Tagihanrekeningair\Angsuran\Form::class)->name('tagihanrekeningair.angsuran.tambah');
        //     Route::get('/angsuran/data', \App\Http\Livewire\Tagihanrekeningair\Angsuran\Index::class)->name('tagihanrekeningair.angsuran');
        // });
        Route::group(['middleware' => ['role_or_permission:administrator|tagihanrekeningairkoreksi']], function () {
            Route::get('/koreksi', \App\Http\Livewire\Tagihanrekeningair\Koreksi::class)->name('tagihanrekeningair.koreksi');
        });
        Route::group(['middleware' => ['role_or_permission:administrator|tagihanrekeningairpenerbitan']], function () {
            Route::get('/penerbitan', \App\Http\Livewire\Tagihanrekeningair\Penerbitan::class)->name('tagihanrekeningair.penerbitan');
        });
    });

    Route::prefix('pembayaran')->group(function () {
        Route::prefix('rekeningair')->group(function () {
            Route::group(['middleware' => ['role_or_permission:administrator|pembayaranrekeningairperpelanggan']], function () {
                Route::get('/perpelanggan', \App\Http\Livewire\Pembayaran\Rekeningair\Perpelanggan::class)->name('pembayaran.rekeningair.perpelanggan');
            });
            Route::group(['middleware' => ['role_or_permission:administrator|pembayaranrekeningairkolektif']], function () {
                Route::get('/kolektif', \App\Http\Livewire\Pembayaran\Rekeningair\Kolektif::class)->name('pembayaran.rekeningair.kolektif');
            });
        });
        Route::group(['middleware' => ['role_or_permission:administrator|pembayaranrekeningnonair']], function () {
            Route::get('/rekeningnonair', \App\Http\Livewire\Pembayaran\Rekeningnonair::class)->name('pembayaran.rekeningnonair');
        });
    });
});

Route::get("/", function () {
    return view("home");
});
