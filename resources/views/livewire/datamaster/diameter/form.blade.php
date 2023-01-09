<div>
    @section('title', 'Diameter')

    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Diameter</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Diameter <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                    <label class="control-label">Ukuran</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model.defer="ukuran" />
                    @error('ukuran')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Biaya Pemasangan</label>
                    <input class="form-control currency" type="number" autocomplete="off" step="any"
                        wire:model.defer="biayaPemasangan" />
                    @error('biayaPemasangan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Biaya Ganti Meter</label>
                    <input class="form-control currency" type="number" autocomplete="off" step="any"
                        wire:model.defer="biayaGantiMeter" />
                    @error('biayaGantiMeter')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Biaya Pindah Meter</label>
                    <input class="form-control currency" type="number" autocomplete="off" step="any"
                        wire:model.defer="biayaPindahMeter" />
                    @error('biayaPindahMeter')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                @role('super-admin|supervisor')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.diameter') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />
</div>
