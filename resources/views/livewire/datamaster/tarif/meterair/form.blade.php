<div>
    @section('title', 'Tarif Meter Air')
    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Tarif</li>
        <li class="breadcrumb-item">Meter Air</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Tarif Meter Air <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Tanggal Berlaku</label>
                            <input class="form-control date" type="text" autocomplete="off" readonly
                                onchange="@this.set('tanggalBerlaku', this.value);" wire:model.defer="tanggalBerlaku" />
                            @error('tanggalBerlaku')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">SK</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="sk" />
                            @error('sk')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Keterangan</label>
                            <textarea class="form-control" type="text" autocomplete="off" wire:model.defer="keterangan" rows="3"></textarea>
                            @error('keterangan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="control-label">Diameter</label>
                            <select wire:model.defer="diameter" class="form-control selectpicker" data-width="100%">
                                <option selected hidden>-- Diameter --</option>
                                @foreach (\App\Models\Diameter::orderBy('ukuran')->get() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->ukuran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('diameter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <h4>Jenis Tarif</h4>
                                <table class="table">
                                    <tr>
                                        <td>Jenis</td>
                                        <td>Harga</td>
                                        <td></td>
                                    </tr>
                                    @foreach ($jenis as $key => $row)
                                        <tr>
                                            <td class="with-form-control">
                                                <input type="text" class="form-control"
                                                    wire:model.defer="jenis.{{ $key }}.jenis">
                                            </td>
                                            <td class="with-form-control">
                                                <input type="number" class="form-control"
                                                    wire:model.defer="jenis.{{ $key }}.nilai">
                                            </td>
                                            <td class="with-btn align-middle">
                                                <a href="javascript:;" wire:click="hapusJenis({{ $key }})"
                                                    class="btn btn-xs btn-danger">x</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-center with-btn">
                                            <a href="javascript:;" class="btn btn-sm btn-primary"
                                                wire:click="tambahJenis">Tambah</a>
                                            @error('jenis')
                                                <br>
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.tarif.meterair') }}" class="btn btn-danger">Batal</a>
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
