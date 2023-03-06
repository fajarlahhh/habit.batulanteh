@foreach ($dataRekeningAir as $row)
    <div class="row width-full f-s-12" style="page-break-inside: avoid; height: 360px">
        <div class="col-xs-4">
            <img src="/assets/img/logo.png" class="width-20"><strong>PERUMDAM BATU LANTEH</strong>
            <table class="width-full f-s-12">
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" class="p-l-40">PEMBAYARAN REKENING AIR</td>
                </tr>
                <tr>
                    <td class="width-100">Tanggal Lunas</td>
                    <td class="width-10">:</td>
                    <td colspan="2">
                        {{ $row->waktu_bayar }}
                    </td>
                </tr>
                <tr>
                    <td class="width-100">No. Langganan</td>
                    <td class="width-10">:</td>
                    <td colspan="2">
                        {{ $row->pelanggan->no_langganan }}
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->pelanggan->nama }}
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->pelanggan->alamat }}
                    </td>
                </tr>
                <tr>
                    <td>Golongan</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->golongan->nama }}
                    </td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ date('Y-m', strtotime($row->periode)) }}
                    </td>
                </tr>
                <tr>
                    <td>Stand Meter</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->stand_ini . ' - ' . $row->stand_lalu . ' = ' . ($row->stand_ini - $row->stand_lalu) }}
                    </td>
                </tr>
                <tr>
                    <td>Tagihan Air</td>
                    <td>:</td>
                    <td>Rp.</td>
                    <td class="text-right">
                        {{ number_format($row->harga_air + $row->biaya_ppn - $row->diskon) }}
                    </td>
                </tr>
                <tr>
                    <td>Meter Air</td>
                    <td>:</td>
                    <td>Rp.</td>
                    <td class="text-right">{{ number_format($row->biaya_meter_air + $row->biaya_admin) }}</td>
                </tr>
                <tr>
                    <td>Denda</td>
                    <td>:</td>
                    <td>Rp.</td>
                    <td class="text-right">{{ number_format($row->biaya_denda) }}</td>
                </tr>
                <tr>
                    <td>Materai</td>
                    <td>:</td>
                    <td>Rp.</td>
                    <td class="text-right">{{ number_format($row->biaya_materai) }}</td>
                </tr>
                @if ($row->tarifLainnya)
                    <tr>
                        <td>Biaya
                            @foreach ($row->tarifLainnya->tarifLainnyaDetail as $subRow)
                                {{ $row->jenis . ' ' }}
                            @endforeach
                        </td>
                        <td>:</td>
                        <td>Rp.</td>
                        <td class="text-right">
                            {{ number_format($row->biaya_lainnya) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>Total</th>
                    <th>:</th>
                    <th>Rp.</th>
                    <th class="text-right">
                        {{ number_format($row->harga_air + $row->biaya_meter_air + $row->biaya_admin + $row->biaya_denda + $row->biaya_lainnya + $row->biaya_lainnya + $row->biaya_materai + $row->biaya_ppn - $row->diskon) }}
                    </th>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>:</td>
                    <td>
                        {{ $row->kasir }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xs-8 p-l-40">
            <div class="row ml-5">
                <div class="col-sm-12">
                    <img src="/assets/img/logo.png" class="width-20"><strong class="p-t-10">PERUMDAM BATU
                        LANTEH</strong>
                    <table class="width-full f-s-12">
                        <tr>
                            <td colspan="7">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="7">STRUK PEMBAYARAN REKENING AIR</td>
                        </tr>
                        <tr>
                            <td class="width-100">No. Langganan</td>
                            <td class="width-10">:</td>
                            <td colspan="2" class="p-r-5 width-200">
                                {{ $row->pelanggan->no_langganan }}
                            </td>
                            <td class="width-100">Tanggal Lunas</td>
                            <td class="width-10">:</td>
                            <td colspan="2">
                                {{ $row->waktu_bayar }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td colspan="2" class="p-r-5">
                                {{ $row->pelanggan->nama }}
                            </td>
                            <td>Periode</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ date('Y-m', strtotime($row->periode)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2" class="p-r-5">
                                {{ $row->pelanggan->alamat }}
                            </td>
                            <td>Pakai</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ ($row->stand_pasang || $row->stand_angkat ? ($row->stand_ini - $row->stand_pasang) + ($row->stand_angkat - $row->stand_lalu) : $row->stand_ini - $row->stand_lalu) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Golongan</td>
                            <td>:</td>
                            <td colspan="2" class="p-r-5">
                                {{ $row->golongan->nama }}
                            </td>
                            <td>Kasir</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->kasir }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tagihan Air</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">
                                {{ number_format($row->harga_air + $row->biaya_ppn - $row->diskon) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Meter Air</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->biaya_meter_air + $row->biaya_admin) }}</td>
                        </tr>
                        <tr>
                            <td>Denda</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->biaya_denda) }}</td>
                        </tr>
                        <tr>
                            <td>Materai</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->biaya_materai) }}</td>
                        </tr>
                        @if ($row->tarifLainnya)
                            <tr>
                                <td>Biaya
                                    @foreach ($row->tarifLainnya->tarifLainnyaDetail as $subRow)
                                        {{ $row->jenis . ' ' }}
                                    @endforeach
                                </td>
                                <td>:</td>
                                <td>Rp.</td>
                                <td class="text-right">
                                    {{ number_format($row->biaya_lainnya) }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>Total</th>
                            <th>:</th>
                            <th>Rp.</th>
                            <th class="text-right">
                                {{ number_format($row->harga_air + $row->biaya_meter_air + $row->biaya_admin + $row->biaya_denda + $row->biaya_lainnya + $row->biaya_lainnya + $row->biaya_materai + $row->biaya_ppn - $row->diskon) }}
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-12">
                    <table class="width-full">
                        <tr>
                            <td class="width-300 f-s-10">
                                <ul>
                                    <li>PERUMDAM BATU LANTEH Menyatakan Struk ini Sebagai Bukti
                                        Pembayaran Yang Sah, Mohon Disimpan.</li>
                                    <li>Apabila memiliki tunggakan rekening air selama 2 bulan dan hingga bulan
                                        berikutnya belum melakukan pembayaran atas tunggakan beserta rekening
                                        air bulan berjalan akan dilakukan penutupan sementara tanpa surat
                                        pemberitahuan terlebih dahulu.</li>
                                </ul>
                            </td>
                            <td class="text-center">
                                Direktur Utama<br>
                                <img src="/assets/img/ttd.png" alt="" class="height-70">
                                <br>
                                <u>H. Abdul Hakim</u>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach
@foreach ($dataAngsuranRekeningAir as $row)
    <div class="row width-full f-s-12" style="page-break-inside: avoid; height: 360px">
        <div class="col-xs-4">
            <img src="/assets/img/logo.png" class="width-20"><strong class="p-t-10">
                PERUMDAM BATU LANTEH</strong>
            <table class="width-full f-s-12">
                <tr>
                    <td colspan="4" class="p-l-40">STRUK PEMBAYARAN ANGSURAN REKENING AIR</td>
                </tr>
                <tr>
                    <td class="width-100">Tanggal Bayar </td>
                    <td class="width-10">:</td>
                    <td colspan="2">
                        {{ $row->waktu_bayar }}
                    </td>
                </tr>
                <tr>
                    <td>No. Langganan</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->angsuranRekeningAir->pelanggan->no_langganan }}
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->angsuranRekeningAir->pelanggan->nama }}
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->angsuranRekeningAir->pelanggan->alamat }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>Angsuran Ke</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->urutan }}
                    </td>
                </tr>
                <tr>
                    <th>Total</th>
                    <th>:</th>
                    <th colspan="2">Rp. {{ number_format($row->nilai) }}</th>
                </tr>
                <tr>
                    <td colspan="4">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>:</td>
                    <td>
                        {{ $row->kasir }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xs-8 p-l-40">
            <div class="row ml-5">
                <div class="col-sm-12">
                    <img src="/assets/img/logo.png" class="width-20"><strong class="p-t-10">
                        PERUMDAM BATU LANTEH</strong>
                    <table class="width-full f-s-12">
                        <tr>
                            <td colspan="3">STRUK PEMBAYARAN ANGSURAN REKENING AIR</td>
                        </tr>
                        <tr>
                            <td class="width-100">Tanggal Bayar </td>
                            <td class="width-10">:</td>
                            <td colspan="2">
                                {{ $row->waktu_bayar }}
                            </td>
                        </tr>
                        <tr>
                            <td>No. Langganan</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->angsuranRekeningAir->pelanggan->no_langganan }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->angsuranRekeningAir->pelanggan->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->angsuranRekeningAir->pelanggan->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>Angsuran Ke</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->urutan }}
                            </td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>:</th>
                            <th colspan="2">Rp. {{ number_format($row->nilai) }}</th>
                        </tr>
                        <tr>
                            <td>Terbilang</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ ucwords(Terbilang::make($row->nilai, ' rupiah')) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top">Kasir</td>
                            <td class="align-top">:</td>
                            <td class="align-top width-300">
                                {{ $row->kasir }}
                            </td>
                            <td class="text-center">
                                Direktur Utama<br>
                                <img src="/assets/img/ttd.png" alt="" class="height-70">
                                <br>
                                <u>H. Abdul Hakim</u>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach
