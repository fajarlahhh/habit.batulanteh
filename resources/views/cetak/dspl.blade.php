<div class="text-center">
    <h5>Daftar Saldo Piutang Langganan (DSPL)</h5>
</div>
<table class="table table-borderless">
    <tr>
        <th class="width-150">Unit Pelayanan</th>
        <th class="width-10">:</th>
        <td>{{ $unitPelayanan ? \App\Models\UnitPelayanan::findOrFail($unitPelayanan)->nama : 'Semua Unit Pelayanan' }}
        </td>
    </tr>
    <tr>
        <th class="width-150">Rayon</th>
        <th class="width-10">:</th>
        <td>{{ $rayon ? \App\Models\Rayon::findOrFail($rayon)->nama : 'Semua Rayon' }}</td>
    </tr>
    <tr>
        <th class="width-150">Status Pelanggan</th>
        <th class="width-10">:</th>
        <td>{{ $status ? ($status == 1 ? 'Aktif' : ($status == 2 ? 'Putus Sementara' : ($status == 3 ? 'Segel' : 'Bongkar'))) : 'Semua Status Pelanggan' }}
        </td>
    </tr>
    <tr>
        <th class="width-150">Golongan</th>
        <th class="width-10">:</th>
        <td>{{ $golongan ? \App\Models\Golongan::findOrFail($golongan)->nama : 'Semua Golongan' }}</td>
    </tr>
    <tr>
        <th class="width-150">Periode</th>
        <th class="width-10">:</th>
        <td>{{ date('F Y', strtotime($tahun . '-' . $bulan . '-01')) }}</td>
    </tr>
</table>
<table class="table">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NO. LANGGANAN</th>
            <th rowspan="2">NAMA</th>
            <th rowspan="2">ALAMAT</th>
            <th colspan="2">TOTAL</th>
            <th colspan="4">DETAIL TAGIHAN</th>
        </tr>
        <tr>
            <th>LEMBAR</th>
            <th>TAGIHAN</th>
            <th>PERIODE</th>
            <th>GOLONGAN</th>
            <th>PAKAI</th>
            <th>TAGIHAN</th>
        </tr>
    </thead>
    <tbody>
        @php
            $lembar = 0;
            $tagihan = 0;
            $pelanggan = '';
            $no = 1;
        @endphp
        @foreach ($data as $key => $row)
            @php
                if ($pelanggan != $row->pelanggan_id) {
                    $lembar += $data->where('pelanggan_id', $row->pelanggan_id)->count();
                    $tagihan += $data->where('pelanggan_id', $row->pelanggan_id)->sum(fn($q) => $q->materai + $q->harga_air + $q->biaya_meter_air  + $q->biaya_admin+ $q->biaya_denda);
                }
            @endphp
            <tr>
                <td>{{ $pelanggan != $row->pelanggan_id ? $no++ : null }}</td>
                <td class="text-nowrap">
                    {{ $pelanggan != $row->pelanggan_id ? $row->pelanggan->no_langganan : null }}</td>
                <td class="text-nowrap">
                    {{ $pelanggan != $row->pelanggan_id ? $row->pelanggan->nama : null }}</td>
                <td class="text-nowrap">
                    {{ $pelanggan != $row->pelanggan_id ? $row->pelanggan->alamat : null }}</td>
                <td class="text-right" class="text-nowrap">
                    {{ $pelanggan != $row->pelanggan_id ? $data->where('pelanggan_id', $row->pelanggan_id)->count() : null }}
                </td>
                <td class="text-right" class="text-nowrap">
                    {{ $pelanggan != $row->pelanggan_id ? $data->where('pelanggan_id', $row->pelanggan_id)->sum(fn($q) => $q->materai + $q->harga_air + $q->biaya_meter_air + $q->biaya_admin+ $q->biaya_denda) : null }}
                </td>
                <td class="text-nowrap">{{ $row->periode_rekening }}</td>
                <td class="text-nowrap">{{ $row->golongan->nama }}</td>
                <td class="text-right">
                    {{ $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu }}
                </td>
                <td class="text-right">
                    {{ $row->materai + $row->harga_air + $row->biaya_meter_air + $row->biaya_admin + $row->biaya_denda }}
                </td>
            </tr>
            @php
                $pelanggan = $row->pelanggan_id;
            @endphp
        @endforeach
        <tr>
            <th colspan="4">TOTAL</th>
            <th class="text-right">{{ $lembar }}</th>
            <th class="text-right">{{ $tagihan }}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tbody>
</table>
