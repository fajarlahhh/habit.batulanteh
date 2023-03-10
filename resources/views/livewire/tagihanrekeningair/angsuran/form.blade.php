<div>
    @section('title', 'Angsuran')

    @section('page')
        <li class="breadcrumb-item">Tagihan Rekening Air</li>
        <li class="breadcrumb-item">Angsuran </li>
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
                            data-size="10" wire:model.lazy="pelangganId">
                            <option selected hidden>-- Pilih Pelanggan --</option>
                            @foreach (\App\Models\Pelanggan::whereDoesntHave('angsuranRekeningAir', fn($q) => $q->belumLunas())->get() as $row)
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
                @role('operator|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('tagihanrekeningair.angsuran') }}" class="btn btn-primary">Data Angsuran</a>
            </div>
            <!-- end tab-pane -->
            <!-- begin tab-pane -->
            <div class="tab-pane fade" id="default-tab-2" wire:ignore.self>
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
                                                <th class="width-100">Periode</th>
                                                <th class="width-200">Tagihan</th>
                                                <th class="width-150">Denda</th>
                                                <th class="width-10"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (collect($dataRekeningAir)->sortBy('periode') as $index => $row)
                                                <tr>
                                                    <td class="align-middle">
                                                        {{ $row['periode'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($row['tagihan']) }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($row['denda']) }}
                                                    </td>
                                                    <td class="with-btn align-middle">
                                                        <a href="javascript:;" wire:click="hapus({{ $index }})"
                                                            class="btn btn-xs btn-danger">X</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Total Tunggakan</label>
                                    <input class="form-control" type="text"
                                        value="{{ number_format(collect($dataRekeningAir)->sum(fn($q) => $q['tagihan'] + $q['denda'])) }}"
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
                                        data-style="btn-success" data-size="10" data-width="100%" wire:model="tenor">
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
                                    <input class="form-control" type="number" wire:model.lazy="angsuranPertama"
                                        autocomplete="off" />
                                    @error('angsuranPertama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Angsuran Selanjutnya</label>
                                    <input class="form-control" type="number" wire:model.defer="angsuranSelanjutnya"
                                        autocomplete="off" readonly />
                                    @error('angsuranSelanjutnya')
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
                                    <textarea class="form-control" type="text" wire:model.defer="keterangan" autocomplete="off" rows="3">
                                    </textarea>
                                    @error('keterangan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @role('operator|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('tagihanrekeningair.angsuran') }}" class="btn btn-primary">Data Angsuran</a>
            </div>
            <!-- end tab-pane -->
        </div>
        <!-- end nav-tabs -->
    </form>

    <div wire:loading>
        <x-loading />
    </div>

    <x-info />

    @push('scripts')
        <script>
            Livewire.on('reinitialize', id => {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>
