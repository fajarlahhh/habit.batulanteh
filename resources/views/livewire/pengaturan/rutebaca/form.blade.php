<div>
    @section('title', 'Rute Baca')
    @section('page')
        <li class="breadcrumb-item">Regional</li>
        <li class="breadcrumb-item">Rute Baca</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Rute Baca <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                <div class="row">
                    <div class="col-md-5">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <h4>Data Rayon</h4>
                                <div class="table-responsive height-400">
                                    <table class="table">
                                        @foreach (collect($dataRayon)->sortBy('nama')->all() as $key => $row)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $row['nama'] }}
                                                </td>
                                                <td class="with-btn align-middle width-10">
                                                    <a href="javascript:;"
                                                        wire:click="tambahDetail({{ $key }},{{ $row['rayon_id'] }})"
                                                        class="btn btn-info">+</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <h1 style="font-size: 100px; margin-top: 160px"><i class="fas fa-forward"></i></h1>
                    </div>
                    <div class="col-md-5">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <h4>Data Rayon di Rute Baca Ini</h4>
                                <div class="table-responsive height-400">
                                    <table class="table">
                                        @foreach (collect($detail)->sortBy('nama')->all() as $key => $row)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ $row['nama'] }}
                                                </td>
                                                <td class="with-btn align-middle width-10">
                                                    <a href="javascript:;"
                                                        wire:click="hapusDetail({{ $key }},{{ $row['rayon_id'] }})"
                                                        class="btn btn-danger">-</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
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
                <a href="{{ route('pengaturan.rutebaca') }}" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>

    <x-info />

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        <script>
            Livewire.on('reinitialize', () => {
                $('.selectpicker').selectpicker()
            });
        </script>
    @endpush
</div>
