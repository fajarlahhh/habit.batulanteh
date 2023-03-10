<div class="text-center">
    <h5>Laporan Penerimaan Penagihan Non Air</h5>
</div>
<table class="table table-borderless">
    <tr>
        <th class="width-150">Periode</th>
        <th class="width-10">:</th>
        <td>{{ $tanggal1 . ' s/d ' . $tanggal2 }}</td>
    </tr>
    <tr>
        <th class="width-150">Kasir</th>
        <th class="width-10">:</th>
        <td>{{ $kasir ?: 'Semua Kasir' }}</td>
    </tr>
    <tr>
        <th class="width-150">Operator</th> 
        <th class="width-10">:</th> 
        <td>{{ auth()->user()->nama }}</td>
    </tr>
    <tr>
        <th class="width-150">Tgl Cetak</th> 
        <th class="width-10">:</th> 
        <td>{{ now() }}</td>
    </tr>
</table>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO</th>
            <th>TANGGAL BAYAR</th>
            <th>NO. LANGGANAN</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>NO. HP</th>
            <th>JENIS</th>
            <th>TAGIHAN</th>
            <th>KASIR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $row->created_at }}</td>
                <td class="text-nowrap">{{ $row->pelanggan_id ? $row->pelanggan->no_langganan : null }}</td>
                <td class="text-nowrap">{{ $row->nama }}</td>
                <td class="text-nowrap">{{ $row->alamat }}</td>
                <td class="text-nowrap">{{ $row->no_hp }}</td>
                <td class="text-nowrap">{{ $row->jenis }}</td>
                <td class="text-right">{{ $row->nilai }}</td>
                <td class="text-nowrap">{{ $row->kasir }}</td>
            </tr>
            @if ($total - $no == 0)
                <tr>
                    <td colspan="7">TOTAL</td>
                    <td class="text-right">
                        {{ $dataRaw->sum('nilai') }}
                    </td>
                    <td></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
