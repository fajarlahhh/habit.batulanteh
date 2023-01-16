<div>
    @section('title', 'Buat Target Baca Meter')

    @push('css')
        <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    @endpush

    @section('page')
        <li class="breadcrumb-item">Baca Meter</li>
        <li class="breadcrumb-item active">Buat Target</li>
    @endsection

    <h1 class="page-header">Buat Target <small>Baca Meter</small></h1>

    <x-alert />

    <div wire:loading>
        <x-loading />
    </div>

    <div class="panel panel-inverse" wire:loading.remove wire:target="submit" data-sortable-id="form-stuff-1">
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
                @if ($proses)
                    <div class="alert alert-warning">
                        Proses ini akan menghapus seluruh data baca meter periode
                        {{ $tahun }}-{{ $bulan }} yang belum terbaca
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label">Bulan</label>
                    <select class="form-control selectpicker" wire:model.defer="bulan" data-width="100%"
                        @if ($proses) disabled @endif>
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
                    <select class="form-control selectpicker" wire:model.defer="tahun" data-width="100%"
                        @if ($proses) disabled @endif>
                        @for ($i = 2023; $i < date('Y') + 1; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('paket')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                @role('user|administrator|super-admin')
                    @if ($proses)
                        <input type="submit" value="Lanjutkan" class="btn btn-success" />
                        <a href="javascript:;" class="btn btn-danger" wire:click="setProses">Batal</a>
                    @else
                        <a href="javascript:;" class="btn btn-success" wire:click="setProses(1)">Submit</a>
                    @endif
                @endrole
            </div>
        </form>
    </div>
    <x-info />
    @push('scripts')
        <script>
            Livewire.on('reinitialize', id => {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>
