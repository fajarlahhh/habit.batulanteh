<div>
    @section('title', 'Data Target Baca Meter')

    @section('page')
        <li class="breadcrumb-item">Baca Meter</li>
        <li class="breadcrumb-item active">Data Target</li>
    @endsection

    <h1 class="page-header">Data Target <small>Baca Meter</small></h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-1 col-sm-1">
                    @role('administrator|super-admin')
                        <div class="form-inline">
                            <a class="btn btn-primary" href="{{ route('bacameter.buattarget') }}">Buat Data </a>
                        </div>
                    @endrole
                </div>
                <div class="col-xl-11 col-sm-11">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <select class="form-control selectpicker" wire:model="bulan" data-live-search="true"
                                data-style="btn-info" data-width="100%">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ sprintf('%02s', $i) }}">
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>&nbsp;
                        <div class="form-group">
                            <select class="form-control selectpicker" wire:model="tahun" data-live-search="true"
                                data-style="btn-info" data-width="100%">
                                @for ($i = 2016; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>&nbsp;
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari"
                                aria-label="Sizing example input" autocomplete="off" aria-describedby="basic-addon2"
                                wire:model.lazy="cari">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="width-60">No.</th>
                        <th>No. Langganan</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jalan</th>
                        <th>Pembaca</th>
                        <th>No. Body WM</th>
                        <th>Tanggal Baca</th>
                        <th>Stand Lalu</th>
                        <th>Stand Ini</th>
                        <th>Pakai</th>
                        <th>Status Baca</th>
                        <th>Foto</th>
                        @role('administrator|super-admin')
                            <th class="width-90"></th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $row)
                        <tr>
                            <td class="align-middle">{{ ++$i }}</td>
                            <td class="align-middle">{{ $row->pelanggan->no_langganan }}</td>
                            <td class="align-middle">{{ $row->pelanggan->nama }}</td>
                            <td class="align-middle">{{ $row->pelanggan->alamat }}</td>
                            <td class="align-middle">{{ $row->pelanggan->jalan->nama }}</td>
                            <td class="align-middle">{{ $row->pelanggan->pembaca->nama }}</td>
                            <td class="align-middle">{{ $row->pelanggan->no_body_water_meter }}</td>
                            <td class="align-middle">{{ $row->tanggal_baca }}</td>
                            <td class="align-middle">{{ $row->stand_lalu }}</td>
                            <td class="align-middle">{{ $row->stand_ini }}</td>
                            <td class="align-middle">{{ $row->stand_ini - $row->stand_lalu }}</td>
                            <td class="align-middle">{{ $row->status_baca }}</td>
                            <td class="align-middle">
                                @if ($row->foto)
                                    <img src="{{ Storage::url($row->foto) }}" class='height-70' />
                                @endif
                            </td>
                            @role('administrator|super-admin|user')
                                <td class="with-btn-group align-middle text-right" nowrap>
                                    @if (!$row->rekeningAir)
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('bacameter.datatarget.edit', ['key' => $row->getKey()]) }}"
                                                class="btn btn-info"><i class="fas fa-sm fa-pencil-alt"></i></a>
                                        </div>
                                    @endif
                                </td>
                            @endrole
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

    @push('scripts')
        <script>
            Livewire.on('reinitialize', () => {
                $('.selectpicker').selectpicker()
            });
        </script>
    @endpush
</div>
