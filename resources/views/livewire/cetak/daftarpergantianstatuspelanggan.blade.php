<div>
    <div>
        @section('title', 'Daftar Pergantian Status Pelanggan')

        @section('page')
            <li class="breadcrumb-item">Cetak</li>
            <li class="breadcrumb-item active">Daftar Pergantian Status Pelanggan</li>
        @endsection

        <h1 class="page-header">Daftar Pergantian Status Pelanggan</h1>

        <x-alert />

        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
            <!-- begin panel-heading -->
            <div class="panel-heading" wire:loading.remove>
                <div class="form-inline width-full">
                    <div class="form-group">
                        <input type="date" wire:model="tanggal" class="form-control">
                    </div>&nbsp;
                    <button class="btn btn-info" wire:click="cetak">Cetak</button>
                </div>
            </div>
            <div class="panel-body table-responsive">
                @include('cetak.daftarpergantianstatuspelanggan')
            </div>
        </div>

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
                Livewire.on('reinitialize', id => {
                    $('.selectpicker').selectpicker();
                });

                Livewire.on('cetak', id => {
                    $('#modal-cetak').modal('show');
                });
            </script>
        @endpush
    </div>

</div>
