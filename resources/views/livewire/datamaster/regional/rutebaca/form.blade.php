<div>
    @section('title', 'Rute Baca')
    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Regional</li>
        <li class="breadcrumb-item">Rute Baca</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Rute Baca <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

    <div wire:loading>
        <x-loading />
    </div>

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
                <div class="form-group">
                    <label class="control-label">Pembaca</label>
                    <select class="form-control selectpicker" data-live-search="true" data-width="100%"
                        wire:model.defer="pembacaId">
                        @if ($this->key)
                            <option value="{{ $data->id }}" selected>
                                {{ $data->nama . ' - ' . $data->uid . ' (' . $data->deskripsi . ')' }}</option>
                        @else
                            <option selected hidden>-- Pilih Pembaca --</option>
                        @endif
                        @foreach ($dataPengguna as $row)
                            <option value="{{ $row->getKey() }}">
                                {{ $row->nama . ' - ' . $row->uid . ' (' . $row->deskripsi . ')' }}
                            </option>
                        @endforeach
                    </select>
                    @error('pembacaId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="note note-secondary">
                    <div class="note-content">
                        <h4>Rayon</h4>
                        <table class="table">
                            @foreach ($detail as $key => $row)
                                <tr>
                                    <td class="with-form-control">
                                        <select class="form-control selectpicker" data-live-search="true"
                                            data-width="100%" wire:model.defer="detail.{{ $key }}.rayon_id">
                                            <option selected hidden>-- Pilih Rayon --</option>
                                            @foreach ($dataRayon as $row)
                                                <option value="{{ $row->getKey() }}">
                                                    {{ $row->kode . ' - ' . $row->nama . ', ' . $row->keterangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="with-btn align-middle width-10">
                                        <a href="javascript:;" wire:click="hapusDetail({{ $key }})"
                                            class="btn btn-danger">X</a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-center with-btn">
                                    <a href="javascript:;" class="btn btn-sm btn-primary"
                                        wire:click="tambahDetail">Tambah</a>
                                    @error('detail')
                                        <br>
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.regional.rutebaca') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />

    @push('scripts')
        <script>
            Livewire.on('reinitialize', () => {
                $('.selectpicker').selectpicker()
            });
        </script>
    @endpush
</div>
