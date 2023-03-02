<div class="text-center">
    <h5>Koreksi Rekening Air</h5>
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
            <th rowspan="2" width="30">NO.</th>
            <th width="70" rowspan="2">NO. LANGGANAN</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">ALAMAT</th>
            <th rowspan="2">UNIT PELAYANAN</th>
            <th rowspan="2">PERIODE</th>
            <th colspan="8">DATA AWAL</th>
            <th colspan="8">DATA AKHIR</th>
            <th rowspan="2">TGL.<br>KOREKSI</th>
            <th rowspan="2">OPERATOR</th>
            <th rowspan="2">CATATAN</th>
        </tr>
        <tr>
            <th>GOLONGAN</th>
            <th>HARGA AIR</th>
            <th>MATERAI</th>
            <th>STAND<br>LALU</th>
            <th>STAND<br>INI</th>
            <th>STAND<br>ANGKAT</th>
            <th>STAND<br>PASANG</th>
            <th>PAKAI<br>(m<sup>3</sup>)</th>
            <th>GOLONGAN</th>
            <th>HARGA AIR</th>
            <th>MATERAI</th>
            <th>STAND<br>LALU</th>
            <th>STAND<br>INI</th>
            <th>STAND<br>ANGKAT</th>
            <th>STAND<br>PASANG</th>
            <th>PAKAI<br>(m<sup>3</sup>)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->pelanggan->no_langganan }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->pelanggan->nama }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->pelanggan->alamat }}</td>
                <td class="text-nowrap">
                    {{ $row->rekeningAir->jalanKelurahan->kelurahan->kecamatan->unitPelayanan->nama }}</td>
                <td class="text-nowrap">{{ $row->rekeningAir->periode }}</td>
                <td class="text-nowrap">{{ $row->golonganLama->nama }}</td>
                <td class="text-right">{{ $row->harga_air_lama }}</td>
                <td class="text-right">{{ $row->biaya_materai_lama }}</td>
                <td class="text-right">{{ $row->stand_lalu_lama }}</td>
                <td class="text-right">{{ $row->stand_ini_lama }}</td>
                <td class="text-right">{{ $row->stand_angkat_lama }}</td>
                <td class="text-right">{{ $row->stand_pasang_lama }}</td>
                <td class="text-right">
                    {{ $row->stand_pasang_lama || $row->stand_angkat_lama ? $row->stand_ini_lama - $row->stand_pasang_lama + ($row->stand_angkat_lama - $row->stand_lalu_lama) : $row->stand_ini_lama - $row->stand_lalu_lama }}
                </td>
                <td class="text-nowrap">{{ $row->golonganBaru->nama }}</td>
                <td class="text-right">{{ $row->harga_air_baru }}</td>
                <td class="text-right">{{ $row->biaya_materai_baru }}</td>
                <td class="text-right">{{ $row->stand_lalu_baru }}</td>
                <td class="text-right">{{ $row->stand_ini_baru }}</td>
                <td class="text-right">{{ $row->stand_angkat_baru }}</td>
                <td class="text-right">{{ $row->stand_pasang_baru }}</td>
                <td class="text-right">
                    {{ $row->stand_pasang_baru || $row->stand_angkat_baru ? $row->stand_ini_baru - $row->stand_pasang_baru + ($row->stand_angkat_baru - $row->stand_lalu_baru) : $row->stand_ini_baru - $row->stand_lalu_baru }}
                </td>
                <td class="text-right text-nowrap">{{ $row->created_at }}</td>
                <td class="text-right">{{ $row->pengguna->nama }}</td>
                <td class="text-right">{{ $row->catatan }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="7">JUMLAH</th>
            <th class="text-right">{{ $data->sum('harga_air_lama') }}</th>
            <th class="text-right">{{ $data->sum('biaya_materai_lama') }}</th>
            <th class="text-right">{{ $data->sum('stand_lalu_lama') }}</th>
            <th class="text-right">{{ $data->sum('stand_ini_lama') }}</th>
            <th class="text-right">{{ $data->sum('stand_angkat_lama') }}</th>
            <th class="text-right">{{ $data->sum('stand_pasang_lama') }}</th>
            <th class="text-right">{{ $data->sum(fn($q) => $q->stand_pasang_lama || $q->stand_angkat_lama ? ($q->stand_ini_lama - $q->stand_pasang_lama) + ($q->stand_angkat_lama - $q->stand_lalu_lama) : $q->stand_ini_lama - $q->stand_lalu_lama) }}</th>
            <th>&nbsp;</th>
            <th class="text-right">{{ $data->sum('harga_air_baru') }}</th>
            <th class="text-right">{{ $data->sum('biaya_materai_baru') }}</th>
            <th class="text-right">{{ $data->sum('stand_lalu_baru') }}</th>
            <th class="text-right">{{ $data->sum('stand_ini_baru') }}</th>
            <th class="text-right">{{ $data->sum('stand_angkat_baru') }}</th>
            <th class="text-right">{{ $data->sum('stand_pasang_baru') }}</th>
            <th class="text-right">{{ $data->sum(fn($q) => $q->stand_pasang_baru || $q->stand_angkat_baru ? ($q->stand_ini_baru - $q->stand_pasang_baru) + ($q->stand_angkat_baru - $q->stand_lalu_baru) : $q->stand_ini_baru - $q->stand_lalu_baru) }}</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </tbody>
</table>
