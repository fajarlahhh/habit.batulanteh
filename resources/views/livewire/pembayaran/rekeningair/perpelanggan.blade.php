<div>
    @section('title', 'Pembayaran Rekening Air')

    @section('page')
        <li class="breadcrumb-item">Pembayaran</li>
        <li class="breadcrumb-item">Rekening Air</li>
        <li class="breadcrumb-item active">Per Pelanggan</li>
    @endsection

    <h1 class="page-header">Pembayaran Rekening Air <small>Per Pelanggan</small></h1>

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
                            <label class="control-label">Cari Pelanggan</label>
                            <select class="form-control selectpicker" style="width: 100%;" data-live-search="true"
                                wire:model.lazy="pelangganId">
                                <option selected hidden>-- Pilih Pelanggan --</option>
                                @foreach (\App\Models\Pelanggan::all() as $row)
                                    <option value="{{ $row->getKey() }}">{{ $row->no_langganan }} -
                                        {{ $row->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelangganId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tagihan</label>
                            <input class="form-control f-w-700 f-s-20 hitung" type="text" id="tagihan"
                                value="{{ number_format(collect($dataRekeningAir)->where('angsur', 0)->sum(fn($q) => $q['tagihan'] + $q['denda']) + collect($dataAngsuranRekeningAir)->sum('nilai')) }}"
                                autocomplete="off" readonly />
                        </div>
                        <div class="form-group">
                            <label class="control-label f-w-700">Bayar</label>
                            <input class="form-control f-w-700 f-s-20 hitung " type="number" id="bayar"
                                wire:model.lazy="bayar" autocomplete="off" />
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
                                <h5>Rekening Air</h5>
                                <div class="height-300 overflow-auto table-responsive">
                                    <table class="table width-full">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="width-100">Periode</th>
                                                <th class="width-100 text-nowrap">No. Langganan</th>
                                                <th class="width-150">Nama</th>
                                                <th class="width-150">Alamat</th>
                                                <th>Golongan</th>
                                                <th>Pakai</th>
                                                <th>Tagihan</th>
                                                <th>Denda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataRekeningAir as $index => $row)
                                                @php
                                                    if ($awalRekeningAir != $row['no_langganan']) {
                                                        $no = 0;
                                                        $awalRekeningAir = $row['no_langganan'];
                                                    }
                                                @endphp
                                                <tr
                                                    class="@if ($row['angsur'] == 1) bg-orange-transparent-7 @endif">
                                                    <td class="with-btn align-middle text-nowrap">
                                                        @if ($row['angsur'] == 0 &&
                                                            collect($dataRekeningAir)->where('no_langganan', $row['no_langganan'])->count() -
                                                                $index ==
                                                                1)
                                                            <a href="javascript:;"
                                                                wire:click="hapusDataRekeningAir({{ $index }})"
                                                                class="btn btn-xs btn-danger m-t-5">X</a>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ $row['periode'] }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ $row['no_langganan'] }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ $row['nama'] }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ $row['alamat'] }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ $row['golongan'] }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ number_format($row['pakai']) }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ number_format($row['tagihan']) }}
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ number_format($row['denda']) }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <strong>Jumlah : {{ collect($dataRekeningAir)->count() }}</strong>
                            </div>
                        </div>
                        <div class="note note-warning">
                            <div class="note-content width-10">
                                <h5>Angsuran</h5>
                                <div class="height-250 overflow-auto table-responsive">
                                    <table class="table width-full">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nomor</th>
                                                <th>urutan</th>
                                                <th class="width-100 text-nowrap">No. Langganan</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (collect($dataAngsuranRekeningAir) as $index => $row)
                                                @php
                                                    if ($awalAngsuranRekeningAir != $row['no_langganan']) {
                                                        $no = 0;
                                                        $awalAngsuranRekeningAir = $row['no_langganan'];
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="with-btn align-middle">
                                                        @if (collect($dataAngsuranRekeningAir)->where('no_langganan', $row['no_langganan'])->count() -
                                                            $no ==
                                                            1 && collect($dataAngsuranRekeningAir)->count() > 1)
                                                            <a href="javascript:;"
                                                                wire:click="hapusDataAngsuranRekeningAir({{ $index }})"
                                                                class="btn btn-xs btn-danger m-t-5">X</a>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $row['nomor'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $row['urutan'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $row['no_langganan'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $row['nama'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $row['alamat'] }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ number_format($row['nilai']) }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <strong>Jumlah : {{ collect($dataAngsuranRekeningAir)->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                @role('user|administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                    <a class="btn btn-danger" href="/pembayaran/rekeningair/perpelanggan">Reset</a>
                @endrole
            </div>
        </form>
    </div>

    <x-info />
    <x-modal />

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
