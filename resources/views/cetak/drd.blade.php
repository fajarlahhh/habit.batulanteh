<table class="table">
    <thead>
        <tr>
            <th>NO</th>
            <th>NO. LANGGANAN</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>KLASIFIKASI</th>
            <th>PEMAKAIAN</th>
            <th>HARGA AIR</th>
            <th>BIAYA METER AIR</th>
            <th>TOTAL</th>
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
                <td class="text-right">
                    {{ $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu }}
                </td>
                <td class="text-right">{{ $row->harga_air }}</td>
                <td class="text-right">{{ $row->biaya_meter_air }}</td>
                <td class="text-right">{{ $row->materai }}</td>
                <td class="text-right">{{ $row->materai + $row->harga_air + $row->biaya_meter_air }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
