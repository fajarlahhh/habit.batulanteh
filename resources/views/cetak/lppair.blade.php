<div class="text-center">
    <h5>Laporan Penerimaan Penagihan Air</h5>
</div>
<table class="table table-borderless">
    <tr>
        <th class="width-150">Unit Pelayanan</th>
        <th class="width-10">:</th>
        <td>{{ $unitPelayanan ? \App\Models\UnitPelayanan::findOrFail($unitPelayanan)->nama : 'Semua Unit Pelayanan' }}
        </td>
    </tr>
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
            <th>RAYON</th>
            <th>GOLONGAN</th>
            <th>PERIODE</th>
            <th>PEMAKAIAN</th>
            <th>HARGA AIR</th>
            <th>BIAYA METER AIR</th>
            <th>BIAYA ADMIN</th>
            <th>DENDA</th>
            <th>MATERAI</th>
            <th>TOTAL</th>
            <th>KASIR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->waktu_bayar }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->no_langganan }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->nama }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->alamat }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->rayon->nama }}</td>
                <td class="text-nowrap">{{ $row->golongan->nama }} - {{ $row->golongan->deskripsi }}</td>
                <td class="text-right">{{ substr($row->periode, 0, 7) }}</td>
                <td class="text-right">
                    {{ $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu }}
                </td>
                <td class="text-right">{{ $row->harga_air }}</td>
                <td class="text-right">{{ $row->biaya_meter_air }}</td>
                <td class="text-right">{{ $row->biaya_admin }}</td>
                <td class="text-right">{{ $row->biaya_denda }}</td>
                <td class="text-right">{{ $row->biaya_materai }}</td>
                <td class="text-right">
                    {{ $row->biaya_materai + $row->harga_air + $row->biaya_meter_air + $row->biaya_admin + $row->biaya_denda }}
                </td>
                <td>{{ $row->kasir }}</td>
            </tr>
            @if ($data->total() - $no == 0)
                <tr>
                    <td colspan="7">TOTAL</td>
                    <td class="text-right">
                        {{ $dataRaw->sum(fn($q) => $q->stand_ini || $q->stand_lalu ? $q->stand_ini - $q->stand_pasang + $q->stand_angkat - $q->stand_lalu : $q->stand_ini - $q->stand_lalu) }}
                    </td>
                    <td class="text-right">{{ $dataRaw->sum('harga_air') }}</td>
                    <td class="text-right">{{ $dataRaw->sum('biaya_meter_air') }}</td>
                    <td class="text-right">{{ $dataRaw->sum('biaya_admin') }}</td>
                    <td class="text-right">{{ $dataRaw->sum('biaya_denda') }}</td>
                    <td class="text-right">{{ $dataRaw->sum('biaya_materai') }}</td>
                    <td class="text-right">
                        {{ $dataRaw->sum(fn($q) => $q->biaya_materai + $q->harga_air + $q->biaya_meter_air + $q->biaya_admin + $q->biaya_denda) }}
                    </td>
                    <td></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
