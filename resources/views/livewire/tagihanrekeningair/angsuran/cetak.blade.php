<div>
    <div class="f-s-14">
        <p class="text-center"><u>SURAT PERNYATAAN</u></p>
        <br>
        Yang bertanda tangan di bawah ini :
        <div class="m-l-40">
            <br>
            <table class="f-s-14">
                <tr>
                    <td class="width-150">No. Angsuran</td>
                    <td>: {{ $data->nomor }}</td>
                </tr>
                <tr>
                    <td>No. Langganan</td>
                    <td>: {{ $data->pelanggan->no_langganan }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $data->pelanggan->nama }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $data->pelanggan->alamat }}</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>: {{ $data->pelanggan->no_hp }}</td>
                </tr>
                <tr>
                    <td>Tagihan Periode</td>
                    <td>:
                        @foreach ($data->angsuranRekeningAirPeriode as $row)
                            {{ date('M Y', strtotime($row->rekeningAir->bacaMeter->periode)) }},
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
        <br>
        Bahwa saya adalah Pelanggan Perusahaan Air Minum Giri Menang, menyatakan diri sanggup melunasi angsuran Rekening
        Air sejumlah : <strong>Rp. {{ number_format($data->angsuranRekeningAirDetail->sum('nilai')) }}
            ({{ ucfirst(Terbilang::make($data->angsuranRekeningAirDetail->sum('nilai'))) }})</strong>
        <div class="m-l-40 m-r-40">
            <table class="table f-s-14 table-bordered">
                <tr>
                    <th>No.</th>
                    <th>Uraian</th>
                    <th>Nilai Angsuran</th>
                    <th>Pembayaran</th>
                </tr>
                @foreach ($data->angsuranRekeningAirDetail as $key => $row)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>Angsuran ke {{ $key + 1 }} :
                            {{ Carbon\Carbon::parse($data->created_at)->day(1)->addMonths($key)->format('M Y') }}</td>
                        <td>{{ number_format($row->nilai) }}</td>
                        <td>{{ $row->pengguna ? $row->pengguna->nama . ', ' . $row->waktu_bayar : '' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <p>
            Selanjutnya apabila kami tidak melunasi tepat pada waktu sebagaimana tersebut di atas, maka
            {{ config('constant.perusahaan') }}
            berhak menutup/memutuskan aliran air minum di alamat tersebut di atas dan kami tidak akan mengajukan
            tuntutan apapun kepada pihak {{ config('constant.perusahaan') }}.
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
                    <strong>{{ $data->pengguna->nama }}</strong>
                </td>
                <td class="text-center">
                    {{ date('d F Y', strtotime($data->created_at)) }}<br>
                    Yang membuat pernyataan
                    <br><br><br><br><br>
                    <strong>{{ $data->pemohon }}</strong>
                </td>
            </tr>
        </table>
    </div>
</div>
