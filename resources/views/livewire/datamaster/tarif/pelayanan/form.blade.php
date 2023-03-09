<div>
    @section('title', 'Tarif Pelayanan/Sangsi')
    @section('page')
        <li class="breadcrumb-item">Data Master</li>
        <li class="breadcrumb-item">Tarif</li>
        <li class="breadcrumb-item">Pelayanan/Sangsi</li>
        <li class="breadcrumb-item active">{{ $key ? 'Edit' : 'Tambah' }} Data</li>
    @endsection

    <h1 class="page-header">Tarif Pelayanan/Sangsi <small>{{ $key ? 'Edit' : 'Tambah' }} Data</small></h1>

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
                    <label for="control-label">Jenis Pelayanan</label>
                    <select wire:model.defer="jenis" class="form-control selectpicker" data-live-search="true"
                        data-width="100%">
                        <option selected hidden>-- Pilih Pelayanan/Sangsi --</option>
                        <option value="Biaya penyambungan kembali 3 bulan tercabut">Biaya penyambungan kembali
                            3 bulan tercabut</option>
                        <option value="Biaya penyambungan kembali 6 bulan tercabut">Biaya penyambungan kembali
                            6 bulan tercabut</option>
                        <option value="Biaya penyambungan kembali diatas 6 bulan/sudah dibongkar">
                            Biaya penyambungan kembali diatas 6 bulan/sudah dibongkar
                        </option>
                        <option value="Biaya buka segel penutupan sementara atas permintaan pelanggan">Biaya buka
                            segel penutupan sementara atas permintaan pelanggan</option>
                        <option value="Biaya ganti meter air">Biaya ganti meter air
                        </option>
                        <option value="Biaya balik nama/alih hak">Biaya balik nama/alih hak</option>
                        <option value="Biaya administrasi depo air minum isi ulang">Biaya administrasi depo air minum
                            isi ulang</option>
                        <option value="Biaya pemindahan meter air">Biaya pemindahan meter air</option>
                        <option value="Biaya administrasi rekomendasi pembangunan perumahan">Biaya administrasi
                            rekomendasi pembangunan perumahan</option>
                        <option value="Biaya tangki 4 m3 luar kota">Biaya tangki 4 m3 luar kota</option>
                        <option value="Biaya tangki 4 m3 dalam kota">Biaya tangki 4 m3 dalam kota</option>
                        <option value="Denda pencurian air">Denda pencurian air</option>
                        <option value="Denda pemindahan meter tanpa sepengetahuan Perumdam Batu Lanteh">Denda pemindahan
                            meter tanpa sepengetahuan Perumdam Batu Lanteh</option>
                        <option value="Denda sambungan gelap/penyadapan">Denda sambungan gelap/penyadapan
                        </option>
                    </select>
                    @error('jenis')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="control-label">Jenis Pelanggan</label>
                    <select wire:model.defer="pelanggan" class="form-control selectpicker" data-live-search="true"
                        data-width="100%">
                        <option selected hidden>-- Pilih Jenis Pelanggan --</option>
                        <option value="">Non Pelanggan</option>
                        <option value="1">Pelanggan Aktif</option>
                        <option value="2">Pelanggan Segel</option>
                        <option value="3">Pelanggan Bongkar</option>
                    </select>
                    @error('pelanggan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <input class="form-control" type="text" autocomplete="off" wire:model.defer="keterangan" />
                    @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="control-label">Nilai</label>
                    <input class="form-control" type="number" autocomplete="off" step="any"
                        wire:model.defer="nilai" />
                    @error('nilai')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="control-label">Diameter</label>
                    <select wire:model.defer="kecamatanId" class="form-control selectpicker" data-live-search="true"
                        data-width="100%">
                        <option selected hidden>-- Pilih Diameter --</option>
                        @foreach (\App\Models\Diameter::orderBy('ukuran')->get() as $row)
                            <option value="{{ $row->getKey() }}">{{ $row->ukuran }}</option>
                        @endforeach
                    </select>
                    @error('kecamatanId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="panel-footer">
                @role('administrator|super-admin')
                    <input type="submit" value="Simpan" class="btn btn-success m-r-3" />
                @endrole
                <a href="{{ route('datamaster.tarif.pelayanan') }}" class="btn btn-danger">Batal</a>
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
