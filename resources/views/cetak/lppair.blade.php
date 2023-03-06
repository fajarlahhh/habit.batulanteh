<div class="text-center">
    <h5>Laporan Penerimaan Penagihan Air</h5>
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
        <td>{{ $tanggal1 . ' s/d ' . $tanggal2 }}</td>
    </tr>
    <tr>
        <th class="width-150">Kasir</th> 
        <th class="width-10">:</th> 
        <td>{{ $kasir ? : 'Semua Kasir' }}</td>
    </tr>
</table>
<table class="table">
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
                <td>{{ ++$no }}</td>
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
                    {{ $row->biaya_materai + $row->harga_air + $row->biaya_meter_air + $row->biaya_admin + $row->biaya_denda }}
                </td>
                <td >{{ $row->kasir }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
