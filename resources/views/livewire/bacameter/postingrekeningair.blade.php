<div>
    @section('title', 'Posting Rekening Air')

    @push('css')
        <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    @endpush

    @section('page')
        <li class="breadcrumb-item">Baca Meter</li>
        <li class="breadcrumb-item active">Posting Rekening Air</li>
    @endsection

    <h1 class="page-header">Posting Rekening Air</h1>

    <x-alert />

    <div class="panel panel-inverse" wire:target="submit" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading ui-sortable-handle">
            <h4 class="panel-title">Form</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                        class="fa fa-expand"></i></a>
            </div>
        </div>
        <form wire:submit.prevent="submit">
            <div class="panel-body ">
                <div class="alert alert-warning">
                    Proses ini akan menghapus seluruh data tagihan rekening air periode terpilih yang belum terbayar
                </div>
                <div class="form-group">
                    <label class="control-label">Bulan</label>
                    <select class="form-control selectpicker" wire:model.defer="bulan" data-width="100%">
                        @for ($i = 1; $i < 13; $i++)
                            <option value="{{ date('m', strtotime('2021-' . $i . '-01')) }}">
                                {{ date('F', strtotime('2021-' . $i . '-01')) }}</option>
                        @endfor
                    </select>
                    @error('paket')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <select class="form-control selectpicker" wire:model.defer="tahun" data-width="100%">
                        @for ($i = 2023; $i < date('Y') + 1; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('paket')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer" wire:loading.remove>
                @role('operator|administrator|super-admin')
                    <input type="submit" value="Submit" class="btn btn-success" />
                @endrole
            </div>
        </form>
    </div>

    <x-info />

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        <script>
            Livewire.on('reinitialize', id => {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>
