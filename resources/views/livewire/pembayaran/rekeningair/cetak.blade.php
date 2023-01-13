@foreach ($dataRekeningAir as $row)
    <div class="row width-full f-s-12" style="page-break-inside: avoid; height: 360px">
        <div class="col-xs-4">
            <img src="/assets/img/logo/favicon.png" class="width-20"><strong>PERUMDAM BATU LANTEH</strong>
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
                        {{ $row->bacaMeter->pelanggan->no_langganan }}
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->bacaMeter->pelanggan->nama }}
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->bacaMeter->pelanggan->alamat }}
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
                        {{ date('Y-m', strtotime($row->bacaMeter->periode)) }}
                    </td>
                </tr>
                <tr>
                    <td>Stand Meter</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $row->bacaMeter->stand_ini . ' - ' . $row->bacaMeter->stand_lalu . ' = ' . ($row->bacaMeter->stand_ini - $row->bacaMeter->stand_lalu) }}
                    </td>
                </tr>
                <tr>
                    <td>Tagihan Air</td>
                    <td>:</td>
                    <td>Rp.</td>
                    <td class="text-right">
                        {{ number_format($row->harga_air + $row->biaya_pemeliharaan + $row->biaya_administrasi + $row->biaya_ppn - $row->diskon) }}
                    </td>
                </tr>
                <tr>
                    <td>Meter Air</td>
                    <td>:</td>
                    <td>Rp.</td>
                    <td class="text-right">{{ number_format($row->biaya_meter_air) }}</td>
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
                        {{ number_format($row->harga_air + $row->biaya_meter_air + $row->biaya_denda + $row->biaya_lainnya + $row->biaya_lainnya + $row->biaya_materai + $row->biaya_ppn - $row->diskon) }}
                    </th>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>:</td>
                    <td>
                        {{ $row->kasir->nama }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xs-8 p-l-40">
            <div class="row ml-5">
                <div class="col-sm-12">
                    <img src="/assets/img/logo/favicon.png" class="width-20"><strong class="p-t-10">PERUMDAM BATU
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
                                {{ $row->bacaMeter->pelanggan->no_langganan }}
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
                                {{ $row->bacaMeter->pelanggan->nama }}
                            </td>
                            <td>Periode</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ date('Y-m', strtotime($row->bacaMeter->periode)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2" class="p-r-5">
                                {{ $row->bacaMeter->pelanggan->alamat }}
                            </td>
                            <td>Stand Meter</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->bacaMeter->stand_ini . ' - ' . $row->bacaMeter->stand_lalu . ' = ' . ($row->bacaMeter->stand_ini - $row->bacaMeter->stand_lalu) }}
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
                                {{ $row->kasir->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tagihan Air</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">
                                {{ number_format($row->harga_air + $row->biaya_pemeliharaan + $row->biaya_administrasi + $row->biaya_ppn - $row->diskon) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Meter Air</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->biaya_meter_air) }}</td>
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
                                {{ number_format($row->harga_air + $row->biaya_meter_air + $row->biaya_denda + $row->biaya_lainnya + $row->biaya_lainnya + $row->biaya_materai + $row->biaya_ppn - $row->diskon) }}
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-12">
                    <table class="width-full f-s-10">
                        <tr>
                            <td class="width-400">
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
                                <label>Direktur Utama</label>
                                <br>


                                <br>
                                <u>Abdul Hakim</u>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    {{-- @if ($row->angsuran)
            <div class="row width-full f-s-12" style="page-break-inside: avoid; height: 360px">
                <div class="col-xs-4">
                    <img src="/assets/img/logo/favicon.png" class="width-20"><strong class="p-t-10">
                        {{ config('constants.perusahaan') }}</strong>
                    <table class="width-full f-s-12">
                        <tr>
                            <td colspan="3" class="p-l-40">ANGSURAN REKENING AIR</td>
                        </tr>
                        <tr>
                            <td colspan="4">Tanggal Bayar </td>
                            <td class="width-10">:</td>
                            <td colspan="2">
                                {{ date('Y-m-d', strtotime($row->created_at)) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="width-100">No. Langganan</td>
                            <td class="width-10">:</td>
                            <td colspan="2">
                                {{ $row->angsuran->pelanggan->no_langganan }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->angsuran->pelanggan->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->angsuran->pelanggan->alamat }}
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
                                {{ $row->angsuran->urutan }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>:</th>
                            <th colspan="2">Rp. {{ number_format($row->angsuran->nilai) }}</th>
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
                                {{ $row->angsuran->kasir }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-8 p-l-40">
                    <div class="row ml-5">
                        <div class="col-xs-8">
                            <img src="/assets/img/logo/favicon.png" class="width-20"><strong class="p-t-10">
                                {{ config('constants.perusahaan') }}</strong>
                            <table class="width-full f-s-12">
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">STRUK PEMBAYARAN ANGSURAN REKENING AIR</td>
                                </tr>
                                <tr>
                                    <td colspan="4">Tanggal Bayar </td>
                                    <td class="width-10">:</td>
                                    <td colspan="2">
                                        {{ date('Y-m-d', strtotime($row->created_at)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width-150">No. Langganan</td>
                                    <td class="width-10">:</td>
                                    <td colspan="2">
                                        {{ $row->angsuran->pelanggan->no_langganan }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td colspan="2">
                                        {{ $row->angsuran->pelanggan->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td colspan="2">
                                        {{ $row->angsuran->pelanggan->alamat }}
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
                                        {{ $row->angsuran->urutan }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>:</th>
                                    <th colspan="2">Rp. {{ number_format($row->angsuran->nilai) }}</th>
                                </tr>
                                <tr>
                                    <td>Terbilang</td>
                                    <td>:</td>
                                    <td colspan="2">
                                        {{ ucwords(Terbilang::make($row->angsuran->nilai, ' rupiah')) }}</td>
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
                                        {{ $row->angsuran->kasir }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-4">
                            <table class="width-full m-t-40 f-s-12">
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="p-r-40 text-center">
                                        <br>
                                        <label class="p-r-10">{{ $data_tanda_tangan->jabatan->nm_jabatan }}</label>
                                        <br>
                                        <img src="data:image/png;base64, {{ DNS2D::getBarcodePNG(config('constants.tanda_tangan') . 'rekening-air/' . $data->first()->nomor, 'QRCODE') }}"
                                            alt="barcode" class="width-80" />
                                        <br>
                                        <u>{{ $data_tanda_tangan->nm_pegawai }}</u>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
        @endif --}}
@endforeach
