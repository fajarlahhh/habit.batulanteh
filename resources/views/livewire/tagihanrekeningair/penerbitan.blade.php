<div>
    @section('title', 'Penerbitan Rekening Air')

    @push('css')
        <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
        <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    @endpush

    @section('page')
        <li class="breadcrumb-item">Tagihan Rekening Air</li>
        <li class="breadcrumb-item active">Penerbitan</li>
    @endsection

    <h1 class="page-header">Penerbitan</h1>

    <x-alert />

    <form wire:submit.prevent="submit">
        <!-- begin nav-tabs -->
        <ul class="nav nav-tabs" wire:ignore>
            <li class="nav-items">
                <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                    <span class="d-sm-none">Data Pelanggan</span>
                    <span class="d-sm-block d-none">Data Pelanggan</span>
                </a>
            </li>
            <li class="nav-items">
                <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Data Rekening Air</span>
                    <span class="d-sm-block d-none">Data Rekening Air</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- begin tab-pane -->
            <div class="tab-pane fade active show" id="default-tab-1" wire:ignore.self>
                <div class="width-full">
                    <div class="form-group">
                        <label class="control-label">Cari Pelanggan</label>
                        <select class="form-control selectpicker" style="width: 100%;" data-live-search="true"
                            wire:model.lazy="pelangganId">
                            <option selected hidden>-- Pilih Pelanggan --</option>
                            @foreach (\App\Models\Pelanggan::all() as $row)
                                <option value="{{ $row->getKey() }}">{{ $row->no_langganan }} - {{ $row->nama }}
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
                        <input class="form-control" type="text" value="{{ $pelanggan ? $pelanggan->nama : null }}"
                            readonly autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">No. Hp</label>
                        <input class="form-control" type="text" value="{{ $pelanggan ? $pelanggan->no_hp : null }}"
                            readonly autocomplete="off" />
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
                @role('user|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
            </div>
            <!-- end tab-pane -->
            <!-- begin tab-pane -->
            <div class="tab-pane fade" id="default-tab-2" wire:ignore.self>
                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <select class="form-control selectpicker" wire:model.defer="tahun" data-live-search="true"
                        data-width="100%">
                        @for ($i = 2020; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('tahun')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Bulan</label>
                    <select class="form-control selectpicker" wire:model.defer="bulan" data-live-search="true"
                        data-width="100%">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ date('F', strtotime('2021-' . $i . '-01')) }}
                            </option>
                        @endfor
                    </select>
                    @error('bulan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="control-label">Golongan</label>
                    <select wire:model.defer="golongan" class="form-control selectpicker" data-live-search="true"
                        data-width="100%">
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
                    <label class="control-label">Stand Lalu</label>
                    <input class="form-control" type="number" autocomplete="off" wire:model.defer="standLalu" />
                    @error('standLalu')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Stand Ini</label>
                    <input class="form-control" type="number" autocomplete="off" wire:model.defer="standIni" />
                    @error('standIni')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="control-label">Status Baca</label>
                    <select wire:model.defer="statusBaca" class="form-control selectpicker" data-live-search="true"
                        data-width="100%">
                        <option selected hidden>-- Status Baca --</option>
                        @foreach (\App\Models\StatusBaca::orderBy('keterangan')->get() as $row)
                            <option value="{{ $row->getKey() }}">
                                {{ $row->keterangan }}
                            </option>
                        @endforeach
                    </select>
                    @error('statusBaca')
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
                <br>
                @role('user|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
            </div>
            <!-- end tab-pane -->
        </div>
    </form>

    <x-info />

    @push('scripts')
        <script>
            Livewire.on('reinitialize', id => {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>
