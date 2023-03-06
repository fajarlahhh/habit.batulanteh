<div class="text-center">
    <h5>Daftar Pergantian Status Pelanggan</h5>
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
            <th>STATUS AWAL</th>
            <th>STATUS BARU</th>
            <th>OPERATOR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
            <tr>
                <td>{{ ++$key }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->no_langganan }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->nama }}</td>
                <td class="text-nowrap">{{ $row->pelanggan->alamat }}</td>
                <td>
                    @switch($row->status_lama)
                        @case(1)
                            Aktif
                        @break

                        @case(2)
                            Putus Sementara
                        @break

                        @case(3)
                            Segel
                        @break

                        @case(4)
                            Bongkar
                        @break

                        @default
                    @endswitch
                </td>
                <td>
                    @switch($row->status_baru)
                        @case(1)
                            Aktif
                        @break

                        @case(2)
                            Putus Sementara
                        @break

                        @case(3)
                            Segel
                        @break

                        @case(4)
                            Bongkar
                        @break

                        @default
                    @endswitch
                </td>
                <td>{!! $row->pengguna->nama . ', ' . $row->updated_at !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
