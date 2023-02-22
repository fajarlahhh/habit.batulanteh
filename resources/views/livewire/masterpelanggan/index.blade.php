<div>
    @section('title', 'Master Pelanggan')

    @section('page')
        <li class="breadcrumb-item active">Master Pelanggan</li>
    @endsection

    <h1 class="page-header">Master Pelanggan</h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-1 col-sm-1">
                    @role('administrator|super-admin')
                        <div class="form-inline">
                            <a class="btn btn-primary" href="{{ route('masterpelanggan.tambah') }}">Tambah</a>
                        </div>
                    @endrole
                </div>
                <div class="col-xl-11 col-sm-11">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-width="100%" wire:model="status">
                                <option value="0">Semua</option>
                                <option value="1">Aktif</option>
                                <option value="2">Putus Sementara</option>
                                <option value="3">Putus Sementara Permintaan Pelanggan</option>
                                <option value="4">Putus Rampung</option>
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
                        <th>Golongan</th>
                        <th>Diameter</th>
                        <th>Merk WM</th>
                        <th>Tgl. Pasang</th>
                        <th>No. Body WM</th>
                        <th>Operator</th>
                        @role('administrator|super-admin')
                            <th class="width-90"></th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $row)
                        <tr>
                            <td class="align-middle">{{ ++$i }}</td>
                            <td class="align-middle">{{ $row->no_langganan }}</td>
                            <td class="align-middle">{{ $row->nama }}</td>
                            <td class="align-middle">{{ $row->alamat }}</td>
                            <td class="align-middle">{{ $row->jalan ? $row->jalan->nama : null }}</td>
                            <td class="align-middle">{{ $row->golongan->nama }}</td>
                            <td class="align-middle">{{ $row->diameter->ukuran }}</td>
                            <td class="align-middle">{{ $row->merkWaterMeter ? $row->merkWaterMeter->merk : null }}</td>
                            <td class="align-middle">{{ $row->tanggal_pasang }}</td>
                            <td class="align-middle">{{ $row->no_body_water_meter }}</td>
                            <td class="align-middle"><small>{!! $row->pengguna ? $row->pengguna->nama : null !!}</small></td>
                            @role('administrator|super-admin')
                                <td class="with-btn-group align-middle text-right" nowrap>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($key === $row->getKey())
                                            <button wire:click="hapus" class="btn btn-warning">Ya, Hapus</button>
                                            <button wire:click="setKey" class="btn btn-success">Batal</button>
                                        @else
                                            <a href="{{ route('masterpelanggan.edit', ['key' => $row->getKey()]) }}"
                                                class="btn btn-info"><i class="fas fa-sm fa-pencil-alt"></i></a>
                                            <button wire:click="setKey({{ $row->getKey() }})" class="btn btn-danger"><i
                                                    class="fas fa-sm fa-trash-alt"></i></button>
                                        @endif
                                    </div>
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
