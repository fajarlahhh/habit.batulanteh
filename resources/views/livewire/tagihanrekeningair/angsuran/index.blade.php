<div>
    @section('title', 'Angsuran Rekening Air')

    @section('page')
        <li class="breadcrumb-item">Tagihan Rekening Air</li>
        <li class="breadcrumb-item active">Angsuran</li>
    @endsection

    <h1 class="page-header">Angsuran Rekening Air</h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-3 col-sm-3">
                    @role('user|administrator|super-admin')
                        <div class="form-inline">
                            <a href="{{ route('tagihanrekeningair.angsuran.tambah') }}" class="btn btn-primary"><i
                                    class="fa fa-plus"></i> Tambah</a>
                        </div>
                    @endrole
                </div>
                <div class="col-xl-9 col-sm-9">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-live-search="true" data-style="btn-success"
                                data-width="100%" wire:model="lunas">
                                <option value="0">Belum Lunas</option>
                                <option value="1">Sudah Lunas</option>
                            </select>
                        </div>&nbsp;
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari"
                                aria-label="Sizing example input" autocomplete="off" aria-describedby="basic-addon2"
                                wire:model="cari">
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
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>No. Langganan</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Pemohon</th>
                        <th>Keterangan</th>
                        <th>Total</th>
                        <th>Terbayar</th>
                        <th>Operator</th>
                        @role('administrator|super-admin|user')
                            <th class="width-90"></th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td class="align-middle text-nowrap">{{ $row->nomor }}</td>
                            <td class="align-middle text-nowrap">{{ $row->created_at }}</td>
                            <td class="align-middle">{{ $row->pelanggan->no_langganan }}</td>
                            <td class="align-middle">{{ $row->pelanggan->nama }}</td>
                            <td class="align-middle">{{ $row->pelanggan->alamat }}</td>
                            <td class="align-middle">{{ $row->pemohon }}</td>
                            <td class="align-middle">{{ $row->keterangan }}</td>
                            <td class="align-middle text-right">{{ number_format($row->total) }}</td>
                            <td class="align-middle text-right">{{ number_format($row->bayar) }}</td>
                            <td class="align-middle"><small>{!! $row->pengguna->nama . '</br>' . $row->updated_at !!}</small></td>
                            @role('administrator|super-admin|user')
                                <td class="with-btn-group align-middle text-right" nowrap>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($key === $row->getKey())
                                            <a href="javascript:;" wire:click="hapus" class="btn btn-danger">Ya, Hapus</a>
                                            <a wire:click="setKey" href="javascript:;" class="btn btn-success">Batal</a>
                                        @else
                                            @if ($lunas == 0)
                                                <a href="javascript:;" wire:click="setKey({{ $row->getKey() }})"
                                                    class="btn btn-danger">Hapus</a>
                                            @endif
                                            <button class="btn dropdown-toggle" data-toggle="dropdown"><i
                                                    class="fas fa-angle-down"></i></button>
                                            <div class="dropdown-menu">
                                                <a href="javascript:;" class="dropdown-item"
                                                    wire:click="cetak({{ $row->getKey() }})"
                                                    class="dropdown-item btn-cetak"> Cetak</a>
                                            </div>
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
