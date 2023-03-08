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
                <div class="col-xl-2 col-sm-2">
                    @role('administrator|super-admin')
                        <div class="form-inline">
                            <a class="btn btn-primary" href="{{ route('bacameter.buattarget') }}">Buat Data </a>
                        </div>
                    @endrole
                </div>
                <div class="col-xl-10 col-sm-10">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <select class="form-control selectpicker" wire:model="statusBaca" data-style="btn-info"
                                data-width="100%">
                                <option value="0">BELUM BACA</option>
                                <option value="1">SUDAH BACA</option>
                            </select>
                        </div>&nbsp;
                        <div class="form-group">
                            <select class="form-control selectpicker" wire:model="bulan" data-live-search="true"
                                data-style="btn-info" data-width="100%">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02s', $m) }}">
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>&nbsp;
                        <div class="form-group">
                            <select class="form-control selectpicker" wire:model="tahun" data-live-search="true"
                                data-style="btn-info" data-width="100%">
                                @for ($y = 2016; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
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
                        <th>Rayon</th>
                        <th>Pembaca</th>
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
                    @foreach ($data as $index => $row)
                        <tr>
                            <td class="align-middle">{{ ++$i }}</td>
                            <td class="align-middle">{{ $row->pelanggan->no_langganan }}</td>
                            <td class="align-middle">{{ $row->pelanggan->nama }}</td>
                            <td class="align-middle">{{ $row->pelanggan->alamat }}</td>
                            <td class="align-middle">{{ $row->rayon->nama }}</td>
                            <td class="align-middle">{{ $row->pembaca->nama }}</td>
                            <td class="align-middle">{{ $row->tanggal_baca }}</td>
                            <td class="align-middle">{{ $row->stand_lalu }}</td>
                            <td class="align-middle">{{ $row->stand_ini }}</td>
                            <td class="align-middle">
                                {{ $row->stand_ini || $row->stand_lalu ? $row->stand_ini - $row->stand_pasang + $row->stand_angkat - $row->stand_lalu : $row->stand_ini - $row->stand_lalu }}
                            </td>
                            <td class="align-middle">{{ $row->status_baca }}</td>
                            <td class="align-middle">
                                @if ($row->foto)
                                    <img src="{{ Storage::url($row->foto) }}" class='height-70' />
                                @endif
                            </td>
                            @role('administrator|super-admin|operator')
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

    <div id="sidebar-right" class="sidebar sidebar-right">
        <!-- begin sidebar scrollbar -->
        <div data-scrollbar="true" data-height="100%">
            <!-- begin sidebar user -->
            <ul class="nav m-t-10">
                <li class="nav-widget text-white">
                    @if ($statusBaca == 1)
                        <div class="form-group">
                            <label class="control-label">Tanggal Baca</label>
                            <div class="input-group">
                                <input type="date" class="form-control form-control"
                                    min="{{ $tahun . '-' . $bulan . '-01' }}"
                                    max="{{ date('Y-m-t', strtotime($tahun . '-' . $bulan . '-01')) }}"
                                    wire:model.lazy="tanggalBaca" />
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label">Unit Pelayanan</label>
                        <select class="form-control selectpicker" wire:model="unitPelayanan"
                            data-container="#sidebar-right" data-live-search="true" data-size="10" data-width="100%">
                            <option value="">SEMUA UNIT PELAYANAN</option>
                            @foreach ($dataUnitPelayanan as $row)
                                <option value="{{ $row->getKey() }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Rayon</label>
                        <select class="form-control selectpicker" wire:model="rayon" data-container="#sidebar-right"
                            data-live-search="true" data-size="10" data-width="100%">
                            <option value="">SEMUA RAYON</option>
                            @if ($unitPelayanan)
                                @foreach (\App\Models\Rayon::whereIn(
        'id',
        \App\Models\Regional::where('unit_pelayanan_id', $unitPelayanan)->get()->pluck('id'),
    )->get() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->kode }} - {{ $row->nama }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Pembaca</label>
                        <select class="form-control selectpicker" wire:model="pembaca"
                            data-container="#sidebar-right" data-live-search="true" data-size="10"
                            data-width="100%">
                            <option value="">SEMUA PEMBACA</option>
                            @foreach (\App\Models\Pengguna::where('bacameter', 1)->get() as $row)
                                <option value="{{ $row->getKey() }}">{{ $row->nama }}
                                    ({{ $row->unit_pelayanan_id ? $row->unitPelayanan->nama : null }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($statusBaca == 1)
                        <div class="form-group">
                            <label class="control-label">Status Baca</label>
                            <select class="form-control selectpicker" wire:model="statusBaca"
                                data-container="#sidebar-right" data-live-search="true" data-size="10"
                                data-width="100%">
                                <option value="">SEMUA STATUS BACA</option>
                                @if ($unitPelayanan)
                                    @foreach (\App\Models\StatusBaca::withTrashed()->all() as $row)
                                        <option value="{{ $row->getKey() }}">{{ $row->nama }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Pemakaian</label>
                            <select class="form-control selectpicker" wire:model="pemakaian"
                                data-container="#sidebar-right" data-live-search="true" data-size="10"
                                data-width="100%">
                                <option value="">SEMUA PEMAKAIAN</option>
                                <option value="1">
                                    < 0</option>
                                <option value="2">>= 0</option>
                            </select>
                        </div>
                    @endif
                </li>
            </ul>
            <!-- end sidebar user -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg sidebar-right"></div>

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        <script>
            Livewire.on('reinitialize', () => {
                $('.selectpicker').selectpicker()
            });
        </script>
    @endpush
</div>
