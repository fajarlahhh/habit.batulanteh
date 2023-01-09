<div>
    @section('title', ($key ? 'Edit' : 'Tambah') . ' Pengguna')

    @section('page')
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item">Pengguna</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Pengguna <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                                @foreach ($dataLevel as $row)
                                    <option value="{{ $row->name }}">{{ ucfirst($row->name) }}</option>
                                @endforeach
                            </select>
                            @error('level')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                                                    $subMenu .= "<div class='hakakses checkbox checkbox-css'><input " . ($level == 'super-admin' ? 'disabled' : '') . " type='checkbox' class='" . $class . "' wire:model.defer='akses' id='" . $mn['id'] . "' value='" . $mn['id'] . "'/><label for='" . $mn['id'] . "'>" . $mn['title'] . '' . subMenu($mn['sub_menu'], $class . ' ' . $mn['id'], $akses, $level) . '</label></div>';
                                                }
                                                return $subMenu;
                                            }
                                        @endphp
                                        @foreach ($dataMenu as $i => $mn)
                                            <div class="checkbox checkbox-css col-md-6 col-lg-6 col-xl-4">
                                                <input type="checkbox" wire:model.defer="akses"
                                                    @if ($level == 'super-admin') disabled @endif
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
                @role('super-admin|supervisor')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('pengaturan.pengguna') }}" class="btn btn-danger m-r-3">Batal</a>
                <a href="javascript:;" wire:click="resetKataSandi" class="btn btn-warning">Reset
                    Kata Sandi
                </a>
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
