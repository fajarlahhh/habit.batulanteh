<div class="text-center">
    <h5>Ikthisar Rekening Air (IRA)</h5>
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
            <th rowspan="2">NO</th>
            <th rowspan="2">GOLONGAN</th>
            <th rowspan="2">JML<br>PELANGGAN</th>
            <th rowspan="2">PELANGGAN<br>AKTIF</th>
            <th rowspan="2">PELANGGAN<br>PASIF</th>
            <th colspan="2">PEMBEBANAN</th>
            <th colspan="2">PEMBEBANAN UNSUR LAINNYA</th>
            <th rowspan="2">RATA-RATA<br>TAGIHAN AIR</th>
            <th rowspan="2">RATA-RATA<br>PAKAI</th>
        </tr>
        <tr>
            <th>PAKAI (m<sup>3</sup>)</th>
            <th>HARGA AIR</th>
            <th>ADMINISTRASI</th>
            <th>MATERAI</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sumHargaAir = 0;
            $sumPakai = 0;
        @endphp
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="text-nowrap">{{ $row->nama_golongan . ' - ' . $row->deskripsi_golongan }}</td>
                <td class="text-right">{{ number_format($row->jumlah_pelanggan) }}</td>
                <td class="text-right">{{ number_format($row->pelanggan_aktif) }}</td>
                <td class="text-right">{{ number_format($row->pelanggan_pasif) }}</td>
                <td class="text-right">{{ number_format($row->pakai) }}</td>
                <td class="text-right">{{ number_format($row->harga_air) }}</td>
                <td class="text-right">{{ number_format($row->administrasi) }}</td>
                <td class="text-right">{{ number_format($row->materai) }}</td>
                <td class="text-right">{{ number_format($row->pakai ? $row->harga_air / $row->pakai : 0, 2) }}</td>
                <td class="text-right">{{ number_format($row->pakai ? $row->pakai / $row->pelanggan_aktif : 0, 2) }}</td>
                @php
                    $sumHargaAir += $row->pakai > 0 ? $row->harga_air / $row->pakai : 0;
                    $sumPakai += $row->pelanggan_aktif > 0 ? $row->pakai / $row->pelanggan_aktif : 0;
                @endphp
            </tr>
        @endforeach
        <tr>
            <th colspan="2">JUMLAH</th>
            <th class="text-right">{{ number_format($data->sum('jumlah_pelanggan')) }}</th>
            <th class="text-right">{{ number_format($data->sum('pelanggan_aktif')) }}</th>
            <th class="text-right">{{ number_format($data->sum('pelanggan_pasif')) }}</th>
            <th class="text-right">{{ number_format($data->sum('pakai')) }}</th>
            <th class="text-right">{{ number_format($data->sum('harga_air')) }}</th>
            <th class="text-right">{{ number_format($data->sum('administrasi')) }}</th>
            <th class="text-right">{{ number_format($data->sum('materai')) }}</th>
            <th class="text-right">{{ number_format($sumHargaAir, 2) }}</th>
            <th class="text-right">{{ number_format($sumPakai, 2) }}</th>
        </tr>
    </tbody>
</table>
