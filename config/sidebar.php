<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
     */

    'menu' => [[
        'icon' => 'fas fa-home',
        'title' => 'Dashboard',
        'url' => '/dashboard',
        'id' => 'dashboard',
    ], [
        'icon' => 'fas fa-gavel',
        'title' => 'Administrator',
        'url' => 'javascript:;',
        'caret' => true,
        'id' => 'administrator',
        'sub_menu' => [[
            'url' => 'javascript:;',
            'caret' => true,
            'title' => 'Data Pembayaran',
            'id' => 'administratordatapembayaran',
            'sub_menu' => [
                //     [
                //     'url' => '/administrator/datapembayaran/angsuranrekeningair',
                //     'id' => 'administratordatapembayaranangsuranrekeningair',
                //     'title' => 'Angsuran Rekening Air',
                // ],
                [
                    'url' => '/administrator/datapembayaran/rekeningair',
                    'id' => 'administratordatapembayaranrekeningair',
                    'title' => 'Rekening Air',
                ], [
                    'url' => '/administrator/datapembayaran/rekeningnonair',
                    'id' => 'administratordatapembayaranrekeningnonair',
                    'title' => 'Rekening Non Air',
                ]],
        ], [
            'url' => '/administrator/statuspelanggan',
            'id' => 'administratorstatuspelanggan',
            'title' => 'Status Pelanggan',
        ]],
    ], [
        'icon' => 'fas fa-tachometer-alt',
        'title' => 'Baca Meter',
        'url' => 'javascript:;',
        'caret' => true,
        'id' => 'bacameter',
        'sub_menu' => [[
            'url' => '/bacameter/buattarget',
            'id' => 'bacameterbuattarget',
            'title' => 'Buat Target',
        ], [
            'url' => '/bacameter/datatarget',
            'id' => 'bacameterdatatarget',
            'title' => 'Data Target',
        ], [
            'url' => '/bacameter/postingrekeningair',
            'id' => 'bacameterpostingrekeningair',
            'title' => 'Posting Rekening Air',
        ]],
    ], [
        'icon' => 'fas fa-file',
        'title' => 'Cetak',
        'url' => 'javascript:;',
        'caret' => true,
        'id' => 'cetak',
        'sub_menu' => [[
            'url' => '/cetak/dspl',
            'id' => 'cetakdspl',
            'title' => 'DSPL',
        ], [
            'url' => '/cetak/ira',
            'id' => 'cetakira',
            'title' => 'IRA',
        ], [
            'url' => '/cetak/koreksirekeningair',
            'id' => 'cetakkoreksirekeningair',
            'title' => 'Koreksi Rekening Air',
        ], [
            'url' => '/cetak/lpprekair',
            'id' => 'cetaklpprekair',
            'title' => 'LPP Rek. Air',
        ], [
            'url' => '/cetak/progresbacameter',
            'id' => 'cetakprogresbacameter',
            'title' => 'Progres Baca Meter',
        ]],
    ], [
        'icon' => 'fas fa-database',
        'title' => 'Data Master',
        'url' => 'javascript:;',
        'caret' => true,
        'id' => 'datamaster',
        'sub_menu' => [[
            'url' => '/datamaster/diameter',
            'id' => 'datamasterdiameter',
            'title' => 'Diameter',
        ], [
            'url' => '/datamaster/golongan',
            'id' => 'datamastergolongan',
            'title' => 'Golongan',
        ], [
            'url' => '/datamaster/merkwatermeter',
            'id' => 'datamastermerkwatermeter',
            'title' => 'Merk Water Meter',
        ], [
            'title' => 'Regional',
            'url' => 'javascript:;',
            'caret' => true,
            'id' => 'datamasterregional',
            'sub_menu' => [[
                'url' => '/datamaster/regional/jalan',
                'id' => 'datamasterregionaljalan',
                'title' => 'Jalan',
            ], [
                'url' => '/datamaster/regional/kecamatan',
                'id' => 'datamasterregionalkecamatan',
                'title' => 'Kecamatan',
            ], [
                'url' => '/datamaster/regional/kelurahan',
                'id' => 'datamasterregionalkelurahan',
                'title' => 'Kelurahan',
            ], [
                'url' => '/datamaster/regional/rayon',
                'id' => 'datamasterregionalrayon',
                'title' => 'Rayon',
            ], [
                'url' => '/datamaster/regional/unitpelayanan',
                'id' => 'datamasterregionalunitpelayanan',
                'title' => 'Unit Pelayanan',
            ]],
        ], [
            'url' => '/datamaster/statusbaca',
            'id' => 'datamasterstatusbaca',
            'title' => 'Status Baca',
        ], [
            'url' => 'javascript:;',
            'caret' => true,
            'id' => 'datamastertarif',
            'title' => 'Tarif',
            'sub_menu' => [[
                'url' => '/datamaster/tarif/denda',
                'id' => 'datamastertarifdenda',
                'title' => 'Denda',
            ], [
                'url' => '/datamaster/tarif/lainnya',
                'id' => 'datamastertariflainnya',
                'title' => 'Lainnya',
            ], [
                'url' => '/datamaster/tarif/materai',
                'id' => 'datamastertarifmaterai',
                'title' => 'Materai',
            ], [
                'url' => '/datamaster/tarif/meterair',
                'id' => 'datamastertarifmeterair',
                'title' => 'Meter Air',
            ], [
                'url' => '/datamaster/tarif/pelayanan',
                'id' => 'datamastertarifpelayanan',
                'title' => 'Pelayanan/Sangsi',
            ], [
                'url' => '/datamaster/tarif/progresif',
                'id' => 'datamastertarifprogresif',
                'title' => 'Progresif',
            ]],
        ]],
    ], [
        'icon' => 'fas fa-info-circle',
        'title' => 'Informasi Pelanggan',
        'url' => '/informasipelanggan',
        'id' => 'informasipelanggan',
    ], [
        'icon' => 'fas fa-user-friends',
        'url' => '/masterpelanggan',
        'id' => 'masterpelanggan',
        'title' => 'Master Pelanggan',
    ], [
        'icon' => 'fas fa-cash-register',
        'title' => 'Pembayaran',
        'url' => 'javascript:;',
        'id' => 'pembayaran',
        'caret' => true,
        'sub_menu' => [[
            'title' => 'Rekening Air',
            'url' => 'javascript:;',
            'caret' => true,
            'id' => 'pembayaranrekeningair',
            'sub_menu' => [[
                'url' => '/pembayaran/rekeningair/kolektif',
                'id' => 'pembayaranrekeningairkolektif',
                'title' => 'Kolektif',
            ], [
                'url' => '/pembayaran/rekeningair/perpelanggan',
                'id' => 'pembayaranrekeningairperpelanggan',
                'title' => 'Per Pelanggan',
            ]],
        ], [
            'url' => '/pembayaran/rekeningnonair',
            'id' => 'pembayaranrekeningnonair',
            'title' => 'Rekening Non Air',
        ]],
    ], [
        'icon' => 'fas fa-cog',
        'title' => 'Pengaturan',
        'url' => 'javascript:;',
        'caret' => true,
        'id' => 'pengaturan',
        'sub_menu' => [[
            'url' => '/pengaturan/kolektifpelanggan',
            'id' => 'pengaturankolektifpelanggan',
            'title' => 'Kolektif Pelanggan',
        ], [
            'url' => '/pengaturan/pengguna',
            'id' => 'pengaturanpengguna',
            'title' => 'Pengguna',
        ], [
            'url' => '/pengaturan/rutebaca',
            'id' => 'pengaturanrutebaca',
            'title' => 'Rute Baca',
        ]],
    ], [
        'icon' => 'fas fa-file-invoice',
        'title' => 'Tagihan Rekening Air',
        'url' => 'javascript:;',
        'caret' => true,
        'id' => 'tagihanrekeningair',
        'sub_menu' => [
            //     [
            //     'url' => '/tagihanrekeningair/angsuran',
            //     'id' => 'tagihanrekeningairangsuran',
            //     'title' => 'Angsuran',
            // ],
            [
                'url' => '/tagihanrekeningair/koreksi',
                'id' => 'tagihanrekeningairkoreksi',
                'title' => 'Koreksi',
            ], [
                'url' => '/tagihanrekeningair/penerbitan',
                'id' => 'tagihanrekeningairpenerbitan',
                'title' => 'Penerbitan',
            ]],
    ]],
];
