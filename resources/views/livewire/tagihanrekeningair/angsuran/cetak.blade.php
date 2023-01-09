<div>
    @section('content')
        <div class="f-s-14">
            <p class="text-center"><u>SURAT PERNYATAAN</u></p>
            <br>
            Yang bertanda tangan di bawah ini :
            <div class="m-l-40">
                <br>
                <table class="f-s-14">
                    <tr>
                        <td class="width-150">No. Angsuran</td>
                        <td>: {{ $data->first()->nomor }}</td>
                    </tr>
                    <tr>
                        <td>No. Langganan</td>
                        <td>: {{ $data->first()->pelanggan->no_langganan }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $data->first()->pelanggan->nama }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $data->first()->pelanggan->alamat }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $data->first()->pelanggan->telepon }}</td>
                    </tr>
                    <tr>
                        <td>Tagihan</td>
                        <td>:
                            @foreach ($data->first()->detail as $row)
                                {{ date('M Y', strtotime($row->periode)) }},
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            Bahwa saya adalah Pelanggan Perusahaan Air Minum Giri Menang, menyatakan diri sanggup melunasi angsuran Rekening
            Air sejumlah : <strong>Rp. {{ number_format($data->sum('nilai')) }}
                ({{ ucfirst(Terbilang::make($data->sum('nilai'))) }})</strong>
            <div class="m-l-40 m-r-40">
                <table class="table f-s-14 table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Uraian</th>
                        <th>Nilai Angsuran</th>
                        <th>Keterangan</th>
                    </tr>
                    @foreach ($data as $key => $row)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>Angsuran ke {{ $key + 1 }} :
                                {{ Carbon\Carbon::parse($row->tanggal)->day(1)->addMonths($key)->format('M Y') }}</td>
                            <td>{{ number_format($row->nilai) }}</td>
                            <td>{{ $row->kasir . ', ' . $row->waktu_bayar }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <p>
                Selanjutnya apabila kami tidak melunasi tepat pada waktu sebagaimana tersebut di atas, maka PTAM Giri Menang
                berhak menutup/memutuskan aliran air minum di alamat tersebut di atas dan kami tidak akan mengajukan
                tuntutan apapun kepada pihak {{ config('constants.perusahaan') }}.
            </p>
            <br>
            <p>
                <strong>NB:</strong> <br>
                Setiap membayar angsuran ditambah dengan rekening berjalan
            </p>
            <table class="table f-s-14 table-borderless">
                <tr>
                    <td class="text-center">
                        Mengetahui<br>
                        Customer Service
                        <br><br><br><br><br>
                        <strong>{{ $data->first()->operator }}</strong>
                    </td>
                    <td class="text-center">
                        {{ date('d F Y', strtotime($data->first()->tanggal)) }}<br>
                        Yang membuat pernyataan
                        <br><br><br><br><br>
                        <strong>{{ $data->first()->pemohon }}</strong>
                    </td>
                </tr>
            </table>
        </div>
    @endsection
</div>
