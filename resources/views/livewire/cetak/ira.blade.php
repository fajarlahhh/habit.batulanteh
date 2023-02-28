<div>
    <div>
        @section('title', 'Ikthisar Rekening Air (IRA)')

        @section('page')
            <li class="breadcrumb-item">Cetak</li>
            <li class="breadcrumb-item active">IRA</li>
        @endsection

        <h1 class="page-header">Ikthisar Rekening Air (IRA)</h1>

        <x-alert />

        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <!-- begin panel-heading -->
            <div class="panel-heading ">
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
                    <button class="btn btn-info" wire:click="cetak">Cetak</button>
                </div>
            </div>
            <div class="panel-body table-responsive">
                @include('cetak.ira')
            </div>
        </div>

        <x-modal />

        @push('scripts')
            @if (Session::has('cetak'))
                <script>
                    $('#modal-cetak').modal('show');
                </script>
            @endif
            <script>
                Livewire.on('reinitialize', id => {
                    $('.selectpicker').selectpicker();
                });

                Livewire.on('cetak', id => {
                    $('#modal-cetak').modal('show');
                });
            </script>
        @endpush
    </div>

</div>
