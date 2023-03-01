<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO</th>
            <th>NO. LANGGANAN</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>NO. HP</th>
            <th>TAGIHAN</th>
            <th>KASIR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="text-nowrap">{{ $row->pelanggan_id ? $row->pelanggan->no_langganan : null }}</td>
                <td class="text-nowrap">{{ $row->nama }}</td>
                <td class="text-nowrap">{{ $row->alamat }}</td>
                <td class="text-nowrap">{{ $row->no_hp }}</td>
                <td class="text-nowrap">{{ $row->nilai }}</td>
                <td class="text-right">{{ $row->kasir }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5">TOTAL</th>
            <th class="text-right">{{ $data->sum('nilai') }}</th>
            <th></th>
        </tr>
    </tbody>
</table>
