<div>
    @section('title', 'Ganti Kata Sandi')

    @section('page')
        <li class="breadcrumb-item active">Ganti Kata Sandi</li>
    @endsection

    <h1 class="page-header">Ganti Kata Sandi</small></h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Form</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                        class="fa fa-expand"></i></a>
            </div>
        </div>
        <form wire:submit.prevent="submit">
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Kata Sandi Lama</label>
                    <input data-toggle="password" data-placement="after" class="form-control password" type="password"
                        wire:model.defer="kataSandiLama" />
                    @error('kataSandiLama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Kata Sandi Baru</label>
                    <input data-toggle="password" data-placement="after" class="form-control password" type="password"
                        wire:model.defer="kataSandiBaru" />
                    @error('kataSandiBaru')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
            </div>
        </form>
    </div>

    <x-info />

    @push('scripts')
        <script src="/assets/plugins/bootstrap-show-password/dist/bootstrap-show-password.js"></script>
        <script>
            Livewire.on('reinitialize', () => {
                $('.password').password();
            });
        </script>
    @endpush
</div>
