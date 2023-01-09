<div>
    @section('title', 'Angsuran Rekening Air')

    @push('css')
        <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @section('page')
        <li class="breadcrumb-item">Tagihan Rekening Air</li>
        <li class="breadcrumb-item">Angsuran Rekening Air</li>
        <li class="breadcrumb-item active">Tambah Data</li>
    @endsection

    <h1 class="page-header"><strong>Angsuran</strong> <small>Tambah Data</small></h1>

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
                    <span class="d-sm-none">Angsuran</span>
                    <span class="d-sm-block d-none">Angsuran</span>
                </a>
            </li>
        </ul>
        <!-- end nav-tabs -->
        <!-- begin tab-content -->
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
            </div>
            <!-- end tab-pane -->
            <!-- begin tab-pane -->
            {{-- <div class="tab-pane fade" id="default-tab-2" wire:ignore.self>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="note note-primary">
                            <div class="note-content width-10">
                                <h4>Data Tagihan</h4>
                                <hr>
                                <div class="height-300 overflow-auto table-responsive">
                                    <table class="table width-full">
                                        <thead>
                                            <tr>
                                                <th class="width-10"></th>
                                                <th class="width-100">Periode</th>
                                                <th class="width-200">Tagihan</th>
                                                <th class="width-150">Denda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (collect($dataRekeningAir)->sortBy('periode') as $index => $row)
                                                <tr>
                                                    <td class="with-btn align-middle">
                                                        <a href="javascript:;" wire:click="hapus({{ $row['id'] }})"
                                                            class="btn btn-xs btn-danger m-t-5">X</a>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $row['periode'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($row['total']) }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($row['denda']) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Total Tunggakan Yang Akan Diangsur</label>
                                    <input class="form-control" type="number" wire:model="total_tunggakan"
                                        autocomplete="off" readonly />
                                    @error('total_tunggakan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="note note-warning">
                            <div class="note-content width-10">
                                <div class="form-group">
                                    <label class="control-label">Tenor</label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                        data-style="btn-success" wire:change="simulasi()" data-size="10"
                                        data-width="100%" wire:model="tenor">
                                        @for ($i = 2; $i < 31; $i++)
                                            <option value="{{ $i }}">{{ $i }} Kali</option>
                                        @endfor
                                    </select>
                                    @error('tenor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Angsuran ke 1</label>
                                    <input class="form-control" type="number" wire:model.lazy="keterangan"
                                        wire:change="simulasi()" autocomplete="off" />
                                    @error('keterangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">{{ $keterangan_angsuran }}</label>
                                    <input class="form-control" type="number"
                                        wire:model.defer="angsuran_selanjutnya" autocomplete="off" readonly />
                                    @error('angsuran_selanjutnya')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="control-label">Pemohon</label>
                                    <input class="form-control" type="text" wire:model.defer="pemohon"
                                        autocomplete="off" />
                                    @error('pemohon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <input class="form-control" type="text" wire:model.defer="keterangan"
                                        autocomplete="off" />
                                    @error('keterangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @role('user|super-admin|supervisor')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('tagihanrekeningair.angsuran') }}" class="btn btn-danger">Batal</a>
            </div> --}}
            <!-- end tab-pane -->
        </div>
        <!-- end nav-tabs -->
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
