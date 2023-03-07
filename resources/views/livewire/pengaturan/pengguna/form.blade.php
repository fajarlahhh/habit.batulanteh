<div>
    @section('title', ($key ? 'Edit' : 'Tambah') . ' Pengguna')

    @section('page')
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item">Pengguna</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Pengguna <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
            <div class="panel-body">
                <div class="row width-full">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">UID</label>
                            <input class="form-control" type="text" wire:model.defer="uid" wire:ignore
                                @if ($key) readonly @endif />
                            @error('uid')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input class="form-control" type="text" wire:model.defer="nama" wire:ignore />
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Deskrpsi</label>
                            <textarea class="form-control" type="text" wire:model.defer="deskripsi" wire:ignore rows="3"></textarea>
                            @error('deskripsi')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Level</label>
                            <select class="form-control selectpicker" wire:model.lazy="level" data-width="100%">
                                <option selected hidden>-- Pilih Level --</option>
                                @if ($uid == 'admin')
                                    <option value="administrator">Administrator</option>
                                @else
                                    @foreach ($dataLevel as $row)
                                        <option value="{{ $row->name }}">{{ ucfirst($row->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('level')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Unit Pelayanan</label>
                            <select class="form-control selectpicker" data-live-search="true" data-width="100%"
                                wire:model="unitPelayanan">
                                <option value="">-- Tidak Ada --</option>
                                @foreach (\App\Models\UnitPelayanan::all() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            @error('unitPelayanan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="alert alert-muted form-inline">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="penagih0" name="penagih" class="custom-control-input" wire:model.defer="penagih" value="0">
                                <label class="custom-control-label" for="penagih0">Bukan Penagih</label>
                            </div>
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="penagih1" name="penagih" class="custom-control-input" wire:model.defer="penagih" value="1">
                                <label class="custom-control-label" for="penagih1">Penagih</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="penagih2" name="penagih" class="custom-control-input" wire:model.defer="penagih" value="2">
                                <label class="custom-control-label" for="penagih2">PPOB</label>
                            </div>
                        </div>
                        <div class="checkbox checkbox-css">
                            <input type="checkbox" id="bacameter" wire:model.defer="bacameter" />
                            <label for="bacameter">
                                Baca Meter
                            </label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="note note-secondary">
                            <div class="note-content">
                                <h4><b>Hak Akses</b></h4>
                                @error('akses')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <hr>
                                <div class="height-400" style="display: block; position: relative; overflow: auto;">
                                    <div class="row">
                                        @php
                                            function subMenu($menu, $class, $akses, $level)
                                            {
                                                $subMenu = '';
                                                foreach ($menu as $i => $mn) {
                                                    $subMenu .= "<div class='hakakses checkbox checkbox-css'><input " . ($level == 'administrator' ? 'disabled' : '') . " type='checkbox' class='" . $class . "' wire:model.defer='akses' id='" . $mn['id'] . "' value='" . $mn['id'] . "'/><label for='" . $mn['id'] . "'>" . $mn['title'] . '' . subMenu($mn['sub_menu'], $class . ' ' . $mn['id'], $akses, $level) . '</label></div>';
                                                }
                                                return $subMenu;
                                            }
                                        @endphp
                                        @foreach ($dataMenu as $i => $mn)
                                            <div class="checkbox checkbox-css col-md-6 col-lg-6 col-xl-4">
                                                <input type="checkbox" wire:model.defer="akses"
                                                    @if ($level == 'administrator') disabled @endif
                                                    id="{{ $mn['id'] }}" value="{{ $mn['id'] }}" />
                                                <label for="{{ $mn['id'] }}">{{ $mn['title'] }}
                                                    {!! subMenu($mn['sub_menu'], $mn['id'], $akses, $level) !!}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6">
                        @role('administrator|super-admin')
                            <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                        @endrole
                        <a href="{{ route('pengaturan.pengguna') }}" class="btn btn-danger m-r-3">Batal</a>
                    </div>
                    <div class="col-md-6 text-right">
                        @if ($key)
                            <a href="javascript:;" wire:click="resetKataSandi" class="btn btn-warning">Reset
                                Kata Sandi
                            </a>
                            <a href="javascript:;" wire:click="resetApiToken" class="btn btn-warning">Reset
                                API Token
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            Livewire.on('reinitialize', () => {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>
