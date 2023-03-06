<div>
    <div>
        @section('title', 'Daftar Pembatalan Rek. Air')

        @section('page')
            <li class="breadcrumb-item">Cetak</li>
            <li class="breadcrumb-item active">Daftar Pembatalan Rek. Air</li>
        @endsection

        <h1 class="page-header">Daftar Pembatalan Rek. Air</h1>

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
                @include('cetak.daftarpembatalanrekair')
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
