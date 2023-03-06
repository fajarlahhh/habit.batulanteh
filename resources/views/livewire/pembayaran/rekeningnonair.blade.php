<div>
    @section('title', 'Pembayaran Rekening Non Air')

    @section('page')
        <li class="breadcrumb-item">Pembayaran</li>
        <li class="breadcrumb-item active">Rekening Non Air</li>
    @endsection

    <h1 class="page-header">Pembayaran Rekening Non Air </h1>

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
            <div class="panel-body ">
                <div class="row width-full">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="control-label">Pelayanan/Sangsi</label>
                            <select class="form-control selectpicker" style="width: 100%;" data-live-search="true"
                                wire:model.lazy="pelayananSangsiId">
                                <option selected hidden>-- Pilih Pelayanan/Sangsi --</option>
                                @foreach (\App\Models\TarifPelayananSangsi::orderBy('jenis')->get() as $row)
                                    <option value="{{ $row->getKey() }}">
                                        {{ $row->jenis . ($row->diameter ? ' ' . $row->diameter->ukuran : '') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelayananSangsiId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tagihan</label>
                            <input class="form-control f-w-700 f-s-20 hitung" type="text" id="tagihan"
                                wire:model.defer="tagihan" autocomplete="off" readonly />
                        </div>
                        <div class="form-group">
                            <label class="control-label f-w-700">Bayar</label>
                            <input class="form-control f-w-700 f-s-20 hitung " type="number" id="bayar"
                                wire:model.defer="bayar" autocomplete="off" />
                            @error('bayar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label f-w-700">Sisa</label>
                            <input class="form-control bg-red text-white f-w-700 f-s-14 numbering" type="text"
                                id="sisa" value="0" autocomplete="off" readonly wire:ignore />
                            @error('sisa')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="note note-primary">
                            <div class="note-content width-10">
                                @if ($tarifPelayananSangsi && $tarifPelayananSangsi->pelanggan != null)
                                    <div class="form-group">
                                        <label class="control-label">Cari Pelanggan</label>
                                        <select class="form-control selectpicker" style="width: 100%;" data-size="10"
                                            data-live-search="true" wire:model.lazy="pelangganId">
                                            <option selected hidden>-- Pilih Pelanggan --</option>

                                            @foreach (\App\Models\Pelanggan::where('status', $tarifPelayananSangsi->pelanggan)->get() as $row)
                                                <option value="{{ $row->getKey() }}">{{ $row->no_langganan }} -
                                                    {{ $row->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('pelangganId')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input class="form-control = hitung" type="text" wire:model.defer="nama"
                                        @if ($tarifPelayananSangsi && $tarifPelayananSangsi->pelanggan != null) readonly @endif autocomplete="off" />
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <input class="form-control = hitung" type="text" wire:model.defer="alamat"
                                        autocomplete="off" @if ($tarifPelayananSangsi && $tarifPelayananSangsi->pelanggan != null) readonly @endif />
                                    @error('alamat')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">No. Hp</label>
                                    <input class="form-control = hitung" type="text" wire:model.defer="noHp"
                                        autocomplete="off" @if ($tarifPelayananSangsi && $tarifPelayananSangsi->pelanggan != null) readonly @endif />
                                    @error('noHp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @role('operator|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                    <a class="btn btn-danger" href="/pembayaran/rekeningair/perpelanggan">Reset</a>
                @endrole
            </div>
        </form>
    </div>

    <x-info />
    <x-modal />

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        @if (Session::has('cetak'))
            <script>
                $('#modal-cetak').modal('show');
            </script>
        @endif
        <script>
            autonumeric();

            function autonumeric() {
                $('.numbering').each(function(i, obj) {
                    if (AutoNumeric.getAutoNumericElement(this) === null) {
                        new AutoNumeric(this, {
                            decimalPlaces: 0,
                            modifyValueOnWheel: true,
                            watchExternalChanges: true
                        });
                    }
                });
            }

            $(".hitung").on('keyup change', function(e) {
                sisa()
            })

            function sisa() {
                var tagihan = parseFloat($('#tagihan').val() ? $('#tagihan').val().split(',').join('') : 0);
                var bayar = parseFloat($('#bayar').val() ? $('#bayar').val().split(',').join('') : 0);
                AutoNumeric.getAutoNumericElement('#sisa').set(bayar - tagihan > 0 ? bayar - tagihan : 0);
            }

            Livewire.on('reinitialize', id => {
                sisa();
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>
