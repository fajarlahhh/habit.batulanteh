<div>
    @section('title', 'Informasi Pelanggan')

    @section('page')
        <li class="breadcrumb-item">Pembayaran</li>
        <li class="breadcrumb-item active">Informasi Pelanggan</li>
    @endsection

    <h1 class="page-header">Informasi Pelanggan </h1>

    <x-alert />

    <select class="form-control selectpicker mb-3" style="width: 100%;" data-size="10" data-live-search="true"
        data-style="primary" wire:model.lazy="pelangganId">
        <option selected hidden>-- Cari Pelanggan --</option>
        @foreach (\App\Models\Pelanggan::all() as $row)
            <option value="{{ $row->getKey() }}">{{ $row->no_langganan }} -
                {{ $row->nama }}
            </option>
        @endforeach
    </select>

    <ul class="nav nav-tabs" wire:ignore>
        <li class="nav-items">
            <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                <span class="d-sm-none">Data Pelanggan</span>
                <span class="d-sm-block d-none">Data Pelanggan</span>
            </a>
        </li>
        <li class="nav-items">
            <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                <span class="d-sm-none">Rekening Air</span>
                <span class="d-sm-block d-none">Rekening Air</span>
            </a>
        </li>
        <li class="nav-items">
            <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                <span class="d-sm-none">Log Pelanggan</span>
                <span class="d-sm-block d-none">Log Pelanggan</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade active show" id="default-tab-1" wire:ignore.self>
            <div class="row width-full">
                <div class="col-lg-6 table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-nowrap width-100">No. Langganan</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->no_langganan : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Status</td>
                            <td class="width-10">:</td>
                            <td>
                                @if ($pelanggan)
                                    @switch($pelanggan->status)
                                        @case(1)
                                            Putus Sementara
                                        @break

                                        @case(2)
                                            Putus Sementara
                                        @break

                                        @case(3)
                                            Putus Sementara Permintaan Sendiri
                                        @break

                                        @case(4)
                                            Putus Rampung
                                        @break

                                        @default
                                    @endswitch
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">No. KTP</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->ktp : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Nama</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->nama : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Alamat</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->alamat : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">No. Hp</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->no_hp : null }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Tanggal Pasang</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->tanggal_pasang : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Tanggal Putus Sementara</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->tanggal_putus_sementara : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Tanggal Putus Rampung</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->tanggal_putus_rampung : null }}</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Golongan</td>
                            <td class="width-10">:</td>
                            <td>{{ $pelanggan ? $pelanggan->golongan->nama . ' - ' . $pelanggan->golongan->keterangan : null }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-nowrap width-100">Angsuran</td>
                            <td class="width-10">:</td>
                            <td>{!! $pelanggan
                                ? ($pelanggan->angsuranRekeningAir->count() > 0
                                    ? "<strong class='text-danger'>YA</strong>"
                                    : null)
                                : null !!}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <div class="note note-secondary">
                        <table class="table table-borderless">
                            <tr>
                                <th colspan="3">
                                    Lokasi
                                </th>
                            </tr>
                            <tr>
                            <tr>
                                <td class="text-nowrap width-100">Jalan</td>
                                <td class="width-10">:</td>
                                <td>
                                    {{ $pelanggan && $pelanggan->jalan ? $pelanggan->jalan->nama . ', ' . $pelanggan->jalan->kelurahan->nama . ', ' . $pelanggan->jalan->kelurahan->kecamatan->nama . ', ' . $pelanggan->jalan->kelurahan->kecamatan->kabupaten->nama : null }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap width-100">Pembaca Meter</td>
                                <td class="width-10">:</td>
                                <td>{{ $pelanggan && $pelanggan->pembaca ? $pelanggan->pembaca->nama : null }}</td>
                            </tr>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3">
                                    Data Water Meter
                                </th>
                            </tr>
                            <tr>
                                <td class="text-nowrap width-100">Merk</td>
                                <td class="width-10">:</td>
                                <td>{{ $pelanggan && $pelanggan->merkWaterMeter ? $pelanggan->merkWaterMeter->merk : null }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap width-100">No. Body</td>
                                <td class="width-10">:</td>
                                <td>{{ $pelanggan ? $pelanggan->no_body_water_meter : null }}</td>
                            </tr>
                            <tr>
                                <td class="text-nowrap width-100">Diameter</td>
                                <td class="width-10">:</td>
                                <td>{{ $pelanggan && $pelanggan->diameter ? $pelanggan->diameter->ukuran : null }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="default-tab-2" wire:ignore.self>
            <div class="table-responsive width-full overflow-auto height-400">
                <table class="table table-striped">
                    <tr>
                        <th>Periode</th>
                        <th>Golongan</th>
                        <th>Stand Ini</th>
                        <th>Pakai</th>
                        <th>Status Baca</th>
                        <th>Tagihan</th>
                        <th>Denda</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                    </tr>
                    @php
                        $tunggakan = 0;
                        $lembar = 0;
                    @endphp
                    @if ($pelanggan)
                        @foreach ($pelanggan->tagihan as $key => $row)
                            @php
                                $periode = new \Carbon\Carbon($row->periode);
                                $tagihan = $row->rekeningAir->harga_air + $row->rekeningAir->biaya_lainnya + $row->rekeningAir->biaya_meter_air + $row->rekeningAir->biaya_materai + $row->rekeningAir->biaya_ppn - $row->rekeningAir->diskon;
                                $denda =
                                    $periode
                                        ->addMonths(1)
                                        ->day(25)
                                        ->format('Ymd') < \Carbon\Carbon::now()->format('Ymd') &&
                                    $row->waktu_bayar == null &&
                                    $row->kasir == null
                                        ? $dataTarifDenda->nilai
                                        : $row->biaya_denda;
                                if (!$row->kasir && !$row->waktu_bayar) {
                                    $tunggakan += $tagihan + $denda;
                                    ++$lembar;
                                }
                            @endphp
                            <tr
                                class="{{ $row->angsuranRekeningAirPeriode ? 'bg-yellow-transparent-5' : (!$row->kasir || !$row->waktu_bayar ? ($row->keterangan ? 'bg-purple-transparent-7' : 'bg-red-transparent-5') : null) }}">
                                <td>{{ $row->periode }}</td>
                                <td>{{ $row->golongan ? $row->golongan->nama : null }}</td>
                                <td>{{ number_format($row->stand_ini) }}</td>
                                <td>{{ number_format($row->stand_ini - $row->stand_lalu) }}</td>
                                <td>{{ $row->status_baca }}</td>
                                <td class="text-right">{{ number_format($tagihan) }}</td>
                                <td class="text-right">{{ number_format($denda) }}</td>
                                <td class="text-right">{{ number_format($tagihan + $denda) }}</td>
                                <td>{{ $row->kasir ? $row->kasir . ', ' . $row->waktu_bayar : null }}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            <br>
            <table class="table">
                <tr class="bg-blue-transparent-5">
                    <th class="width-100">Tunggakan</th>
                    <td>:</td>
                    <td class="text-right">{{ number_format($tunggakan) }}</td>
                </tr>
                <tr class="bg-blue-transparent-5">
                    <th>Lembar</th>
                    <td>:</td>
                    <td class="text-right">{{ number_format($lembar) }}</td>
                </tr>
            </table>
        </div>
        <div class="tab-pane fade" id="default-tab-3" wire:ignore.self>
            <div class="table-responsive width-full overflow-auto height-600">

            </div>
        </div>
    </div>

    <x-info />
    <x-modal />

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        @if (Session::has('cetak'))
            <script>
                $('#modal-cetak').modal('show');
            </script>
        @endif
        <script>
            $('.selectpicker').selectpicker();
            Livewire.on('reinitialize', id => {
                $('.selectpicker').selectpicker();
            });
        </script>
    @endpush
</div>