<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO</th>
            <th>NO. LANGGANAN</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>GOLONGAN</th>
            <th>PERIODE</th>
            <th>PEMAKAIAN</th>
            <th>HARGA AIR</th>
            <th>BIAYA METER AIR</th>
            <th>DENDA</th>
            <th>MATERAI</th>
            <th>TOTAL</th>
            <th>KASIR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->no_langganan }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->nama }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->alamat }}</td>
                <td class="text-nowrap">{{ $row->golongan->nama }} - {{ $row->golongan->deskripsi }}</td>
                <td class="text-right">{{ substr($row->periode, 0, 7) }}</td>
                <td class="text-right">
                    {{ $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu }}
                </td>
                <td class="text-right">{{ $row->harga_air }}</td>
                <td class="text-right">{{ $row->biaya_meter_air }}</td>
                <td class="text-right">{{ $row->biaya_denda }}</td>
                <td class="text-right">{{ $row->biaya_materai }}</td>
                <td class="text-right">
                    {{ $row->biaya_materai + $row->harga_air + $row->biaya_meter_air + $row->biaya_denda }}
                </td>
                <td class="text-right">{{ $row->kasir }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="6">TOTAL</th>
            <th class="text-right">
                {{ $data->sum(fn($q) => $q->stand_ini || $q->stand_lalu ? $q->stand_ini - $q->stand_pasang + $q->stand_angkat - $q->stand_lalu : $q->stand_ini - $q->stand_lalu) }}
            </th>
            <th class="text-right">{{ $data->sum('harga_air') }}</th>
            <th class="text-right">{{ $data->sum('biaya_meter_air') }}</th>
            <th class="text-right">{{ $data->sum('biaya_denda') }}</th>
            <th class="text-right">{{ $data->sum('biaya_materai') }}</th>
            <th class="text-right">
                {{ $data->sum(fn($q) => $q->materai + $q->harga_air + $q->biaya_meter_air + $q->biaya_denda) }}</th>
                <th></th>
        </tr>
    </tbody>
</table>
