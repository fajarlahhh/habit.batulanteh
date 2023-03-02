<div class="text-center">
    <h5>LPP Non Air</h5>
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
                <td class="text-right">{{ $row->nilai }}</td>
                <td class="text-nowrap">{{ $row->kasir }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5">TOTAL</th>
            <th class="text-right">{{ $data->sum('nilai') }}</th>
            <th></th>
        </tr>
    </tbody>
</table>
