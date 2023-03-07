<div>
    @section('title', 'Mutasi Golongan')

    @section('page')
        <li class="breadcrumb-item">Administrator</li>
        <li class="breadcrumb-item active">Mutasi Golongan</li>
    @endsection

    <h1 class="page-header">Mutasi Golongan</h1>

    <x-alert />

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
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
                            <label class="control-label">Cari Pelanggan</label>
                            <select class="form-control selectpicker" style="width: 100%;" data-live-search="true"
                                data-size="10" data-size="10" wire:model.lazy="pelangganId">
                                <option selected hidden>-- Pilih Pelanggan --</option>
                                @foreach (\App\Models\Pelanggan::all() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->no_langganan }} -
                                        {{ $row->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelangganId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">KTP</label>
                            <input class="form-control" type="text" value="{{ $pelanggan ? $pelanggan->ktp : null }}"
                                autocomplete="off" readonly />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input class="form-control" type="text"
                                value="{{ $pelanggan ? $pelanggan->nama : null }}" readonly autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">No. Hp</label>
                            <input class="form-control" type="text"
                                value="{{ $pelanggan ? $pelanggan->no_hp : null }}" readonly autocomplete="off" />
                            @error('telepon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Alamat Lengkap</label>
                            <textarea class="form-control" rows="3" readonly>{{ $pelanggan ? $pelanggan->alamat : null }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Golongan</label>
                            <input class="form-control" type="text"
                                value="{{ $pelanggan ? $pelanggan->golongan->nama . ' - ' . $pelanggan->golongan->deskripsi : null }}"
                                autocomplete="off" readonly />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <div class="form-group">
                                    <label class="control-label">Golongan Sekarang</label>
                                    <input class="form-control" type="text"
                                        value="{{ $pelanggan ? $pelanggan->golongan->nama.' - '.$pelanggan->golongan->deskripsi : null }}" autocomplete="off"
                                        readonly />
                                </div>
                                @if ($pelanggan)
                                    <hr>
                                    <div class="form-group">
                                        <label for="control-label">Golongan</label>
                                        <select wire:model.defer="golongan" class="form-control selectpicker"
                                            data-live-search="true" data-width="100%">
                                            <option selected hidden>-- Pilih Golongan --</option>
                                            @foreach (\App\Models\Golongan::orderBy('nama')->get() as $row)
                                                <option value="{{ $row->getKey() }}">{{ $row->nama }} -
                                                    {{ $row->deskripsi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('golongan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Catatan</label>
                                        <textarea class="form-control" rows="3" wire:model.defer="catatan"></textarea>
                                        @error('catatan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
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
