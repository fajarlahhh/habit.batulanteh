<div>
    @section('title', 'Merk Water Meter')

    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Merk Water Meter</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Merk Water Meter <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                    <label class="control-label">Merk</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model.defer="merk" />
                    @error('merk')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                @role('super-admin|supervisor')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.merkwatermeter') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />
</div>
