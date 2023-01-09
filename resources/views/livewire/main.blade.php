@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        @yield('page')
    </ol>
    {{ $slot }}
@endsection

@push('scripts')
    <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
@endpush
