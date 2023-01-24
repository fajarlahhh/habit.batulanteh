<div class="row width-full f-s-12">
    <div class="col-xs-4">
        <img src="/assets/img/logo.png" class="width-20"><strong>PERUMDAM BATU LANTEH</strong>
        <table class="width-full f-s-12">
            <tr>
                <td colspan="3">STRUK PEMBAYARAN REKENING NON AIR</td>
            </tr>
            <tr>
                <td class="width-100">No.</td>
                <td class="width-10">:</td>
                <td>{{ $dataRekeningNonAir->nomor }}</td>
            </tr>
            <tr>
                <td colspan="3">Telah Terima Dari</td>
            </tr>
            @if ($dataRekeningNonAir->pelanggan_id)
                <tr>
                    <td>No Pelanggan</td>
                    <td>:</td>
                    <td>{{ $dataRekeningNonAir->pelanggan->no_langganan }}
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>
                        {{ $dataRekeningNonAir->pelanggan->nama }}
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>
                        {{ $dataRekeningNonAir->pelanggan->alamat }}
                    </td>
                </tr>
                <tr>
                    <td>No. Hp</td>
                    <td>:</td>
                    <td>
                        {{ $dataRekeningNonAir->pelanggan->no_hp }}
                    </td>
                </tr>
            @else
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>
                        {{ $dataRekeningNonAir->nama }}
                    </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>
                        {{ $dataRekeningNonAir->alamat }}
                    </td>
                </tr>
                <tr>
                    <td>No. Hp</td>
                    <td>:</td>
                    <td>
                        {{ $dataRekeningNonAir->no_hp }}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td class="text-nowrap">Untuk Pembayaran</td>
                <td>:</td>
                <td>
                    {{ $dataRekeningNonAir->jenis }}
                </td>
            </tr>
            <tr>
                <td>Sebesar</td>
                <td>:</td>
                <td>
                    {{ number_format($dataRekeningNonAir->nilai, 2) }}
                </td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>:</td>
                <td>{{ ucwords(Terbilang::make($dataRekeningNonAir->nilai, ' rupiah')) }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>
                    {{ \Carbon\Carbon::parse($dataRekeningNonAir->created_at)->isoFormat('LL') }}
                </td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>:</td>
                <td>
                    {{ $dataRekeningNonAir->kasir }}
                </td>
            </tr>
        </table>
    </div>
    <div class="col-xs-8 p-l-40">
        <div class="row ml-5">
            <div class="col-xs-12">
                <img src="/assets/img/logo.png" class="width-20"><strong>PERUMDAM BATU LANTEH</strong>
                <table class="width-full f-s-12">
                    <tr>
                        <td colspan="4">STRUK PEMBAYARAN REKENING NON AIR</td>
                    </tr>
                    <tr>
                        <td class="width-150">No.</td>
                        <td class="width-10">:</td>
                        <td colspan="2">{{ $dataRekeningNonAir->nomor }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">Telah Terima Dari</td>
                    </tr>
                    @if ($dataRekeningNonAir->pelanggan_id)
                        <tr>
                            <td>No Pelanggan</td>
                            <td>:</td>
                            <td colspan="2">{{ $dataRekeningNonAir->pelanggan->no_langganan }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $dataRekeningNonAir->pelanggan->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $dataRekeningNonAir->pelanggan->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td>No. Hp</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $dataRekeningNonAir->pelanggan->no_hp }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $dataRekeningNonAir->nama }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $dataRekeningNonAir->alamat }}
                            </td>
                        </tr>
                        <tr>
                            <td>No. Hp</td>
                            <td>:</td>
                            <td colspan="2">
                                {{ $dataRekeningNonAir->no_hp }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $dataRekeningNonAir->jenis }}
                        </td>
                    </tr>
                    <tr>
                        <td>Sebesar</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ number_format($dataRekeningNonAir->nilai, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td colspan="2">{{ ucwords(Terbilang::make($dataRekeningNonAir->nilai, ' rupiah')) }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ \Carbon\Carbon::parse($dataRekeningNonAir->created_at)->isoFormat('LL') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td>:</td>
                        <td class="width-300">
                            {{ $dataRekeningNonAir->kasir }}
                        </td>
                        <td>
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
