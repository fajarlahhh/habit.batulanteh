<div class="text-center">
    <h5>Daftar Rekening Ditagih (DRD)</h5>
</div>
<table class="table table-borderless">
    <tr>
        <th class="width-150">Unit Pelayanan</th> 
        <th class="width-10">:</th> 
        <td>{{ $unitPelayanan ? \App\Models\UnitPelayanan::findOrFail($unitPelayanan)->nama : 'Semua Unit Pelayanan' }}</td>
    </tr>
    <tr>
        <th class="width-150">Rayon</th> 
        <th class="width-10">:</th> 
        <td>{{ $rayon ? \App\Models\Rayon::findOrFail($rayon)->nama : 'Semua Rayon' }}</td>
    </tr>
    <tr>
        <th class="width-150">Periode</th> 
        <th class="width-10">:</th> 
        <td>{{ date('F Y', strtotime($tahun . '-' . $bulan . '-01')) }}</td>
    </tr>
</table>
<table class="table table-bordered">
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
            <th>MATERAI</th>
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
