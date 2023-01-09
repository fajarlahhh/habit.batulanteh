<div>
    @section('title', 'Merk Water Meter')

    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item active">Merk Water Meter</li>
    @endsection

    <h1 class="page-header">Merk Water Meter</h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-1 col-sm-1">
                    @role('super-admin|supervisor')
                        <div class="form-inline">
                            <a class="btn btn-primary" href="{{ route('datamaster.merkwatermeter.tambah') }}">Tambah</a>
                        </div>
                    @endrole
                </div>
                <div class="col-xl-11 col-sm-11">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <select class="form-control selectpicker" data-width="100%" wire:model="exist">
                                <option value="1">Exist</option>
                                <option value="2">Deleted</option>
                                <option value="3">All</option>
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
                        <th>Merk</th>
                        <th>Operator</th>
                        @role('super-admin|supervisor')
                            <th class="width-90"></th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $row)
                        <tr>
                            <td class="align-middle">{{ ++$i }}</td>
                            <td class="align-middle">{{ $row->merk }}</td>
                            <td class="align-middle"><small>{!! $row->pengguna->nama !!}</small></td>
                            @role('super-admin|supervisor')
                                <td class="with-btn-group align-middle text-right" nowrap>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($row->trashed())
                                            @if ($key === $row->getKey())
                                                <button wire:click="restore" class="btn btn-success">Ya, Restore</button>
                                                <button wire:click="setKey" class="btn btn-danger">Batal</button>
                                            @else
                                                <button wire:click="setKey({{ $row->getKey() }})"
                                                    class="btn btn-grey">Restore</button>
                                            @endif
                                        @else
                                            @if ($key === $row->getKey())
                                                <button wire:click="hapus" class="btn btn-warning">Ya, Hapus</button>
                                                <button wire:click="hapusPermanen" class="btn btn-danger">Ya, Hapus
                                                    Permanen</button>
                                                <button wire:click="setKey" class="btn btn-success">Batal</button>
                                            @else
                                                <a href="{{ route('datamaster.merkwatermeter.edit', ['key' => $row->getKey()]) }}"
                                                    class="btn btn-info"><i class="fas fa-sm fa-pencil-alt"></i></a>
                                                <button wire:click="setKey({{ $row->getKey() }})" class="btn btn-danger"><i
                                                        class="fas fa-sm fa-trash-alt"></i></button>
                                            @endif
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
            <label class="pull-right">Jumlah Data : {{ $data->count() }}</label>
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
