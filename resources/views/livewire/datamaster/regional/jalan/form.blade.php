<div>
    @section('title', 'Jalan/Perumahan')
    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Regional</li>
        <li class="breadcrumb-item">Jalan/Perumahan</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Jalan/Perumahan <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">Form</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                        class="fa fa-expand"></i></a>
            </div>
        </div>
        <form wire:submit.prevent="submit">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="nama" />
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="control-label">Jenis</label>
                            <select wire:model.defer="jenis" class="form-control selectpicker" data-width="100%">
                                <option selected hidden>-- Pilih Jenis --</option>
                                <option value="Jalan">Jalan</option>
                                <option value="Perumahan">Perumahan</option>
                            </select>
                            @error('jenis')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                <div class="col-md-8">
                    <div class="note note-secondary">
                        <div class="note-content">
                            <h4>Kelurahan Yang Dilewati</h4>
                            <table class="table">
                                @foreach ($detail as $key => $row)
                                    <tr>
                                        <td class="with-form-control">
                                            <select class="form-control selectpicker" data-live-search="true"
                                                data-width="100%" data-size="10"
                                                wire:model.defer="detail.{{ $key }}.kelurahan_id">
                                                <option selected hidden>-- Pilih Kelurahan --</option>
                                                @foreach ($dataKelurahan as $row)
                                                    <option value="{{ $row->getKey() }}">
                                                        {{ $row->nama . ', ' . $row->nama . ', ' . $row->kecamatan->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="with-btn align-middle width-10">
                                            <a href="javascript:;" wire:click="hapusDetail({{ $key }})"
                                                class="btn btn-danger">X</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-center with-btn">
                                        <a href="javascript:;" class="btn btn-sm btn-primary"
                                            wire:click="tambahDetail">Tambah</a>
                                        @error('detail')
                                            <br>
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.regional.jalan') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />
    @push('scripts')
        <script>
            Livewire.on('reinitialize', () => {
                $('.selectpicker').selectpicker()
            });
        </script>
    @endpush
</div>
