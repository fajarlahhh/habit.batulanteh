<div>
    @section('title', 'Data Rekening Air')

    @section('page')
        <li class="breadcrumb-item">Administrator</li>
        <li class="breadcrumb-item">Data Pembayaran</li>
        <li class="breadcrumb-item active">Rekening Air</li>
    @endsection

    <h1 class="page-header">Data Pembayaran <small>Rekening Air</small></h1>

    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <div class="row width-full">
                <div class="col-xl-3 col-sm-3">
                    &nbsp;
                </div>
                <div class="col-xl-9 col-sm-9">
                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="date" class="form-control" wire:model="tanggal" />
                                @error('tanggal')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>&nbsp;
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari"
                                aria-label="Sizing example input" autocomplete="off" aria-describedby="basic-addon2"
                                wire:model="cari">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="width-60">No.</th>
                        <th>Periode</th>
                        <th>No. Langganan</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Golongan</th>
                        <th>Tagihan</th>
                        <th>Pembayaran</th>
                        @role('super-admin|administrator')
                            <th class="width-90"></th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $row)
                        @php
                            $periode = new \Carbon\Carbon($row->periode);
                        @endphp
                        <tr>
                            <td class="align-middle">{{ ++$i }}</td>
                            <td class="align-middle text-nowrap">{{ $row->periode }}</td>
                            <td class="align-middle">{{ $row->pelanggan->no_langganan }}</td>
                            <td class="align-middle">{{ $row->pelanggan->nama }}</td>
                            <td class="align-middle">{{ $row->pelanggan->alamat }}</td>
                            <td class="align-middle">
                                {{ $row->golongan->nama . ' - ' . $row->golongan->deskripsi }}
                            </td>
                            <td class="align-middle">
                                {{ number_format($row->harga_air + $row->biaya_retribusi + $row->biaya_jasa_lingkungan + $row->biaya_pemeliharaan + $row->biaya_administrasi + $row->biaya_materai + $row->biaya_ppn - $row->diskon + $row->biaya_denda) }}
                            </td>
                            <td class="align-middle"><small>{!! $row->kasir . '<br>' . $row->waktu_bayar !!}</small></td>
                            @role('super-admin|administrator')
                                <td class="with-btn-group align-middle text-right" nowrap>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($key === $row->getKey())
                                            <a href="javascript:;" wire:click="hapus" class="btn btn-danger">Ya, Batal</a>
                                            <a wire:click="setKey" href="javascript:;" class="btn btn-success">Batal</a>
                                        @else
                                            <a href="javascript:;" wire:click="setKey({{ $row->getKey() }})"
                                                class="btn btn-danger">Batal</a>
                                            <a href="javascript:;" wire:click="cetak({{ $row->getKey() }})"
                                                class="btn btn-primary">Kwitansi</a>
                                        @endif
                                    </div>
                                </td>
                            @endrole
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer form-inline">
            <div class="col-md-6 col-lg-10 col-xl-10 col-xs-12">
                {{ $data->links() }}
            </div>
            <div class="col-md-6 col-lg-2 col-xl-2 col-xs-12">
                <label class="pull-right">Jumlah Data : {{ $data->total() }}</label>
            </div>
        </div>
    </div>

    <x-modal />

    <div wire:loading>
        <x-loading />
    </div>

    @push('scripts')
        <script>
            Livewire.on('cetak', id => {
                $('#modal-cetak').modal('show');
            });
        </script>
    @endpush
</div>
