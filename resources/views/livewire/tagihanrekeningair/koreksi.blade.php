<div>
    @section('title', 'Koreksi Rekening Air')

    @push('css')
        <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
        <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    @endpush

    @section('page')
        <li class="breadcrumb-item">Tagihan Rekening Air</li>
        <li class="breadcrumb-item active">Koreksi</li>
    @endsection

    <h1 class="page-header">Koreksi</h1>

    <x-alert />

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
                    <span class="d-sm-none">Data Rekening Air</span>
                    <span class="d-sm-block d-none">Data Rekening Air</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- begin tab-pane -->
            <div class="tab-pane fade active show" id="default-tab-1" wire:ignore.self>
                <div class="width-full">
                    <div class="form-group">
                        <label class="control-label">Cari Pelanggan</label>
                        <select class="form-control selectpicker" style="width: 100%;" data-live-search="true"
                            data-size="10" wire:model.lazy="pelangganId">
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
                @role('user|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
            </div>
            <!-- end tab-pane -->
            <!-- begin tab-pane -->
            <div class="tab-pane fade" id="default-tab-2" wire:ignore.self>
                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <select class="form-control selectpicker" wire:model="tahun" data-live-search="true"
                        data-width="100%">
                        @for ($i = 2010; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="overflow-auto table-responsive height-400 overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Golongan</th>
                                <th class="width-150">Stand Lalu</th>
                                <th class="width-150">Stand Ini</th>
                                <th class="width-150">Stand Angkat</th>
                                <th class="width-150">Stand Pasang</th>
                                <th class="width-100">Pakai</th>
                                <th>Harga Air</th>
                                <th>Materai</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRekeningAir as $index => $row)
                                <tr>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="text" value="{{ $row['periode'] }}"
                                                autocomplete="off" readonly />
                                            @error('dataRekeningAir.' . $index . '.periode')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <select class="form-control selectpicker" data-live-search="true"
                                                wire:model="dataRekeningAir.{{ $index }}.golongan_id_baru"
                                                @if ($row['angsur'] == 1 || $row['data_tarif'] == 0 || ($row['kasir'] || $row['waktu_bayar'])) disabled @else 
                                                wire:change="setHargaAir({{ $index }})" @endif
                                                data-size="10" data-width="100%">
                                                <option hidden selected>--Pilih Golongan--</option>
                                                @foreach (\App\Models\Golongan::all() as $subRow)
                                                    <option value="{{ $subRow->getKey() }}">
                                                        {{ $subRow->nama . ' - ' . $subRow->deskripsi }}</option>
                                                @endforeach
                                            </select>
                                            @error('dataRekeningAir.' . $index . '.golongan_id_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="number"
                                                @if ($row['angsur'] == 1 || $row['data_tarif'] == 0 || ($row['kasir'] || $row['waktu_bayar'])) disabled value="{{ $row['stand_lalu_baru'] }}" @else wire:model.lazy="dataRekeningAir.{{ $index }}.stand_lalu_baru" wire:change="setHargaAir({{ $index }})" @endif
                                                autocomplete="off" />
                                            @error('dataRekeningAir.' . $index . '.stand_lalu_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="number"
                                                @if ($row['angsur'] == 1 || $row['data_tarif'] == 0 || ($row['kasir'] || $row['waktu_bayar'])) disabled value="{{ $row['stand_ini_baru'] }}" @else wire:model.lazy="dataRekeningAir.{{ $index }}.stand_ini_baru" wire:change="setHargaAir({{ $index }})" @endif
                                                autocomplete="off" />
                                            @error('dataRekeningAir.' . $index . '.stand_ini_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="number"
                                                @if ($row['angsur'] == 1 || $row['data_tarif'] == 0 || ($row['kasir'] || $row['waktu_bayar'])) disabled value="{{ $row['stand_angkat_baru'] }}" @else wire:model.lazy="dataRekeningAir.{{ $index }}.stand_angkat_baru" wire:change="setHargaAir({{ $index }})" @endif
                                                autocomplete="off" />
                                            @error('dataRekeningAir.' . $index . '.stand_angkat_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="number"
                                                @if ($row['angsur'] == 1 || $row['data_tarif'] == 0 || ($row['kasir'] || $row['waktu_bayar'])) disabled value="{{ $row['stand_pasang_baru'] }}" @else wire:model.lazy="dataRekeningAir.{{ $index }}.stand_pasang_baru" wire:change="setHargaAir({{ $index }})" @endif
                                                autocomplete="off" />
                                            @error('dataRekeningAir.' . $index . '.stand_pasang_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="text"
                                                value="{{ $row['stand_angkat_baru'] || $row['stand_pasang_baru'] ? $row['stand_ini_baru'] - $row['stand_pasang_baru'] + $row['stand_angkat_baru'] - $row['stand_lalu_baru'] : $row['stand_ini_baru'] - $row['stand_lalu_baru'] }}"
                                                autocomplete="off" readonly />
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="text"
                                                value="{{ number_format($row['harga_air_baru']) }}"
                                                autocomplete="off" readonly />
                                            @error('dataRekeningAir.' . $index . '.harga_air_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="with-btn">
                                        <div class="form-group m-0">
                                            <input class="form-control" type="text"
                                                value="{{ number_format($row['biaya_materai_baru']) }}"
                                                autocomplete="off" readonly />
                                            @error('dataRekeningAir.' . $index . '.biaya_materai_baru')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="pt-0 align-middle">
                                        @if ($row['data_tarif'] == 0)
                                            <small class="text-red">Tidak ada data tarif</small>
                                        @else
                                            @if ($row['angsur'] == 1)
                                                <small class="text-red">Diangsur</small>
                                            @else
                                                <small>{{ strtoupper($row['kasir']) }}<br>{{ $row['waktu_bayar'] }}</small>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <label class="control-label">Catatan</label>
                    <textarea class="form-control" rows="3" wire:model.defer="catatan"></textarea>
                    @error('catatan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                @role('user|administrator|super-admin')
                    <div wire:loading.remove>
                        <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                    </div>
                @endrole
            </div>
            <!-- end tab-pane -->
        </div>
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
