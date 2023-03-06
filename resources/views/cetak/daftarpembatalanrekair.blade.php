<div class="text-center">
    <h5>Daftar Pembatalan Rek. Air</h5>
</div>
<table class="table table-borderless">
    <tr>
        <th class="width-150">Tanggal</th>
        <th class="width-10">:</th>
        <td>{{ $tanggal }}</td>
    </tr>
</table>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO</th>
            <th>NO. LANGGANAN</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>GOLONGAN</th>
            <th>PEMAKAIAN</th>
            <th>HARGA AIR</th>
            <th>BIAYA METER AIR</th>
            <th>MATERAI</th>
            <th>TOTAL</th>
            <th>OPERATOR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->pelanggan->no_langganan }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->pelanggan->nama }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->pelanggan->alamat }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->golongan->nama }} - {{ $row->rekeningAir->golongan->deskripsi }}</td>
                <td class="text-right">
                    {{ $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu }}
                </td>
                <td class="text-right">{{ $row->rekeningAir->harga_air }}</td>
                <td class="text-right">{{ $row->rekeningAir->biaya_meter_air+ $row->rekeningAir->biaya_admin  }}</td>
                <td class="text-right">{{ $row->rekeningAir->materai }}</td>
                <td class="text-right">{{ $row->rekeningAir->materai + $row->rekeningAir->harga_air + $row->rekeningAir->biaya_meter_air + $row->rekeningAir->biaya_admin }}
                </td>
                <td>{!! $row->pengguna->nama . ', ' . $row->updated_at !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
