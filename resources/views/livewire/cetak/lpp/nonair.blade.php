<div>
    <div>
        @section('title', 'Laporan Penerimaan Penagihan Non Air (LPP Non Air)')

        @section('page')
            <li class="breadcrumb-item">Cetak</li>
            <li class="breadcrumb-item">LPP</li>
            <li class="breadcrumb-item active">Non Air</li>
        @endsection

        <h1 class="page-header">Laporan Penerimaan Penagihan Non Air (LPP Non Air)</h1>

        <x-alert />

        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <!-- begin panel-heading -->
            <div class="panel-heading" wire:loading.remove>
                <div class="form-inline width-full">
                    <div class="form-group">
                        <input class="form-control" type="date" autocomplete="off" wire:model="tanggal1" />
                    </div>&nbsp;
                    <div class="form-group">
                        <label> s/d</label>&nbsp;
                        <input class="form-control" type="date" autocomplete="off" wire:model="tanggal2" />
                    </div>&nbsp;
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
                                @foreach (\App\Models\Rayon::whereIn('id', \App\Models\Regional::where('unit_pelayanan_id', $unitPelayanan)->get()->pluck('id'))->get() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>&nbsp;
                    <div class="form-group">
                        <select class="form-control selectpicker" data-live-search="true" data-width="100%"
                            wire:model="unitPelayanan">
                            <option value="">SEMUA KASIR</option>
                            @foreach ($dataKasir as $row)
                                <option value="{{ $row->nama }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>&nbsp;
                    <button class="btn btn-info" wire:click="cetak">Cetak</button>
                </div>
            </div>
            <div class="panel-body table-responsive">
                @include('cetak.lppnonair')
            </div>
        </div>

        <x-modal />

        <div wire:loading>
            <x-loading />
        </div>

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
