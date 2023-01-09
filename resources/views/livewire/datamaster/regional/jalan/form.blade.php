<div>
    @section('title', 'Jalan/Gang/Perumahan')
    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Regional</li>
        <li class="breadcrumb-item">Jalan/Gang/Perumahan</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Jalan/Gang/Perumahan <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                <div class="form-group">
                    <label class="control-label">Nama</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model.defer="nama" />
                    @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="control-label">Kelurahan</label>
                    <select wire:model.defer="kelurahan" class="form-control selectpicker" data-live-search="true"
                        data-width="100%">
                        <option selected hidden>-- Pilih Kelurahan --</option>
                        @foreach (\App\Models\Kelurahan::orderBy('nama')->get() as $row)
                            <option value="{{ $row->getKey() }}">{{ $row->kode }} - {{ $row->nama }}</option>
                        @endforeach
                    </select>
                    @error('kelurahan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="control-label">Jenis</label>
                    <select wire:model.defer="jenis" class="form-control selectpicker" data-width="100%">
                        <option selected hidden>-- Pilih Jenis --</option>
                        <option value="Jalan">Jalan</option>
                        <option value="Gang">Gang</option>
                        <option value="Perumahan">Perumahan</option>
                    </select>
                    @error('jenis')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                @role('super-admin|supervisor')
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
