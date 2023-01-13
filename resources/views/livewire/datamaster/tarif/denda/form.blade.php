<div>
    @section('title', 'Tarif Denda')
    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Tarif</li>
        <li class="breadcrumb-item">Denda</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Tarif Denda <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                    <label class="control-label">Tanggal Berlaku</label>
                    <input class="form-control date" type="text" autocomplete="off" readonly
                        onchange="@this.set('tanggalBerlaku', this.value);" wire:model.defer="tanggalBerlaku" />
                    @error('tanggalBerlaku')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">SK</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model.defer="sk" />
                    @error('sk')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model.defer="keterangan" />
                    @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Nilai</label>
                    <input class="form-control" type="number" autocomplete="off" step="any"
                        wire:model.defer="nilai" />
                    @error('nilai')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.tarif.denda') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />

    @push('scripts')
        <script>
            $('.date').datepicker({
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                orientation: "bottom",
                autoclose: true
            });

            Livewire.on('reinitialize', () => {
                $('.date').datepicker({
                    todayHighlight: true,
                    format: 'yyyy-mm-dd',
                    orientation: "bottom",
                    autoclose: true
                });
            });
        </script>
    @endpush
</div>
