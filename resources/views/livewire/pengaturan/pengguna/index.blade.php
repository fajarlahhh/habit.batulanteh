<div>
    @section('title', 'Pengguna')

    @section('page')
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active">Pengguna</li>
    @endsection

    <h1 class="page-header">Pengguna</h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-3 col-sm-3">
                    @role('administrator|super-admin')
                        <div class="form-inline">
                            <a href="{{ route('pengaturan.pengguna.tambah') }}" class="btn btn-primary"><i
                                    class="fa fa-plus"></i>
                                Tambah</a>
                        </div>
                    @endrole
                </div>
                <div class="col-xl-9 col-sm-9">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-width="100%" wire:model="exist">
                                <option value="1">Exist</option>
                                <option value="2">Deleted</option>
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
                        <th class="width-10">No.</th>
                        <th>UID</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Level</th>
                        <th>Penagih</th>
                        <th>Baca Meter</th>
                        <th>API Token</th>
                        @role('administrator|super-admin')
                            <th class="width-90"></th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        <tr>
                            <td class="align-middle">{{ ++$no }}</td>
                            <td class="align-middle">{{ $row->uid }}</td>
                            <td class="align-middle">{{ $row->nama }}</td>
                            <td class="align-middle">{{ $row->deskripsi }}</td>
                            <td class="align-middle">{{ $row->getRoleNames() ? $row->getRoleNames()->first() : null }}
                            </td>
                            <td class="align-middle">
                                @switch($row->penagih)
                                    @case(1)
                                        Penagih
                                    @break

                                    @case(2)
                                        PPOB
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td class="align-middle">{{ $row->bacameter == 1 ? 'YA' : '' }}</td>
                            <td class="align-middle">{{ $row->api_token }}</td>
                            <td class="with-btn-group align-middle text-right" nowrap>
                                @role('administrator|super-admin')
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($row->trashed())
                                            @if ($key == $row->getKey())
                                                <button wire:click="restore" class="btn btn-success">Ya, Restore</button>
                                                <button wire:click="setKey" class="btn btn-danger">Batal</button>
                                            @else
                                                <button wire:click="setKey({{ $row->getKey() }})"
                                                    class="btn btn-grey">Restore</button>
                                            @endif
                                        @else
                                            @if ($key == $row->getKey())
                                                <button wire:click="hapus" class="btn btn-warning">Ya, Hapus</button>
                                                <button wire:click="setKey" class="btn btn-success">Batal</button>
                                            @else
                                                <a href="{{ route('pengaturan.pengguna.edit', ['key' => $row->getKey()]) }}"
                                                    class="btn btn-info"><i class="fas fa-sm fa-pencil-alt"></i></a>
                                                @if ($row->getKey() != 1 || $row->uid != 'admin')
                                                    <a href="javascript:;" wire:click="setKey({{ $row->getKey() }})"
                                                        class="btn btn-danger"><i class="fas fa-sm fa-trash-alt"></i></a>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                @endrole
                            </td>
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
            Livewire.on('reinitialize', id => {
                $('.selectpicker').selectpicker()
            });
        </script>
    @endpush
</div>
