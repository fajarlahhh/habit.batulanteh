<div>
    @section('title', 'Master Pelanggan')
    @section('page')
        <li class="breadcrumb-item">Master Pelanggan</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Master Pelanggan <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                            <label class="control-label">No. Langganan</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="noLangganan"
                                disabled />
                            @error('noLangganan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="control-label">Status</label>
                            <select wire:model.defer="status" class="form-control selectpicker" data-width="100%">
                                <option selected hidden>-- Pilih Status --</option>
                                <option value="1">Aktif</option>
                                <option value="2">Putus Sementara</option>
                                <option value="3">Putus Sementara Permintaan Pelanggan</option>
                                <option value="4">Putus Rampung</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">KTP</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="ktp" />
                            @error('ktp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="nama" />
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">No. Hp</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="noHp" />
                            @error('noHp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Alamat</label>
                            <textarea wire:model.defer="alamat" class="form-control"rows="3"></textarea>
                            @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="control-label">Jalan/Gang/Perumahan</label>
                            <select wire:model.defer="jalan" class="form-control selectpicker" data-width="100%"
                                data-live-search="true">
                                <option selected hidden>-- Pilih Jalan --</option>
                                @foreach (\App\Models\Jalan::orderBy('nama')->get() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->nama }},
                                        {{ $row->kelurahan->nama }}, {{ $row->kelurahan->kecamatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jalan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Pasang</label>
                                    <input class="form-control date" type="text" autocomplete="off" readonly
                                        onchange="@this.set('tanggalPasang', this.value);"
                                        wire:model.defer="tanggalPasang" />
                                    @error('tanggalPasang')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">No. Body WM</label>
                                    <input class="form-control" type="text" autocomplete="off"
                                        wire:model.defer="noBodyWaterMeter" />
                                    @error('noBodyWaterMeter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
                                    <label for="control-label">Merk WM</label>
                                    <select wire:model.defer="merkWaterMeter" class="form-control selectpicker"
                                        data-live-search="true" data-width="100%">
                                        <option selected hidden>-- Pilih Merk WM --</option>
                                        @foreach (\App\Models\MerkWaterMeter::orderBy('merk')->get() as $row)
                                            <option value="{{ $row->getKey() }}">{{ $row->merk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('merkWaterMeter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="control-label">Diameter</label>
                                    <select wire:model.defer="diameter" class="form-control selectpicker"
                                        data-live-search="true" data-width="100%">
                                        <option selected hidden>-- Pilih Diameter --</option>
                                        @foreach (\App\Models\Diameter::orderBy('ukuran')->get() as $row)
                                            <option value="{{ $row->getKey() }}">{{ $row->ukuran }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('diameter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="control-label">Petugas Baca Meter</label>
                                    <select wire:model.defer="pembaca" class="form-control selectpicker"
                                        data-live-search="true" data-size="10" data-width="100%">
                                        <option selected hidden>-- Pilih Petugas Baca Meter --</option>
                                        @foreach (\App\Models\Pengguna::orderBy('nama')->get() as $row)
                                            <option value="{{ $row->getKey() }}">{{ $row->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pembaca')
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
                <a href="{{ route('datamaster.regional.jalan') }}" class="btn btn-danger">Batal</a>
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
                $('.selectpicker').selectpicker()
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
