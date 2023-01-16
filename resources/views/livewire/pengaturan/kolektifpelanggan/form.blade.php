<div>
    @section('title', 'Kolektif Pelanggan')
    @section('page')
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item">Kolektif Pelanggan</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Kolektif Pelanggan <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input class="form-control" type="text" autocomplete="off" wire:model.defer="nama" />
                            @error('nama')
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
                    </div>
                    <div class="col-md-8">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <h4>Detail</h4>
                                <table class="table">
                                    <tr>
                                        <td>Pelanggan</td>
                                        <td>Penanggung Jawab</td>
                                        <td class="width-10"></td>
                                    </tr>
                                    @foreach ($detail as $key => $row)
                                        <tr>
                                            <td class="with-form-control">
                                                <select class="form-control selectpicker" data-width="100%"
                                                    wire:model="detail.{{ $key }}.pelanggan_id">
                                                    <option selected hidden>-- Pilih Pelanggan --</option>
                                                    @foreach (\App\Models\Pelanggan::all() as $row)
                                                        <option value="{{ $row->getKey() }}">
                                                            {{ $row->no_langganan . ' - ' . $row->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="with-form-control">
                                                <input type="text" class="form-control"
                                                    wire:model.defer="detail.{{ $key }}.penanggung_jawab">
                                            </td>
                                            <td class="with-btn align-middle">
                                                <a href="javascript:;" wire:click="hapusDetail({{ $key }})"
                                                    class="btn btn-xs btn-danger">x</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-center with-btn">
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
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('pengaturan.kolektifpelanggan') }}" class="btn btn-danger">Batal</a>
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
