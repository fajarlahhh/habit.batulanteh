<div>
    @section('title', 'Status Pelanggan')

    @section('page')
        <li class="breadcrumb-item">Administrator</li>
        <li class="breadcrumb-item active">Status Pelanggan</li>
    @endsection

    <h1 class="page-header">Status Pelanggan</h1>

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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Cari Pelanggan</label>
                            <select class="form-control selectpicker" style="width: 100%;" data-live-search="true"
                                data-size="10" wire:model.lazy="pelangganId">
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
                    <div class="col-md-6">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <div class="form-group">
                                    <label class="control-label">Status Pelanggan Saat Ini</label>
                                    <input class="form-control" type="text"
                                        value=" @if ($pelanggan) @switch($pelanggan->status) 
                                        @case(1) Aktif @break
                                        @case(2) Putus Sementara @break
                                        @case(3) Putus Sementara Permintaan Pelanggan @break
                                        @case(4) Putus Rampung @break
                                    @default
                                @endswitch @endif
                                "
                                        autocomplete="off" readonly />
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="control-label">Ubah Status Pelanggan</label>
                                    <div class="row ml-5">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="status1" name="status" value="1"
                                                    wire:model.defer="status" class="custom-control-input">
                                                <label class="custom-control-label" for="status1">Aktif</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="status2" name="status" value="2"
                                                    wire:model.defer="status" class="custom-control-input">
                                                <label class="custom-control-label" for="status2">Putus
                                                    Sementara</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="status3" name="status" value="3"
                                                    wire:model.defer="status" class="custom-control-input">
                                                <label class="custom-control-label" for="status3">Putus Sementara
                                                    Permintaan Sendiri</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="status4" name="status" value="4"
                                                    wire:model.defer="status" class="custom-control-input">
                                                <label class="custom-control-label" for="status4">Putus
                                                    Rampung</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Catatan</label>
                                    <textarea class="form-control" rows="3" wire:model.defer="catatan"></textarea>
                                    @error('catatan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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

    <div wire:loading>
        <x-loading />
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
