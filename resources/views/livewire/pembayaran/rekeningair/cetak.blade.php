@section('content')
    @foreach ($data as $row)
        @if ($row->rekening_air)
            <div class="row width-full f-s-12" style="page-break-inside: avoid; height: 360px">
                <div class="col-xs-4">
                    <img src="/assets/img/logo/favicon.png"
                        class="width-20"><strong>{{ config('constants.perusahaan') }}</strong>
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
                                {{ $row->rekening_air->waktu_bayar }}
                            </td>
                        </tr>
                        <tr>
                            <td class="width-100">No. Langganan</td>
                            <td class="width-10">:</td>
                            <td colspan="2">
                                {{ $row->rekening_air->pelanggan->no_langganan }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->rekening_air->pelanggan->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->rekening_air->pelanggan->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td>Golongan</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->rekening_air->pelanggan->golongan->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ date('Y-m', strtotime($row->rekening_air->periode)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Stand Meter</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $row->rekening_air->stand_ini . ' - ' . $row->rekening_air->stand_lalu . ' = ' . $row->rekening_air->pakai }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tagihan Air</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">
                                {{ number_format($row->rekening_air->harga_air + $row->rekening_air->biaya_pemeliharaan + $row->rekening_air->biaya_administrasi + $row->rekening_air->biaya_ppn - $row->rekening_air->diskon) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Denda</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->rekening_air->biaya_denda) }}</td>
                        </tr>
                        <tr>
                            <td>Materai</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->rekening_air->biaya_materai) }}</td>
                        </tr>
                        <tr>
                            <td>Retribusi</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">
                                {{ number_format($row->rekening_air->biaya_jasa_lingkungan + $row->rekening_air->biaya_retribusi) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Diskon</td>
                            <td>:</td>
                            <td>Rp.</td>
                            <td class="text-right">{{ number_format($row->rekening_air->diskon) }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>:</th>
                            <th>Rp.</th>
                            <th class="text-right">
                                {{ number_format($row->rekening_air->harga_air + $row->rekening_air->biaya_denda + $row->rekening_air->biaya_materai + $row->rekening_air->biaya_jasa_lingkungan + $row->rekening_air->biaya_retribusi + $row->rekening_air->biaya_pemeliharaan + $row->rekening_air->biaya_administrasi - $row->rekening_air->diskon) }}
                            </th>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td>:</td>
                            <td>
                                {{ $row->rekening_air->kasir }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-8 p-l-40">
                    <div class="row ml-5">
                        <div class="col-sm-12">
                            <img src="/assets/img/logo/favicon.png" class="width-20"><strong class="p-t-10">
                                {{ config('constants.perusahaan') }}</strong>
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
                                        {{ $row->rekening_air->pelanggan->no_langganan }}
                                    </td>
                                    <td class="width-100">Tanggal Lunas</td>
                                    <td class="width-10">:</td>
                                    <td colspan="2">
                                        {{ $row->rekening_air->waktu_bayar }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td colspan="2" class="p-r-5">
                                        {{ $row->rekening_air->pelanggan->nama }}
                                    </td>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td colspan="2">
                                        {{ date('Y-m', strtotime($row->rekening_air->periode)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td colspan="2" class="p-r-5">
                                        {{ $row->rekening_air->pelanggan->alamat }}
                                    </td>
                                    <td>Stand Meter</td>
                                    <td>:</td>
                                    <td colspan="2">
                                        {{ $row->rekening_air->stand_ini . ' - ' . $row->rekening_air->stand_lalu . ' = ' . $row->rekening_air->pakai }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Golongan</td>
                                    <td>:</td>
                                    <td colspan="2" class="p-r-5">
                                        {{ $row->rekening_air->pelanggan->golongan->nama }}
                                    </td>
                                    <td>Kasir</td>
                                    <td>:</td>
                                    <td colspan="2">
                                        {{ $row->rekening_air->kasir }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tagihan Air</td>
                                    <td>:</td>
                                    <td>Rp.</td>
                                    <td class="text-right p-r-5">
                                        {{ number_format($row->rekening_air->harga_air + $row->rekening_air->biaya_pemeliharaan + $row->rekening_air->biaya_administrasi + $row->rekening_air->biaya_ppn - $row->rekening_air->diskon) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Denda</td>
                                    <td>:</td>
                                    <td>Rp.</td>
                                    <td class="text-right p-r-5">{{ number_format($row->rekening_air->biaya_denda) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Materai</td>
                                    <td>:</td>
                                    <td>Rp.</td>
                                    <td class="text-right p-r-5">{{ number_format($row->rekening_air->biaya_materai) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Retribusi</td>
                                    <td>:</td>
                                    <td>Rp.</td>
                                    <td class="text-right p-r-5">
                                        {{ number_format($row->rekening_air->biaya_retribusi + $row->rekening_air->biaya_jasa_lingkungan) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td>:</td>
                                    <td>Rp.</td>
                                    <td class="text-right p-r-5">{{ number_format($row->rekening_air->diskon) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th>:</th>
                                    <th>Rp.</th>
                                    <th class="text-right p-r-5">
                                        {{ number_format($row->rekening_air->harga_air + $row->rekening_air->biaya_denda + $row->rekening_air->biaya_materai + $row->rekening_air->biaya_jasa_lingkungan + $row->rekening_air->biaya_retribusi + $row->rekening_air->biaya_pemeliharaan + $row->rekening_air->biaya_administrasi - $row->rekening_air->diskon) }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <table class="width-full f-s-10">
                                <tr>
                                    <td class="width-400">
                                        <ul>
                                            <li>PT AIR MINUM GIRI MENANG (PERSERODA) Menyatakan Struk ini Sebagai Bukti
                                                Pembayaran Yang Sah, Mohon Disimpan.</li>
                                            <li>Apabila memiliki tunggakan rekening air selama 2 bulan dan hingga bulan
                                                berikutnya belum melakukan pembayaran atas tunggakan beserta rekening
                                                air bulan berjalan akan dilakukan penutupan sementara tanpa surat
                                                pemberitahuan terlebih dahulu.</li>
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        <label>{{ $data_tanda_tangan->jabatan->nm_jabatan }}</label>
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
        @endif
        @if ($row->angsuran)
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
        @endif
    @endforeach
@endsection
