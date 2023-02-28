<div>
    <div>
        @section('title', 'Daftar Rekening Ditagih (DRD)')

        @section('page')
            <li class="breadcrumb-item">Cetak</li>
            <li class="breadcrumb-item active">DRD</li>
        @endsection

        <h1 class="page-header">Daftar Rekening Ditagih (DRD)</h1>

        <x-alert />

        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <!-- begin panel-heading -->
            <div class="panel-heading">
                <div class="form-inline width-full">
                    <div class="form-group">
                        <select class="form-control selectpicker" data-live-search="true" data-width="100%"
                            wire:model="unitPelayanan">
                            <option value="">SEMUA UNIT PELAYANAN</option>
                            @foreach ($dataUnitPelayanan as $row)
                                <option value="{{ $row->getKey() }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>&nbsp;
                    <div class="form-group">
                        <select class="form-control selectpicker" data-live-search="true" data-width="100%"
                            wire:model="rayon">
                            <option value="">SEMUA RAYON</option>
                            @if ($unitPelayanan)
                                @foreach (\App\Models\Rayon::whereHas(
        'rayonDetail',
        fn($q) => $q->whereIn(
            'jalan_kelurahan_id',
            \App\Models\Regional::where('unit_pelayanan_id', $unitPelayanan)->get()->pluck('id'),
        ),
    )->get() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>&nbsp;
                    <div class="form-group">
                        <select class="form-control selectpicker" wire:model="bulan" data-live-search="true"
                            data-width="100%">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ sprintf('%02s', $i) }}">
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>&nbsp;
                    <div class="form-group">
                        <select class="form-control selectpicker" wire:model="tahun" data-live-search="true"
                            data-width="100%">
                            @for ($i = 2021; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>&nbsp;
                    <button class="btn btn-info" wire:click="cetak">Export</button>
                </div>
            </div>
            <div class="panel-body table-responsive">
                @include('cetak.drd')
            </div>
            <div class="panel-footer form-inline">
                <div class="col-md-6 col-lg-10 col-xl-10 col-xs-12">
                    {{ $data->links() }}
                </div>
                <div class="col-md-6 col-lg-2 col-xl-2 col-xs-12">
                    <label class="pull-right">Jumlah Data : {{ $data->total() }}</label>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <table class="table table-borderless">
                <tr>
                    <th class="width-200">Total Pemakaian</th>
                    <th class="width-10">:</th>
                    <td>{{ number_format($data->sum(fn($q) => $q->stand_ini || $q->stand_lalu ? $q->stand_ini - $q->stand_pasang + $q->stand_angkat - $q->stand_lalu : $q->stand_ini - $q->stand_lalu)) }} m³
                    </td>
                </tr>
                <tr>
                    <th>Total Harga Air</th>
                    <th>:</th>
                    <td>Rp. {{ number_format($data->sum('harga_air')) }}</td>
                </tr>
                <tr>
                    <th>Total Biaya Meter Air</th>
                    <th>:</th>
                    <td>Rp. {{ number_format($data->sum('biaya_meter_air')) }}</td>
                </tr>
                <tr>
                    <th>Total Tagihan</th>
                    <th>:</th>
                    <td>Rp. {{ number_format($data->sum(fn($q) => $q->harga_air + $q->biaya_materai + $q->biaya_meter_air)) }}</td>
                </tr>
            </table>
        </div>

        @push('scripts')
            <script>
                Livewire.on('reinitialize', id => {
                    $('.selectpicker').selectpicker();
                });
            </script>
        @endpush
    </div>

</div>
