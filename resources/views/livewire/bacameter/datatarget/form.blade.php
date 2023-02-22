<div>
    @section('title', 'Data Target Baca Meter')
    @section('page')
        <li class="breadcrumb-item">Baca Meter</li>
        <li class="breadcrumb-item">Data Target</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">{{ $key ? 'Edit' : 'Tambah' }} Data Target <small>Baca Meter</small></h1>

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
                    <div class="col-lg-6">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <div class="form-group">
                                    <label class="control-label">No. Langganan</label>
                                    <input class="form-control" type="text" disabled
                                        value="{{ $data->pelanggan->no_langganan }}" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input class="form-control" type="text" disabled
                                        value="{{ $data->pelanggan->nama }}" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <input class="form-control" type="text" disabled
                                        value="{{ $data->pelanggan->alamat }}" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jalan</label>
                                    <input class="form-control" type="text" disabled
                                        value="{{ $data->pelanggan->jalan ? $data->pelanggan->jalan->nama : '' }}" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Pembaca</label>
                                    <input class="form-control" type="text" disabled
                                        value="{{ $data->pelanggan->pembaca ? $data->pelanggan->pembaca->nama : '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="control-label">Foto</label>
                            <input class="form-control" type="file" accept="image/*" autocomplete="off"
                                wire:model="fotoUpload" />
                            @if ($data->foto)
                            <br>
                                <img src="{{ Storage::url($data->foto) }}" alt="" class="width-full">
                            @endif
                            @error('fotoUpload')
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
                            <label class="control-label">Stand Ini</label>
                            <input class="form-control" type="number" autocomplete="off" wire:model.defer="standIni" />
                            @error('standIni')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tanggal Baca</label>
                            <input class="form-control" type="date" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-t') }}" autocomplete="off" 
                                wire:model.defer="tanggalBaca" />
                            @error('tanggalBaca')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="control-label">Status Baca</label>
                            <select wire:model.defer="statusBaca" class="form-control selectpicker" data-width="100%">
                                <option selected hidden>-- Pilih Status Baca --</option>
                                @foreach (\App\Models\StatusBaca::orderBy('keterangan')->get() as $row)
                                    <option value="{{ $row->keterangan }}">{{ $row->keterangan }}</option>
                                @endforeach
                            </select>
                            @error('statusBaca')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="alert alert-warning">
                            <h4>Diinputkan ketika ada pergantian water meter di bulan ini</h4>
                            <div class="form-group">
                                <label class="control-label">Stand Angkat</label>
                                <input class="form-control" type="number" autocomplete="off" wire:model.defer="standAngkat" />
                                @error('standAngkat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label">Stand Pasang</label>
                                <input class="form-control" type="number" autocomplete="off" wire:model.defer="standPasang" />
                                @error('standPasang')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('bacameter.datatarget') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />

    <div wire:loading>
        <x-loading />
    </div>
    
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
