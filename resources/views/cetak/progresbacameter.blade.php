<div class="text-center">
    <h5>Progres Baca Meter</h5>
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
        <th class="width-150">Periode</th>
        <th class="width-10">:</th>
        <td>{{ date('F Y', strtotime($tahun . '-' . $bulan . '-01')) }}</td>
    </tr>
</table>
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">PEMBACA</th>
            <th colspan="{{ $tanggal }}">TANGGAL</th>
            <th rowspan="2">PROGRES</th>
            <th rowspan="2">%</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= $tanggal; $i++)
                <th>{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @php
            $realisasiKeseluruhan = [];
            $totalRealisasiBulanan = 0;
            $totalTargetBulanan = 0;
        @endphp
        @foreach ($data as $key => $row)
            @php
                $realisasiBulanan = $row->bacaMeter->whereNotNull('tanggal_baca')->count();
                $targetBulanan = $row->bacaMeter->count();
                $totalRealisasiBulanan += $realisasiBulanan;
                $totalTargetBulanan += $targetBulanan;
            @endphp
            <tr>
                <td class="text-nowrap">{{ $row->nama }}</td>
                @for ($i = 1; $i <= $tanggal; $i++)
                    @php
                        $realisasiHarian = $row->bacaMeter->where('tanggal_baca', $tahun . '-' . $bulan . '-' . substr('0' . $i, -2))->count();
                        $realisasiKeseluruhan[$key][$i - 1] = $realisasiHarian;
                    @endphp
                    <td class="text-right width-50">{{ $realisasiHarian }}</td>
                @endfor
                <td class="text-center text-nowrap">
                    {{ $realisasiBulanan . '/' . $targetBulanan }}</td>
                <td class="text-right text-nowrap">
                    {{ $targetBulanan > 0 ? ($realisasiBulanan / $targetBulanan) * 100 : 0 }}</td>
                @php
                @endphp
            </tr>
        @endforeach
        <tr>
            <th>
                TOTAL
            </th>
            @php
                $totalRealisasiHarian = 0;
            @endphp
            @for ($i = 0; $i < $tanggal; $i++)
                @php
                    $realisasiHarian = 0;
                @endphp
                @for ($j = 0; $j < $data->count(); $j++)
                    @php
                        $realisasiHarian += $realisasiKeseluruhan[$j][$i];
                    @endphp
                @endfor
                @php
                    $totalRealisasiHarian += $realisasiHarian;
                @endphp
                <th class="text-right">{{ $realisasiHarian }} </th>
            @endfor
            <td class="text-center text-nowrap">
                {{ $totalRealisasiHarian . '/' . $totalTargetBulanan }}</td>
            <td class="text-right text-nowrap">
                {{ $totalTargetBulanan > 0 ? ($totalRealisasiHarian / $totalTargetBulanan) * 100 : 0 }}</td>
        </tr>
    </tbody>
</table>
